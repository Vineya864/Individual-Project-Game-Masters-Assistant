<!DOCTYPE html>
<html lang="EN">

<?php
/**
 * see information about npc character only avalible to the gm 
 */
include_once("../Controllers/user_controller.php");

include_once("../Controllers/status_effects_controller.php");
include_once("../Controllers/campaign_controller.php");
include_once("../views/status_effects_view.php");
session_start();
//redirects
if (empty($_SESSION['token'])) {
	$url='login.php';//redirect to login	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
$token = $_SESSION['token'];
if (empty($_SESSION['login'])) {
	$url='login.php';//redirect to login	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}elseif(empty($_SESSION["Campaign"])){
	$url='launch_selection.php';//redirect to launch	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
if($_SESSION['role']!="GM"){
	$url='launch_selection.php';//redirect to launch	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
$user           = new UserController(null,null);
$user_class     = ($user->getUserByUsername($_SESSION['login']));
$user_id        = $user_class->id;
$campaign_id    = $_SESSION["Campaign"];
$effect_id      = $_SESSION["current_effect"];
$effect_model   = new StatusEffectController (null,null);
$effect         = $effect_model->getEffectById($effect_id);
$campaign_model = new CampaignController(null,null);
//edit functions
if (isset($_POST["Delete_Effect"])) {
	$effect_model->delete_effect($effect_id);
	echo "<script>window.close();</script>";
	
}

if (isset($_POST["Edit_Effect"])) {
	$effect_model->edit_effect(filter_var($_REQUEST['name'], FILTER_SANITIZE_STRING),filter_var($_REQUEST['note_text'], FILTER_SANITIZE_STRING),$effect_id);
	$url='effect_details.php';
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
	
}

if (isset($_POST["return-to-main"])) {
	echo "<script>window.close();</script>";
}


if($user_id!=$campaign_model->getGMByCampagin((($effect_model->get_campaign($effect_id))))){
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
    $view = new StatusEffectView();
	$view->displayeffectSheet($effect);

    ?>
	<div id="character_sheet">


	<button type="button" class="collapsible" >Edit Effect</button>
	<div class="content">
	<form method = "post" action= "">
				<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
				<input type  = "hidden" name="user" value="<?php echo $_SESSION['login']; ?>" />
				<p>Name</p>
				<input type  = "text"   name="name" value="<?php echo $effect->EFFECT_NAME; ?>" /></br>
				<p>Notes</p>
				<textarea id ="note_text" name="note_text"><?php echo $effect->NOTES?></textarea></br>
				<input type  = "submit" name="Edit_Effect" value="Save Changes"/>
	</form>
	</br></br>
	<form method = "post" action= "">
				<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
				<input type  = "hidden" name="user" value="<?php echo $_SESSION['login']; ?>" />
				<input type  = "submit" name="Delete_Effect" value="Delete Effect"/>
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
