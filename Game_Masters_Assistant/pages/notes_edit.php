<!DOCTYPE html>
<html lang="EN">

<?php
/**
 * edit or delete a note otakes the note selected from the notes pannel as an input
 */
include_once("../views/campaign_notes.php");
include_once("../Controllers/campaign_notes_controller.php");
include_once("../views/campaign_notes_view.php");
include_once("../Controllers/user_controller.php");
include_once("../functions_php/errors.php");
session_start();

$token = $_SESSION['token'];

$note_class		= new CampaignNotesController(null, null);
$user           = new UserController(null,null);
if (empty($_SESSION['login'])) {
	$url='login.php';//redirect to account	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}elseif(empty($_SESSION["Campaign"])){
	$url='launch_selection.php';//redirect to account	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}elseif(!$note_class->check_owner($user->getIdByUsername($_SESSION['login']),$_SESSION['current_note'])){
	$url='login.php';//redirect to account	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{

$note			= $note_class->getNoteByID($_SESSION['current_note']);

if (isset($_POST["return-to-main"])) {
	?>
	<script>
	window.location.replace("notes_pannel.php"); 
    </script>
	<?php
}


if (isset($_POST["save_changes"])) {
	if( hash_equals($_SESSION['token'], $_POST['token'])){
	$note_class->edit_note(filter_var($_REQUEST['note_chapter'], FILTER_SANITIZE_STRING),filter_var($_REQUEST['note_text'], FILTER_SANITIZE_STRING),$note->id);
	?><script>
	window.location.replace("notes_pannel.php"); 
	</script>
	<?php
	}
	else{
		tokenError();
	}
}

if (isset($_POST["delete_note"])) {
	if( hash_equals($_SESSION['token'], $_POST['token'])){
	$note_class->delete_note($note->id);
	?><script>
	window.location.replace("notes_pannel.php"); 
	</script>
	<?php
	}
	else{
		tokenError();
	}
}




?>
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


	
	<?php


	?>


</head>

<body>
<header-component></header-component> 

	
	<div class="return-to-main">
	<form method = "post" action= "">
				<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
				<input type  = "hidden" name="user" value="<?php echo $_SESSION['login']; ?>" />
				<input type  = "submit" name="return-to-main" value="Back"/>
	</form>
	</div>
	<main>
	<div class="edit-note">
	<form name="edit_note" method = "post" action= "">
		<input type  ="text" name="note_chapter" value= "<?php echo $note->chapter ?>"><br/>
		<textarea id ="note_text" name="note_text"><?php echo $note->notes?></textarea></br>
		<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
		<input type  = "submit" name="save_changes" value="Save Changes"/>
	</form><br/>
	</div>
	<div class="edit-note">
	<div id="delete_button">
				<form method = "post" action= "">
				<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
				<input type  = "submit" name="delete_note" value="Delete Note"/>
				</form>
	</div>
</div>
	</main>
	<section class= "index_footer">
<footer-component></footer-component>

</section>
</body>
	<?php } ?>
</html>
