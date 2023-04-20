<!DOCTYPE html>
<html lang="EN">

<?php
/*display the character sheet allows editing if owner or gm, check for ownership is performed before page shown
can be accessed outside of the campaign */

include_once("../Controllers/user_controller.php");
include_once("../Controllers/campaign_controller.php");
include_once("../Controllers/Player_character_controller.php");
include_once("../views/Player_character_view.php");
session_start();
$token = $_SESSION['token'];
if (empty($_SESSION['login'])) {
	$url='login.php';//redirect to login	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
$charater_model = new  PlayerCharacterController(null,null);
$campaign_model = new CampaignController(null,null);
if(!empty($_SESSION["Campaign"])){
	$campaign_id    = $_SESSION["Campaign"];
}else{
	$_SESSION["Campaign"] = $charater_model->get_character_campaign($_SESSION["current_character"]);
	$campaign_id    = $_SESSION["Campaign"];
}
$user           = new UserController(null,null);
$user_class     = ($user->getUserByUsername($_SESSION['login']));
$user_id        = $user_class->id;
$character_id   = $_SESSION["current_character"];
$character      = $charater_model->getPlayerCharacterById($character_id);

if (($user_id != $charater_model->findOwner($character->CHARACTER_ID)) and ($user_id != $campaign_model->getGMByCampagin(($charater_model->get_character_campaign($character_id))))){
	echo "<script>window.close();</script>";
}else{

if (isset($_POST["Delete_Character"])) {
	if (hash_equals($_SESSION['token'], $_POST['token'])) {
	$charater_model->delete_Character($character_id, $_SESSION["Campaign"],$user_id );
	echo "<script>window.close();</script>";
}
}
if (isset($_POST["Edit_Character"])) {
	if( hash_equals($_SESSION['token'], $_POST['token'])){
	$charater_model->edit_Character(filter_var($_REQUEST['name'], FILTER_SANITIZE_STRING),filter_var($_REQUEST['stats'], FILTER_SANITIZE_STRING),$character_id,filter_var($_REQUEST['character_notes'], FILTER_SANITIZE_STRING));
	$url='character_details.php';//redirect to details	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
	}
	
}
	
if (isset($_POST["return-to-main"])) {
	echo "<script>window.close();</script>";
}


?>
<style>
	main{
		<?php 
		
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
	<script src="../Components/footer.js" type="text/javascript" defer></script>
    
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

	<div id="character_sheet">
    <?php
    $view = new playerCharacterView();
	$view->displayCharacterSheet($character);

    ?>
	
</br>
	<button type="button" class="collapsible" >Edit Character</button>
	<div class="content">
	<form method = "post" action= "">
				<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
				<input type  = "hidden" name="character" value="<?php echo $character->CHARACTER_ID; ?>" />
				<input type  = "hidden" name="user" value="<?php echo $_SESSION['login']; ?>" />
				<p>Name</p>
				<input type  = "text"   name="name" value="<?php echo $character->CHARACTER_NAME; ?>" /></br>
				<p>Stats</p>
				<textarea id ="note_text" name="stats"><?php echo $character->CHARACTER_STATS ?></textarea></br>
				<p>Character Notes</p>
				<textarea id ="note_text" name="character_notes"><?php echo $character->CHARACTER_NOTES ?></textarea></br>
				<input type  = "submit" name="Edit_Character" value="Save Changes"/>
	</form>
	</br></br>
	<form action="add_photo.php" method="post" enctype="multipart/form-data">
				<input type="file" name="fileToUpload" id="fileToUpload" required>
				<input type="hidden" name="token" value="<?php echo $token; ?>" />
				<input type="hidden" name="character_id" value="<?php echo $character->CHARACTER_ID; ?>" />
				<input type="hidden" name="source" value= "character_details.php" />
  				<input type="submit" value="Add Image" name="submit">
	</form>
	</br/></br>
	<form method = "post" action= "">
				<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
				<input type  = "hidden" name="character" value="<?php echo $character->CHARACTER_ID; ?>" />
				<input type  = "hidden" name="user" value="<?php echo $_SESSION['login']; ?>" />
				<input type  = "submit" name="Delete_Character" value="Delete Character"/>
	</form>
	</div>
	<?php
}
	?>
	</div>
</div>
</br></br>
<section class= "profile_footer">
<footer-component></footer-component>
</section>
	</main>


</body>
<?php } ?>
</html>
