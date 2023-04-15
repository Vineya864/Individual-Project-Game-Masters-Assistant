<!DOCTYPE html>
<html lang="EN">

<?php
/**
 * see information about npc character only avalible to the gm 
 */
include_once("../Controllers/user_controller.php");

include_once("../Controllers/npc_character_controller.php");
include_once("../Controllers/campaign_controller.php");
include_once("../views/npc_character_view.php");
session_start();
//redirects
if (empty($_SESSION['token'])) {
	$url='login.php';//redirect to account	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
$token = $_SESSION['token'];
if (empty($_SESSION['login'])) {
	$url='login.php';//redirect to account	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}elseif(empty($_SESSION["Campaign"])){
	$url='launch_selection.php';//redirect to account	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
if($_SESSION['role']!="GM"){
	$url='launch_selection.php';//redirect to account	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
$user           = new UserController(null,null);
$user_class     = ($user->getUserByUsername($_SESSION['login']));
$user_id        = $user_class->id;
$campaign_id    = $_SESSION["Campaign"];
$character_id   = $_SESSION["current_npc"];
$charater_model = new  NPCCharacterController(null,null);
$character      = $charater_model->getNPCCharacterById($character_id);
$campaign_model = new CampaignController(null,null);
//edit functions
if (isset($_POST["Delete_NPC"])) {
	$charater_model->delete_NPC($character_id);
	echo "<script>window.close();</script>";
	
}

if (isset($_POST["Edit_NPC"])) {
	$charater_model->edit_NPC(filter_var($_REQUEST['name'], FILTER_SANITIZE_STRING),filter_var($_REQUEST['stats'], FILTER_SANITIZE_STRING),filter_var($_REQUEST['note_text'], FILTER_SANITIZE_STRING),$character_id);
	$url='npc_details.php';
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
	
}

if (isset($_POST["return-to-main"])) {
	echo "<script>window.close();</script>";
}


if($user_id!=$campaign_model->getGMByCampagin((($charater_model->get_campaign($character_id))))){
	echo "<script>window.close();</script>";
}else{
?>
<style>
	main{
		<?php 
		//set background		
	 	include_once("../Controllers/shared_image_controller.php");
		$back_image_model    = new SharedImageController(null,null);
		?>
		background-image: url("<?php echo ($back_image_model->getBackGroundimage($campaign_id))->path;?>");
	}
</style>
<head>
	<meta charset ="UTF-8"/>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.2.0/normalize.min.css" rel="stylesheet" />
	<link href="../Css/style_main.css" rel="stylesheet" />
	<link href="../Css/sizing.css" rel="stylesheet" />
	<script src="../Components/header.js" type="text/javascript" defer></script>
	<script src="../Components/collapsible_menu.js" type="text/javascript" defer></script>
	<script src="../components/footer.js" type="text/javascript" defer></script>
    
	<title> Final Year Project		
	</title>
	


</head>

<body>
<header-component></header-component> 

	<main>
	<div class="return-to-main">
	<form method = "post" action= "">
				<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
				<input type  = "hidden" name="user" value="<?php echo $_SESSION['login']; ?>" />
				<input type  = "submit" name="return-to-main" value="Close"/>
	</form>
	</div>
	<div>
    <?php
    $view = new NPCCharacterView();
	$view->displayCharacterSheet($character);

    ?>
	<div id="character_sheet">


	<button type="button" class="collapsible" >Edit Character</button>
	<div class="content">
	<form method = "post" action= "">
				<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
				<input type  = "hidden" name="user" value="<?php echo $_SESSION['login']; ?>" />
				<p>Name</p>
				<input type  = "text"   name="name" value="<?php echo $character->NPC_NAME; ?>" /></br>
				<p>Stats</p>
				<textarea id ="stats" name="stats"><?php echo $character->NPC_STATS?></textarea></br>
				<p>Notes</p>
				<textarea id ="note_text" name="note_text"><?php echo $character->NOTES?></textarea></br>
				<input type  = "submit" name="Edit_NPC" value="Save Changes"/>
	</form>
	</br></br>
	<form method = "post" action= "">
				<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
				<input type  = "hidden" name="user" value="<?php echo $_SESSION['login']; ?>" />
				<input type  = "submit" name="Delete_NPC" value="Delete NPC"/>
	</form>
	</div>
</div>
</br></br>
<section class= "profile_footer">
<footer-component></footer-component>
</section>
</main>



</body>
<?php }}}}

?>
</html>
