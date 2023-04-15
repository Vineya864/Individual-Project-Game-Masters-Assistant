<!DOCTYPE html>
<html lang="EN">
<?php
/**
 * see all campaign items, create new items, assing items to players assing is only avalible by when active
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
include_once("../Controllers/item_controller.php");
include_once("../Controllers/User_controller.php");
include_once("../functions_php/errors.php");
include_once("../Controllers/Player_character_controller.php");
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
if($_SESSION["role"]!="GM"){
$url='login.php';//redirect to account	
echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
        
$user          = new UserController(null,null);
$user_class    = ($user->getUserByUsername($_SESSION['login']));
$user_id       = $user_class->id;
$userName	   = $_SESSION['login'];
$campaign_id   = $_SESSION["Campaign"];
$role	       = $_SESSION["role"];
$item_model= new ItemController(null,null);
$player_class  = new PlayerCharacterController(null,null); 
$campaign_model= new CampaignController(null,null);
if (isset($_POST["Open_Details_Item"])) {
	if (hash_equals($_SESSION['token'], $_POST['token'])) {
	$_SESSION['current_item']= $_POST['current_item'];
	?>
	<script> window.open("item_details.php");
	window.location.replace("see_items.php"); </script>
	<?php
	}else{
		tokenError();
	}
	
}


if (isset($_POST["item_creation"])) {
	if (hash_equals($_SESSION['token'], $_POST['token'])) {	
	?>
	<script>
	 window.location.replace("item_creation.php");
	</script>
	<?php
	}else{
		tokenError();
	}
}

if (isset($_POST["make_active"])) {
	if (hash_equals($_SESSION['token'], $_POST['token'])) {
		if($user_id==$campaign_model->getGMByCampagin(($item_model->getItemById($_POST['current_item'])->CAMPAIGN_ID))){
		$item_model->ChangeActiveStatus( $_POST['current_item'],"1");
	?>
	<script>window.location.replace("see_items.php"); </script>
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
		if($user_id==$campaign_model->getGMByCampagin(($item_model->getItemById($_POST['current_item'])->CAMPAIGN_ID))){
		$item_model->ChangeActiveStatus( $_POST['current_item'],"0");
	?>
	<script>window.location.replace("see_items.php"); </script>
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
<?php
if (isset($_POST["assign_item"])) {
    if (hash_equals($_SESSION['token'], $_POST['token'])) {	
		if($user_id==$campaign_model->getGMByCampagin(($item_model->getItemById($_POST['current_item'])->CAMPAIGN_ID))){
      		$add_user=($user->getIdByUsername($_POST['name']));
       		if(is_numeric($add_user)){
            	$item_model->add_item($add_user,$_POST['current_item']);
        	}else{
            	echo "<p>no user found</p>";
        	}
		}else{
			$url='login.php';
			echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">'; 
		}
    }else{
		tokenError();
	}
}

if (isset($_POST["take_item"])) {
    if (hash_equals($_SESSION['token'], $_POST['token'])) {	
		if($user_id==$campaign_model->getGMByCampagin(($item_model->getItemById($_POST['current_item'])->CAMPAIGN_ID))){
        	$add_user=($user->getIdByUsername($_POST['name']));
        	if(is_numeric($add_user)){
            	$item_model->drop_item($add_user,$_POST['current_item']);
            	echo "<p>item removed </p>";
        	}else{
            	echo "<p>no user found</p>";
        	}
		}else{
			$url='login.php';
			echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">'; 
	}
    }else{
		tokenError();
	}
}


?>
<div id="manage_items">
<section class= "management_title">
<h1>Manage Items</h1>
<form action="" method="post" >
	<input type="hidden" name="token" value="<?php echo $token; ?>" />
	<input type="submit" value="Create New Item" name= "item_creation">
</form>
</div>
</section>
<section id= "management_options">
<div class = "item_options">
<div id="all_items">
<?php
$item_model->showItemActiveStatus($campaign_id,$token)
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
