<!DOCTYPE html>
<html lang="EN">
<?php
/***
 * see all campagin monsters, create monster, set monster as active
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
include_once("../Controllers/User_controller.php");
include_once("../functions_php/errors.php");
include_once("../Controllers/campaign_controller.php");
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
}else{
$user          = new UserController(null,null);
$user_class    = ($user->getUserByUsername($_SESSION['login']));
$user_id       = $user_class->id;
$userName	   = $_SESSION['login'];
$campaign_id   = $_SESSION["Campaign"];
$role	       = $_SESSION["role"];
$npc_model= new NPCMonsterController(null,null);
$campaign_model= new CampaignController(null,null);

if (isset($_POST["Open_Details_NPC"])) {
	if (hash_equals($_SESSION['token'], $_POST['token'])) {
	$_SESSION['current_monster']= $_POST['user_character'];
	?>
	<script> window.open("monster_details.php");
	window.location.replace("see_monsters.php"); </script>
	<?php
	}else{
		tokenError();
	}
	
}
if (isset($_POST["npc_creation"])) {
	if (hash_equals($_SESSION['token'], $_POST['token'])) {	
	?>
	<script>
	 window.location.replace("monster_creation.php"); 
	</script>
	<?php
	}else{
		tokenError();
	}
}

if (isset($_POST["make_active"])) {
	if (hash_equals($_SESSION['token'], $_POST['token'])) {
		if($user_id==$campaign_model->getGMByCampagin((($npc_model->get_campaign($_POST['user_character']))))){

		$npc_model->ChangeActiveStatus( $_POST['user_character'],"1");
	?>

	<script>window.location.replace("see_monsters.php"); </script>
	<?php
	}else{
		$url='login.php';
		echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">'; 
	}
	}else{
		tokenError();
	}
}
if (isset($_POST["make_inactive"])) {
	if (hash_equals($_SESSION['token'], $_POST['token'])) {
		if($user_id==$campaign_model->getGMByCampagin((($npc_model->get_campaign($_POST['user_character']))))){

		$npc_model->ChangeActiveStatus( $_POST['user_character'],"0");
	?>
	<script>window.location.replace("see_monsters.php"); </script>
	<?php
	}else{
		$url='login.php';
		echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">'; 
	}
	}else{
		tokenError();
	}
}
?>
	<title> Final Year Project		
	</title>


<?php


?>
</head>

<body>
<header-component></header-component> 
<main>
<div class="return-to-main">
<button type= "button" onclick="location.href='gm_pannel.php';">Back</button>
</div>
<div id="manage_NPCs">
<section class= "management_title">
<h1>Manage Monsters </h1>
<div class = "npc_options">
<form action="" method="post" >
	<input type="hidden" name="token" value="<?php echo $token; ?>" />
	<input type="submit" value="Create New Monster" name= "npc_creation">
</form>
</div>
</section>
<section id= "management_options">
<div id="all_npc">
<?php
$npc_model->showCampainMonsterActiveStatus($campaign_id,$token)
?>
</div>
</div>
</section>
</main>
<section class= "manage_footer_padded">
<footer-component></footer-component>
</section>
<?php
}}}}
?>
</body>
</html>
