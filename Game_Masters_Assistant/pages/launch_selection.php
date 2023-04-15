<!DOCTYPE html>
<html lang="EN">
<?php
/* page is used to launch the gm view, uses the .create_campaign.php file */
session_start();
if (empty($_SESSION['token']) or empty($_SESSION['login'] )) {
	$url='login.php';
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
$token = $_SESSION['token'];
include_once("../Controllers/campaign_controller.php");
include_once("../Controllers/user_controller.php");
include_once("../functions_php/errors.php");
$campaign= new CampaignController(null,null);
$user= new UserController(null,null);
$user_class = ($user->getUserByUsername($_SESSION['login']));
$user_id = $user_class->id;
if (isset($_POST["Campaign"])) {
	if (hash_equals($_SESSION['token'], $_POST['token'])) {
		if ($user_id==$campaign->getGMByCampagin($_REQUEST['Campaign_id'])){
		$_SESSION["Campaign"] = $_REQUEST['Campaign_id'];
		$_SESSION["role"]= "GM";
		$url='gm_pannel.php';	
		}else{
		$url='index.php';
		}
		echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
	}else{
		tokenError();
	}
}
if (empty($_SESSION['login'])) {
	$url='login.php';
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
?>
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
	<button type= "button" onclick="location.href='index.php';">Return to Main Menu</button></br>
	<section id ="campaign_selection_list">
	<h1>My Campaigns</h1>
	<section id="campaigns">
	<?php
	$current_campaign= $campaign->showCampaignByDm($user_id,$token); 
	?>
	<div>
	</section>
	<section id ="Campaign_creation">
	<h2> Create a New Campaign </h2>
		<form method = "post" action= "create_campaign.php">
		<label for   = "username"> Campaign Name </label>
		<input type  = "String" name = "Campaign_Name" placeholder="Campaign_Name" required/> 	
		<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
		<input type  = "submit" name="New_campaign" value="Launch"/>
		</form>
	</section>

	</div>
	
		
</section>
<section class= "selection_footer">
<footer-component></footer-component>
</section>
</main>

</body>
<?php 
}}
?>
</html>
