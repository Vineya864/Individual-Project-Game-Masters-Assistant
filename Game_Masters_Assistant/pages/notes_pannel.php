<!DOCTYPE html>
<html lang="EN">

<?php
/**
 * see all notes made by user for this campaign 
 * see javascript for this kind of drop down menu in tabs.js
 */
include_once("../views/campaign_notes.php");
include_once("../Controllers/campaign_notes_controller.php");
include_once("../views/campaign_notes_view.php");
include_once("../Controllers/user_controller.php");
include_once("../functions_php/errors.php");
session_start();

$token = $_SESSION['token'];
if (empty($_SESSION['login'])) {
	$url='login.php';	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}elseif(empty($_SESSION["Campaign"])){
	$url='launch_selection.php';	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
$user           = new UserController(null,null);
$user_class     = ($user->getUserByUsername($_SESSION['login']));
$user_id        = $user_class->id;
$campaign_id    = $_SESSION["Campaign"];
$note_class		= new CampaignNotesController(null, null);

if (isset($_POST["return-to-main"])) {
	echo "<script>window.close();</script>";
	
}

if (isset($_POST["edit_note"])) {
	if (hash_equals($_SESSION['token'], $_POST['token'])) {
			$_SESSION['current_note']= filter_var($_REQUEST['note_id'], FILTER_SANITIZE_STRING);
	?>
			<script>
	 		window.location.replace("notes_edit.php"); 
			</script>
			<?php
	}else{
		tokenError();
	}
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
	<link href="../Css/tabs.css" rel="stylesheet" />
	<link href="../Css/sizing.css" rel="stylesheet" />
	<script src="../Components/header.js" type="text/javascript" defer></script>
	<script src="../Components/collapsible_menu.js" type="text/javascript" defer></script>
	<script src="../Components/footer.js" type="text/javascript" defer></script>
    <script src="../Components/tabs.js" type="text/javascript" defer></script>
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
	<div id="note_collection">
	<h2>Campaign Notes</h2>
	<p>Click Chapter Title to Access and Edit Notes</p>
	
	<div class= "tab_block">
		<?php
		$note_class->ShowNotes($user_id, $campaign_id,$token);
		?>	
	</div>
	<div class= "create_note">
	<button type= "button" value="create_note" onclick="location.href='note_creation.php';">Create New Chapter</button>
	</div>
	</div>

<section class= "profile_footer">
<footer-component></footer-component>
</section>
</main>

</body>
	<?php } ?>
</html>
