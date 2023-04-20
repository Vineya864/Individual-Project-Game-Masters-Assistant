<!DOCTYPE html>
<html lang="EN">


<head>
	<meta charset ="UTF-8"/>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.2.0/normalize.min.css" rel="stylesheet" />
	<link href="../Css/style_main.css" rel="stylesheet" />
	<link href="../Css/sizing.css" rel="stylesheet" />
	<script src="../Components/header.js" type="text/javascript" defer></script>
	<script src="../Components/collapsible_menu.js" type="text/javascript" defer></script>
	<script src="../Components/footer.js" type="text/javascript" defer></script>
	<?php
include_once("../Controllers/status_effects_controller.php");
session_start();
//redirects
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
	if (isset($_POST["Create_Effect"])) {
		if (isset($_SESSION["login"])) {//if logged in
			if (!empty($_POST['token'])) {//if there is a token
				if (hash_equals($_SESSION['token'], $_POST['token'])) {//if token matches 
					 $EFFECT_NAME=filter_var($_REQUEST['name'], FILTER_SANITIZE_STRING);
					 $NOTES= filter_var($_REQUEST['notes'], FILTER_SANITIZE_STRING);
					 $CAMPAIGN_ID=$_SESSION["Campaign"];
					 $model= new StatusEffectController(null,null);
					 $model->create_Effect($EFFECT_NAME,$NOTES,$CAMPAIGN_ID);
					 echo "<script>window.close();</script>";
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
<div class="return-to-main">
	<form method = "post" action= "">
				<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
				<input type  = "hidden" name="user" value="<?php echo $_SESSION['login']; ?>" />
				<input type  = "submit" name="return-to-main" value="Close"/>
	</form>
	</div>
</div>
<section id ="npc_creation">
		<h1>Create Status Effect </h1>
		<form method = "post" action= "">
		<label for   = "name"> name </label>
		<input type  = "String" name = "name" placeholder="Name" required/> 	
		<br/><br/>
		<label for   = "notes"> Notes </label>
        <textarea id ="note_text" name="notes"></textarea>
		<br/><br/>
		<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
		<input type  = "submit" name="Create_Effect" value="Create"/>
		</form>
</section>
<br/><br/>
	
		
</main>
<section class= "index_footer_padded">
<footer-component></footer-component>
</section>
<?php
}}}
?>
</body>
</html>
