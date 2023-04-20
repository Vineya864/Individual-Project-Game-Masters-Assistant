<!DOCTYPE html>
<html lang="EN">
<?php
/* used to create a new character avalible to both the player and the gm  */
?>
<head>
	<meta charset ="UTF-8"/>
	  <link href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.2.0/normalize.min.css" rel="stylesheet" />
	<link href="../Css/style_main.css" rel="stylesheet" />
	<link href="../Css/sizing.css" rel="stylesheet" />
	<script src="../Components/header.js" type="text/javascript" defer></script>
	<script src="../Components/collapsible_menu.js" type="text/javascript" defer></script>
	<script src="../components/footer.js" type="text/javascript" defer></script>
	<?php
include_once("../Controllers/Player_character_controller.php");
include_once("../Controllers/User_controller.php");

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
	$url='launch_selection.php';//redirect to selection	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
$user          = new UserController(null,null);
$user_class    = ($user->getUserByUsername($_SESSION['login']));
$user_id       = $user_class->id;
$userName	   = $_SESSION['login'];
$campaign_id   = $_SESSION["Campaign"];
$role	       = $_SESSION["role"];

	if (isset($_POST["return-to-main"])) {
		if($role=="PLAYER"){
			echo "<script>window.location.replace('player_pannel.php');</script>";
		}elseif ($role=="GM"){
			echo "<script>window.location.replace('gm_pannel.php');</script>";
		}
	}

?>
	<title> Final Year Project		
	</title>

	


<?php
	if (isset($_POST["Create_character"])) {
		if (isset($_SESSION["login"])) {//if logged in
			if (!empty($_POST['token'])) {//if ther is a token
				if (hash_equals($_SESSION['token'], $_POST['token'])) {//if token matches 
					 $character_name=filter_var($_REQUEST['name'], FILTER_SANITIZE_STRING);//sanatize input
					 $character_stats=filter_var($_REQUEST['stats'], FILTER_SANITIZE_STRING);
					 $character_notes=filter_var($_REQUEST['notes'], FILTER_SANITIZE_STRING);
					 $model= new PlayerCharacterController(null,null);
					 $model->create_character($character_name,$character_stats,$character_notes,$campaign_id,$user_id );
					 if($role=="PLAYER"){
						echo "<script>window.location.replace('player_pannel.php');</script>";
					 }elseif ($role=="GM"){
						echo "<script>window.location.replace('gm_pannel.php');</script>";
				     }
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
<div class="return-to-main">
	<form method = "post" action= "">
				<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
				<input type  = "hidden" name="user" value="<?php echo $_SESSION['login']; ?>" />
				<input type  = "submit" name="return-to-main" value="Back"/>
	</form>
</div>
<main>
<section id ="npc_creation">
		<h1>Create Character </h1>
		<form method = "post" action= "">
		<label for = "name"> name </label>
		<input type = "String" name = "name" placeholder="Name" required/> 	
		<br/><br/>
		<label for = "stats"> Stats </label>
		<textarea name="stats" >Level:1,</textarea>
		<br/><br/>
		<label for   = "Stats"> Notes </label>
		<input type  = "String" name="notes" placeholder="Notes" />
		<br/><br/>
		<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
		<input type  = "submit" name="Create_character" value="Create"/>
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
