<!DOCTYPE html>
<html lang="EN">
<?php
/**screen is avaible to both players and gm but will be view diffrently gm has more options and allows addition, removal of players
 * chaning ownership of the campaign
 * deletion of the camapign
 * players are only able to leave campaig
 */
session_start();
if (empty($_SESSION['token'])) {
	$url='login.php';//redirect to login	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
$token = $_SESSION['token'];
include_once("../Controllers/Player_character_controller.php");
include_once("../Controllers/campaign_controller.php");
include_once("../Controllers/user_controller.php");
include_once("../Controllers/invite_controller.php");
include_once("../Controllers/npc_character_controller.php");
include_once("../Controllers/item_controller.php");
include_once("../functions_php/errors.php");
include_once("../Controllers/campaign_notes_controller.php");
include_once("../Controllers/status_effects_controller.php");
include_once("../Controllers/shared_image_controller.php");
if (empty($_SESSION['login'])) {
	$url='login.php';//redirect to login	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}elseif(empty($_SESSION["Campaign"])){
	$url='launch_selection.php';//redirect to launch	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
$user            = new UserController(null,null);
$npc_class       = new NPCCharacterController(null,null);
$invite          = new InviteController(null,null);
$campaign_class  = new CampaignController(null,null);
$item_class      = new ItemController(null,null);
$notes_class     = new CampaignNotesController(null,null);
$image_class	 = new SharedImageController(null,null);
$character_class = new PlayerCharacterController(null,null);
$effect_class    = new StatusEffectController(null,null);	
$user_class      = ($user->getUserByUsername($_SESSION['login']));
$user_id         = $user_class->id;
$userName	     = $_SESSION['login'];
$campaign_id     = $_SESSION["Campaign"];
$role	         = $_SESSION["role"];
?>

<?php
	

?>
<head>
	<meta charset ="UTF-8"/>
	  <link href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.2.0/normalize.min.css" rel="stylesheet" />
	<link href="../Css/style_main.css" rel="stylesheet" />
	<link href="../Css/sizing.css" rel="stylesheet" />
	<script src="../Components/header.js" type="text/javascript" defer></script>
	<script src="../components/footer.js" type="text/javascript" defer></script>

	
	<title> Final Year Project		
	</title>

</head>

<body>
<header-component></header-component> 

	
	<main>

	<?php
	if ((session_id() == '' || !isset($_SESSION['login'])) ){
			$url='login.php';		
			echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
	}else{

		if (isset($_POST["return-to-main"])) {
			if($_SESSION['role']== "GM"){
			echo "<script>window.location.replace('gm_pannel.php');</script>";
			}else{
				echo "<script>window.location.replace('player_pannel.php');</script>";
			}
		}


	?>

	<div class="return-to-main">
	<form method = "post" action= "">
				<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
				<input type  = "submit" name="return-to-main" value="Back"/>
	</form>
	</div>
	<section class= "management_title">
	<h1>
	Current players
	</h1>
	<?php
	$invite->showAllPlayers($campaign_id);
	?>

	<?php
	if($_SESSION['role']== "GM"){
	?>
	<h2> Add Player </h2>
	<form method ="post" action="">
	<input type  = "String" name = "name" placeholder="UserName" required/> 	
	<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
	<input type  = "submit" name="add_player" value="Add Player"/>
	</form>
<?php
if (isset($_POST["add_player"])) {
	if (hash_equals($_SESSION['token'], $_POST['token'])) {	
	$name=filter_var($_REQUEST['name'],FILTER_SANITIZE_STRING);
	$add_user=($user->getIdByUsername($name));
	if(is_numeric($add_user)){
		$result=$invite->send_invite($add_user, $_SESSION["Campaign"]);
		echo 'Invite Sent';
	}
	else{
		echo 'No User Found';
	}
}else{
	tokenError();
}
	
}

?>
	<h2> Remove Player </h2>
	<form method ="post" action="">
	<input type  = "String" name = "name" placeholder="UserName" required/> 	
	<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
	<input type  = "submit" name="remove_player" value="Remove Player"/>
	</form>
<?php
if (isset($_POST["remove_player"])) {
	if (hash_equals($_SESSION['token'], $_POST['token'])) {	
	$name=filter_var($_REQUEST['name'],FILTER_SANITIZE_STRING);
	$remove_user=($user->getIdByUsername($name));
	if(is_numeric($remove_user)){
		$id=$invite->getIdByUserIdCampaignId($remove_user,$campaign_id);
		if(is_numeric($id)){
			$result=$invite->remove_invite($id);
			echo 'player Removed';
		}
	}
	else{
		echo 'No User Found';
	}	
}else{
	tokenError();
}
}
?>
	<h2> Change Game Master </h2>
	<form method ="post" action="">
	<input type  = "String" name = "name" placeholder="UserName" required/> 	
	<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
	<input type  = "submit" name="change_master" value="Change Game Master"/>
	</form>
	<?php
if (isset($_POST["change_master"])) {
	if (hash_equals($_SESSION['token'], $_POST['token'])) {	
	$name=filter_var($_REQUEST['name'],FILTER_SANITIZE_STRING);
	$change_user=($user->getIdByUsername($name));
	if(is_numeric($change_user)){
		$id=$invite->getIdByUserIdCampaignId($change_user,$campaign_id);
		if(is_numeric($id)){
			$result=$campaign_class->change_master($campaign_id,$change_user);
			echo 'Game Master Changed';
			echo "<script>window.location.replace('index.php');</script>";
		}else{
			echo 'Requested user has not been invited to the campaign';
		}
	}
	else{
		echo 'No User Found';
	}
}else{
	tokenError();
}	
}
?>
	<h2> Delete Campaign </h2>
	<form method ="post" action="">
	<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
	<input type  = "submit" name="delete_campaign" value="Delete Campaign"/>
	</form>
<?php
if (isset($_POST["delete_campaign"])) {
	if (hash_equals($_SESSION['token'], $_POST['token'])) {	
		if($user_id==$campaign_class->getGMByCampagin($campaign_id)){
			$invite->delete_campaign($campaign_id);
			$item_class->delete_campaign($campaign_id);
			$character_class->delete_campaign($campaign_id);
			$campaign_class->delete_campaign($campaign_id);
			$npc_class-> delete_campaign($campaign_id);
			$notes_class-> delete_campaign($campaign_id);
			$image_class-> delete_campaign($campaign_id);
			$effect_class-> delete_campaign($campaign_id);
			$url='index.php';
		}else{
			$url='login.php';
		}		
			echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';

}else{
	tokenError();
}
}
?>
<?php
}
else{
	?>
	<h2> Leave Campaign </h2>
	<form method ="post" action=""> 	
	<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
	<input type  = "submit" name="leave" value="Leave Campaign"/>
	</form>


	<?php
	if (isset($_POST["leave"])) {
		if (hash_equals($_SESSION['token'], $_POST['token'])) {	
		if($_SESSION['role']=="PLAYER"){
				$search_id=$invite->getIdByUserIdCampaignId($user_id,$campaign_id);
				$invite->resolve_invite($search_id, '0');
				echo "<script>window.location.replace('index.php');</script>";
		}
	}else{
		tokenError();
	}
	}	
}
?>
</section>
	</main>
	<?php 
	}
	?>
	<section class= "profile_footer">
<footer-component></footer-component>
</section>

</body>
<?php }} ?>
</html>
