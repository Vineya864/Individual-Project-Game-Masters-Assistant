<!DOCTYPE html>
<html lang="EN">
<?php
/**
 * create a new npc for the npc_characters table there is a seperate screen and table to create monster
 */
?>
<head>
	<meta charset ="UTF-8"/>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.2.0/normalize.min.css" rel="stylesheet" />
	<link href="../Css/style_main.css" rel="stylesheet" />
	<link href="../Css/sizing.css" rel="stylesheet" />
	<script src="../Components/header.js" type="text/javascript" defer></script>
	<script src="../Components/collapsible_menu.js" type="text/javascript" defer></script>
	<script src="../Components/footer.js" type="text/javascript" defer></script>
	<?php
include_once("../Controllers/NPC_character_controller.php");
session_start();
//redirect
if (empty($_SESSION['token'])) {
	$url='login.php';
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
$token = $_SESSION['token'];
if (empty($_SESSION['login'])) {
	$url='login.php';
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
if(empty($_SESSION["Campaign"])){
	$url='launch_selection.php';	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
	if($_SESSION['role']!="GM"){
		$url='launch_selection.php';	
		echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
	}
	//load page
?>
	<title> Final Year Project		
	</title>


<?php
	if (isset($_POST["Create_npc"])) {
		if (isset($_SESSION["login"])) {//if logged in
			if (!empty($_POST['token'])) {//if ther is a token
				if (hash_equals($_SESSION['token'], $_POST['token'])) {//if token matches 
					 $NPC_NAME=filter_var($_REQUEST['name'], FILTER_SANITIZE_STRING);
					 $NPC_STATS=filter_var($_REQUEST['stats'], FILTER_SANITIZE_STRING);
					 $NOTES= filter_var($_REQUEST['notes'], FILTER_SANITIZE_STRING);
					 $CAMPAIGN_ID=$_SESSION["Campaign"];
					 $model= new NPCCharacterController(null,null);
					 $model->create_NPC($NPC_NAME, $NPC_STATS, $NOTES,$CAMPAIGN_ID );
					 echo "<script>window.location.replace('see_npc.php');</script>";
					
				}
			}else {
				echo "CSRF TOKEN DOES NOT MATCH";
			}
		
	}
}
if (isset($_POST["return-to-main"])) {
	echo "<script>window.close();</script>";
}

?>
</head>

<body>
<header-component></header-component> 
<main>
<div class="return-to-main">
<button type= "button" onclick="location.href='see_npc.php';">Back</button>
</div>
<section id ="npc_creation">
		<h1>Create NPC </h1>
		<form method = "post" action= "">
		<label for   = "name"> name </label>
		<input type  = "String" name = "name" placeholder="Name" required/> 	
		<br/><br/>
		<label for = "stats"> Stats </label>
		<textarea name="stats" >Level:1,</textarea>
		<br/><br/>
		<label for   = "Stats"> Notes </label>
		<input type  = "String" name="notes" placeholder="Notes" />
		<br/><br/>
		<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
		<input type  = "submit" name="Create_npc" value="Create"/>
		</form>
</section>
    
	
		
</main>
<section class= "index_footer_padded">
<footer-component></footer-component>
</section>
<?php
}}}
?>
</body>
</html>
