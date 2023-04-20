<!DOCTYPE html>
<html lang="EN">
<?php
/*
Player display page
only avalible if logged in and a campaign is selected
*/
session_start();
if (empty($_SESSION['token'])) {
	$url='login.php';//redirect to account	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
$token = $_SESSION['token'];
include_once("../Controllers/Player_character_controller.php");
include_once("../Controllers/campaign_controller.php");
include_once("../Controllers/message_controller.php");
include_once("../Controllers/user_controller.php");
include_once("../Controllers/npc_character_controller.php");
include_once("../Controllers/shared_image_controller.php");
include_once("../Controllers/invite_controller.php");
include_once("../Controllers/item_controller.php");
include_once("../functions_php/errors.php");
include_once("../functions_php/chat_functions.php");

if (empty($_SESSION['login'])) {
	$url='login.php';//redirect to login	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}elseif(empty($_SESSION["Campaign"])){
	$url='launch_selection.php';//redirect to launch	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
$user          = new UserController(null,null);
$user_class    = ($user->getUserByUsername($_SESSION['login']));
$user_id       = $user_class->id;
$userName	   = $_SESSION['login'];
$campaign_id   = $_SESSION["Campaign"];
$role	       = $_SESSION["role"];

	if (isset($_POST["Open_Details_Character"])) {
		if (hash_equals($_SESSION['token'], $_POST['token'])) {
		$_SESSION['current_character']= filter_var($_POST['user_character'],FILTER_SANITIZE_STRING);
		?>
		<script>window.open("character_details.php");
		 window.location.replace("player_pannel.php"); 
		</script>
		<?php
		}else{
			tokenError();
		}
	}

	if (isset($_POST["Open_Details_Item"])) {
		if (hash_equals($_SESSION['token'], $_POST['token'])) {
			
		$_SESSION['current_item']=filter_var($_POST['item_id'], FILTER_SANITIZE_STRING) ;
		?>
		<script> window.open("item_details.php");
		window.location.replace("player_pannel.php"); </script>
		<?php
		}else{
			tokenError();
		}		
	}

	if (isset($_POST["Open_notes"])) {
		if (hash_equals($_SESSION['token'], $_POST['token'])) {	
		?>
		<script>window.open("notes_pannel.php");
		 window.location.replace("player_pannel.php"); 
		</script>
		<?php
		}else{
			tokenError();
		}
	}

	if (isset($_POST["manage_campaign"])) {
		if (hash_equals($_SESSION['token'], $_POST['token'])) {	
		?>
		<script>window.location.replace("manage_campaign.php");
		 
		</script>
		<?php
		}else{
			tokenError();
		}
	}

/* Start of the displayed page */
?>

<style>
	.grid-container{
		<?php $back_image_model    = new SharedImageController(null,null);?>
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
	<script src="../Components/footer.js" type="text/javascript" defer></script>
	<script src="../Components/chat_buttons.js" type="text/javascript" defer></script>
	<script src="../Components/open_refresh.js" type="text/javascript" defer></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<!-- jQuery used in accordance with the license https://jquery.org/license/-->
	<title> Final Year Project</title>
</head>
<body>
<header-component></header-component> 
	<main>
	<?php
	if ((session_id() == '' || !isset($_SESSION['login'])) || ($_SESSION['role']!= "PLAYER")){
			$url='login.php';				
					echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
	}else{
	?>
	<section id="Grid">
	<div class="grid-container">
		<div class="item1">
			<?php
			$campaign= new CampaignController(null,null);
			$current_campaign= $campaign->showCampaignById($campaign_id); 
			$invite=new InviteController(null,null);
			?>	
			<h3>Active Players:</br><?php $invite->showAllPlayers($campaign_id);?> </h3>
		</div>
	
		<div class="item2">
			<div class= "characters">
				<button type="button" class="collapsible" >Player Characters</button>
				<div class="content">
					<?php
						$Player_character= new PlayerCharacterController(null,null);
						$current_character= $Player_character->showMyCampainCharacters($campaign_id,$user_id,$token); 
					?>
				</div>
			</div>

			<div class= "characters">
				<button type="button" class="collapsible" >Items</button>
				<div class="content">
					<?php
						$item_model= new itemController(null,null);
						$current_item= $item_model->showMyItems($campaign_id,$user_id,$token); 
					?>
				</div>
			</div>
	</div>
	
	<div class="item3">
		<div class= "shared_image">
			<?php
				$image_model=new SharedImageController(null,null);
				$image= $image_model->getActiveimage($campaign_id);
					if($image!=null){
						$path=$image->path;
						?>
						<img src="<?php echo $path ?>" alt= "Shared_image" >
						<?php } ?>
		</div>
		<script >
		var $image_view = $(".shared_image");
			setInterval(function () {
				$image_view.load("player_pannel.php .shared_image");
			}, 3000);
		</script>
	</div>  
	<div class="item4" >Chat
		</br>
		<h2> Chat Will Appear Bellow:</h2>
		<div class="chatbox" >
			<div class ="chatbox_content" >
			<?php
				$message= new MessageController(null,null);
				$messages= $message->showMessageByCampaignId($campaign_id,$user_id); 
			?>
			<script >
				var $chatbox = $(".chatbox_content");
				setInterval(function () {
					$chatbox.load("player_pannel.php .chatbox_content");
					}, 3000);
			</script>
			</div>
		</div>
	</div>
	<div class="item5">
		<div class = "insert_message">
			<form action="" method="post" >
			<input type="button" value="Whisper" onclick=" whisperClick()">
			<input type="button" value="Dice Roller" onclick="diceClick()"></br>
			<input type="hidden" name="token" value="<?php echo $token; ?>" />
			<input type="hidden" name="page" value="player_pannel.php" />
            <input type="text" id="message" name= "messageText"></br></br>
			<input type="submit" value="Send" name= "messageSend">
			</form>
		</div>
	</div>
	
	<div class="item6"> </br>
		<form action="" method="post" >
			<input type="hidden" name="token" value="<?php echo $token; ?>" />
			<input type="submit" value="Notes" name= "Open_notes">
		</form>
		<form action="" method="post" >
			<input type="hidden" name="token" value="<?php echo $token; ?>" />
			<input type="submit" value="Manage Campaign" name= "manage_campaign">
		</form>
	</div>
	<div class="item7"> </br>
		<button type= "button" onclick="location.href='character_creation.php';">Create New Character</button>
	</div>
	
	</div>
	</div>
	</div>
	</div>
		
	</section>
		
	</main>
	<?php 
	}
	?>
<footer-component></footer-component>


</body>
<?php }} ?>
</html>
