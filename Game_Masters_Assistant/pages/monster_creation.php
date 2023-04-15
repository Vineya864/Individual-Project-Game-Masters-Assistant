<!DOCTYPE html>
<html lang="EN">
<?php/**
 * works in the same mannor as the npc creation but is used for monster profiles
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
include_once("../Controllers/NPC_monster_controller.php");
session_start();
if (empty($_SESSION['token'])) {
	$url='login.php';//redirect to account	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
$token = $_SESSION['token'];
if (empty($_SESSION['login'])) {
	$url='login.php';//redirect to account	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
if(empty($_SESSION["Campaign"])){
	$url='launch_selection.php';//redirect to account	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
if($_SESSION['role']!="GM"){
	$url='launch_selection.php';//redirect to account	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}
?>
	<title> Final Year Project		
	</title>


<?php
	if (isset($_POST["Create_npc"])) {
		if (isset($_SESSION["login"])) {//if logged in
			if (!empty($_POST['token'])) {//if ther is a token
				if (hash_equals($_SESSION['token'], $_POST['token'])) {//if token matches 
					 $NPC_NAME=filter_var($_REQUEST['name'], FILTER_SANITIZE_STRING);//sanatize input
					 $NPC_STATS=filter_var($_REQUEST['stats'], FILTER_SANITIZE_STRING);
					 $NOTES= filter_var($_REQUEST['notes'], FILTER_SANITIZE_STRING);
					 $CAMPAIGN_ID=$_SESSION["Campaign"];
					 $model= new NPCMonsterController(null,null);
					 $model->create_Monster($NPC_NAME, $NPC_STATS, $NOTES,$CAMPAIGN_ID );
					 echo "<script>window.location.replace('see_monsters.php');</script>";
					
				}
			}else {
				echo "CSRF TOKEN DOES NOT MATCH";
			}
		
	}
}


?>
</head>

<body>
<header-component></header-component> 
<main>
<div class="return-to-main">
<div class="return-to-main">
<button type= "button" onclick="location.href='see_monsters.php';">Back</button>
</div>
</div>
<section id ="npc_creation">
		<h1>Create Monster </h1>
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
