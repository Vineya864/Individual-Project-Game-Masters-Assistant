<!DOCTYPE html>
<html lang="EN">
<?php
/*
GM display page
only avalible if logge in and a campaign is selected
along side models also uses the error.php file and the add_image.php file
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
include_once("../Controllers/npc_monster_controller.php");
include_once("../Controllers/status_effects_controller.php");
include_once("../Controllers/shared_image_controller.php");
include_once("../Controllers/invite_controller.php");
include_once("../Controllers/item_controller.php");
include_once("../functions_php/errors.php");
include_once("../functions_php/chat_functions.php");
if (empty($_SESSION['login'])) {
	$url='login.php';//redirect to account	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}elseif(empty($_SESSION["Campaign"])){
	$url='launch_selection.php';//redirect to account	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
$user           = new UserController(null,null);
$user_class     = ($user->getUserByUsername($_SESSION['login']));
$user_id        = $user_class->id;
$userName	    = $_SESSION['login'];
$campaign_id    = $_SESSION["Campaign"];
$role	        = $_SESSION["role"];
$image_model    = new SharedImageController(null,null);
$campaign_model = new CampaignController(null,null);
?>
<style>
	.grid-container{
		<?php $back_image_model    = new SharedImageController(null,null);?>
		background-image: url("<?php echo ($back_image_model->getBackGroundimage($campaign_id))->path;?>");
	}
</style>
<?php

	if (isset($_POST["Open_Details_Character"])) {
		if (hash_equals($_SESSION['token'], $_POST['token'])) {
		$_SESSION['current_character']= filter_var($_POST['user_character'], FILTER_SANITIZE_STRING);
		?>
		<script>window.open("character_details.php");
		 window.location.replace("gm_pannel.php"); 
		</script>
		<?php
		}else{
			tokenError();
		}
	}
	if (isset($_POST["Open_notes"])) {
		if (hash_equals($_SESSION['token'], $_POST['token'])) {	
		?>
		<script>window.open("notes_pannel.php");
		 window.location.replace("gm_pannel.php"); 
		</script>
		<?php
		}else{
			tokenError();
		}
	}

	if (isset($_POST["manage_campaign"])) {
		if (hash_equals($_SESSION['token'], $_POST['token'])) {	
		?>
		<script>window.location.replace("manage_campaign.php");</script>
		<?php
		}else{
			tokenError();
		}
	}

	if(isset($_POST["hide_images"])){
		if($user_id==$campaign_model->getGMByCampagin($campaign_id)){
		$image_model->clearImages($campaign_id);
		}
	}
	
	if(isset($_POST["hide_back"])){
		if($user_id==$campaign_model->getGMByCampagin($campaign_id)){
		$image_model->clearBack($campaign_id);
		?><script> window.location.replace("gm_pannel.php"); </script>	<?php
		}
	}


	if (isset($_POST["Ground_Image"])){
		$image_campaign=$image_model->getCampaign(filter_var($_POST['image_id'], FILTER_SANITIZE_STRING));
		if($user_id==$campaign_model->getGMByCampagin($image_campaign)){
			$image_model->setBackGroundImage(filter_var($_POST['image_id'], FILTER_SANITIZE_STRING),$campaign_id);
			?><script> window.location.replace("gm_pannel.php"); </script>	<?php
		}
	}
	if (isset($_POST["Change_Image"])) {
		$image_campaign=$image_model->getCampaign(filter_var($_POST['image_id'], FILTER_SANITIZE_STRING));
		if($user_id==$campaign_model->getGMByCampagin($image_campaign)){
			$image_model->shareImage(filter_var($_POST['image_id'], FILTER_SANITIZE_STRING),$campaign_id);	
		}
		}
	if (isset($_POST["Delete_Image"])) {
		if (hash_equals($_SESSION['token'], $_POST['token'])) {
			$image_campaign=$image_model->getCampaign(filter_var($_POST['image_id'], FILTER_SANITIZE_STRING));
			if($user_id==$campaign_model->getGMByCampagin($image_campaign)){
				$image_model->deleteImage(filter_var($_POST['image_id'], FILTER_SANITIZE_STRING));
			}
		
		?>
		<script>
		//window.location.replace("gm_pannel.php"); 
	    </script>
	    <?php	
		}else{
			tokenError();
		}
	}
	if (isset($_POST["Open_Details_NPC"])) {
		if (hash_equals($_SESSION['token'], $_POST['token'])) {
			
		$_SESSION['current_npc']=filter_var($_POST['user_character'], FILTER_SANITIZE_STRING) ;
		?>
		<script> window.open("npc_details.php");
		window.location.replace("gm_pannel.php"); </script>
		<?php
		}else{
			tokenError();
		}
		
	}
	if (isset($_POST["Open_Details_Monster"])) {
		if (hash_equals($_SESSION['token'], $_POST['token'])) {
			
		$_SESSION['current_monster']=filter_var($_POST['user_character'], FILTER_SANITIZE_STRING) ;
		?>
		<script> window.open("monster_details.php");
		window.location.replace("gm_pannel.php"); </script>
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
		window.location.replace("gm_pannel.php"); </script>
		<?php
		}else{
			tokenError();
		}	
	}

	if (isset($_POST["Open_Details_Effect"])) {
		if (hash_equals($_SESSION['token'], $_POST['token'])) {
		$_SESSION['current_effect']= $_POST['status_effect'];
		?>
		<script> window.open("effect_details.php");
		window.location.replace("gm_pannel.php"); </script>
		<?php
		}else{
			tokenError();
		}
		
	}
/*start of display page */
?>
<head>
	<meta charset ="UTF-8"/>
	  <link href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.2.0/normalize.min.css" rel="stylesheet" />
	<link href="../Css/style_main.css" rel="stylesheet" />
	<link href="../Css/sizing.css" rel="stylesheet" />
	<script src="../Components/header.js" type="text/javascript" defer></script>
	<script src="../Components/collapsible_menu.js" type="text/javascript" defer></script>
	<script src="../components/footer.js" type="text/javascript" defer></script>
	<script src="../components/chat_buttons.js" type="text/javascript" defer></script>
	<script src="../components/open_refresh.js" type="text/javascript" defer></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<!-- jQuery used in accordance with the licence https://jquery.org/license/-->
	<title> Final Year Project</title>
</head>

<body>
<header-component></header-component> 
	<main>
	<?php
	if ((session_id() == '' || !isset($_SESSION['login'])) || ($_SESSION['role']!= "GM")){
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
						$current_character= $Player_character->showCampainCharacters($campaign_id,$token); 

					?>
	
				</div>
			</div>
		<div class= "characters">
			<button type="button" class="collapsible" >Active NPC'S</button>
				<div class="content">

				<?php
					$NPC_character= new NPCCharacterController(null,null);	
					$current_character= $NPC_character->showCampainCharacters($campaign_id,$token); 
				?>
				</div>
		</div>
		<div class= "characters">
			<button type="button" class="collapsible" >Active Items</button>
				<div class="content">

				<?php
					$item= new ItemController(null,null);	
					$current_item= $item->showCampainItems($campaign_id,$token); 
				?>
				</div>
		</div>
		<div class= "characters">
			<button type="button" class="collapsible" >Active Monsters</button>
				<div class="content">

				<?php
					$item= new NPCMonsterController(null,null);	
					$current_item= $item->showCampainMonster($campaign_id,$token); 
				?>
				</div>
		</div>

		<div class= "characters">
			<button type="button" class="collapsible" >Active Effects</button>
				<div class="content">
				<?php
					$effect= new StatusEffectController(null,null);	
					$current_effect= $effect->showCampaignEffect($campaign_id,$token); 
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
				$image_view.load("gm_pannel.php .shared_image");
			}, 3000);
		</script>
	</div>  
	<div class="item4" >
		<h3>Chat</h3>
		<h3> Messages:</h3>
		<div class="chatbox" >
			<div class ="chatbox_content" >
			<?php
				$message= new MessageController(null,null);
				$messages= $message->showMessageByCampaignId($campaign_id,$user_id); 
			?>
			<script >
				var $chatbox = $(".chatbox_content");
				setInterval(function () {
					$chatbox.load("gm_pannel.php .chatbox_content");
					}, 3000);
			</script>
			</div>
		</div>
	</div>
	<div class="item5">
		<h3>Send Message </h3>
		<div class = "insert_message">
			<form action="" method="post" >
			<input type="button" value="Whisper" onclick=" whisperClick()">
			<input type="button" value="Announce" onclick= "announceClick()">
			<input type="button" value="Dice Roller" onclick="diceClick()"></br>
			<input type="hidden" name="token" value="<?php echo $token; ?>" />
			<input type="hidden" name="page" value="gm_pannel.php" />
			<input type="text" id="message" name= "messageText"></br>
			<input type="submit" value="Send" name= "messageSend">
			</form>
		</div>
	</div>
	
	<div class="item6">
		<h3>Tools</h3> 
		<form action="" method="post" >
			<input type="hidden" name="token" value="<?php echo $token; ?>" />
			<input type="submit" value="Notes" name= "Open_notes"></br>
			<input type="submit" value="Manage Campaign" name= "manage_campaign">
		</form>
		<button type= "button" onclick="location.href='see_npc.php';">Manage NPCs</button></br>
		<button type= "button" onclick="location.href='see_monsters.php';">Manage Monsters</button></br>
		<button type= "button" onclick="location.href='see_items.php';">Manage Items'</button></br>
		<button type= "button" onclick="location.href='see_effect.php';">Manage Status Effects</button></br>
		<button type= "button" onclick="location.href='character_creation.php';">Create New Player Character</button>

	</div>
	<div class= "item7">
		<h3>Images</h3>
		<div class = "images">
			<button type="button" class="collapsible" >Display Image</button>
			<div class="content">
				<div id="image_selection">
					<h2>Images</h2>
				<?php
				$image_model->showCampainImages($campaign_id,$token); 
				?>
				</div>
				</div>	
		<button type="button" class="collapsible" >Upload New Image</button>
		<div class="content">
				<form action="add_photo.php" method="post" enctype="multipart/form-data">
				<input type="file" name="fileToUpload" id="fileToUpload" required>
				<input type="hidden" name="token" value="<?php echo $token; ?>" />
				<input type="hidden" name="source" value="gm_pannel.php" />
  				<input type="submit" value="Upload Image" name="submit">
				</form>
		</div>
				<form action="" method="post">
				<input type="hidden" name="token" value="<?php echo $token; ?>" />
  				<input type="submit" value="Clear Image" name="hide_images"></br>
				<input type="submit" value="Clear Wallpaper" name="hide_back">
				</form>
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
