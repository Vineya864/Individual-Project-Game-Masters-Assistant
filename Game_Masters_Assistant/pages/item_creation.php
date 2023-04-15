<!DOCTYPE html>
<html lang="EN">
<?php
/**create a new item is only usable by the gm of the campaign, only accessible through the campaign */
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
include_once("../Controllers/item_controller.php");
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
?>
	<title> Final Year Project		
	</title>


<?php
	if (isset($_POST["Create_item"])) {
		if (isset($_SESSION["login"])) {//if logged in
			if (!empty($_POST['token'])) {//if ther is a token
				if (hash_equals($_SESSION['token'], $_POST['token'])) {//if token matches 
					 $ITEM_NAME=filter_var($_REQUEST['name'], FILTER_SANITIZE_STRING);//sanatize input
					 $ITEM_DESCRIPTION=filter_var($_REQUEST['description'], FILTER_SANITIZE_STRING);
					 $CAMPAIGN_ID=$_SESSION["Campaign"];
					 $model= new ItemController(null,null);
					 $model->create_item($ITEM_NAME, $ITEM_DESCRIPTION,$CAMPAIGN_ID );
					 echo "<script>window.location.replace('see_items.php');</script>";
					
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
<button type= "button" onclick="location.href='see_items.php';">Back</button>
</div>
<section id ="npc_creation">
		<h1>Create Item </h1>
		<form method = "post" action= "">
		<label for   = "name"> name </label>
		<input type  = "String" name = "name" placeholder="Name" required/> 	
		<br/><br/>
		<label for   = "description"> Description </label>
		<input type  = "String" name="description" placeholder="Stats" />
		<br/><br/>
		<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
		<input type  = "submit" name="Create_item" value="Create"/>
		</form>
</section>
<br/><br/><br/>
    
	
		
</main>
<section class= "index_footer_padded">
<footer-component></footer-component>
</section>
<?php
}}}
?>
</body>
</html>
