<!DOCTYPE html>
<html lang="EN">

<?php
/**character sheet for items is viewable by gm and player only gm can edit */
include_once("../Controllers/user_controller.php");
include_once("../Controllers/item_controller.php");
include_once("../Controllers/campaign_controller.php");
include_once("../views/item_view.php");
session_start();
if (empty($_SESSION['token'])) {
	$url='login.php';//redirect to account	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
$token = $_SESSION['token'];



if (empty($_SESSION['login'])) {
	$url='login.php';//redirect to account	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}elseif(empty($_SESSION["Campaign"])){
	$url='launch_selection.php';//redirect to account	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
$user           = new UserController(null,null);
$user_class     = ($user->getUserByUsername($_SESSION['login']));
$user_id        = $user_class->id;
$campaign_id    = $_SESSION["Campaign"];
$campaign_model = new CampaignController(null,null);
$item_id        = $_SESSION["current_item"];
$item_model     = new  ItemController(null,null);
$item           = $item_model->getItemById($item_id);
if((!($item_model->held_by($item_id,$user_id))) and ($user_id!=$campaign_model->getGMByCampagin(($item_model->getItemById($item_id)->CAMPAIGN_ID)))){
	echo "<script>window.close();</script>";
}else{

if (isset($_POST["Delete_Item"])) {
	if($_SESSION["role"]=="GM"){
	$item_model->delete_item($item_id);
	echo "<script>window.close();</script>";
	}
}

if (isset($_POST["Edit_Item"])) {
	if($_SESSION["role"]=="GM"){
	$item_model->edit_item(filter_var($_REQUEST['name'], FILTER_SANITIZE_STRING),filter_var($_REQUEST['description'], FILTER_SANITIZE_STRING),$item_id);
	$url='item_details.php';
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
	}
}

if (isset($_POST["Drop_Item"])) {
	$item_model->drop_item($user_id,$item_id);
	echo "<script>window.close();</script>";
	}

	


if (isset($_POST["return-to-main"])) {
	echo "<script>window.close();</script>";
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
	<link href="../Css/sizing.css" rel="stylesheet" />
	<script src="../Components/header.js" type="text/javascript" defer></script>
	<script src="../Components/collapsible_menu.js" type="text/javascript" defer></script>
	<script src="../Components/footer.js" type="text/javascript" defer></script>
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
	<div>
    <?php
    $view = new ItemView();
	$view->displayItemSheet($item);

    ?>
	<div id="character_sheet">

	<?php
	if($_SESSION["role"]=="GM"){
		?>
	<button type="button" class="collapsible" >Edit Item</button>
	<div class="content">
	<form method = "post" action= "">
				<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
				<input type  = "hidden" name="item" value="<?php echo $item->ITEM_ID; ?>" />
				<input type  = "hidden" name="user" value="<?php echo $_SESSION['login']; ?>" />
				<p>Name</p>
				<input type  = "text"   name="name" value="<?php echo $item->ITEM_NAME; ?>" /></br>
				<p>Description</p>
				<textarea name="description"><?php echo $item->ITEM_DESCRIPTION?></textarea></br>
				<input type  = "submit" name="Edit_Item" value="Save Changes"/>
	</form>
	</br></br>
	<form method = "post" action= "">
				<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
				<input type  = "hidden" name="item" value="<?php echo $item->ITEM_ID; ?>" />
				<input type  = "hidden" name="user" value="<?php echo $_SESSION['login']; ?>" />
				<input type  = "submit" name="Delete_Item" value="Delete Item"/>
	</form>
	</div>
	<?php }else{ ?>
	<form method = "post" action= "">
				<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
				<input type  = "hidden" name="item" value="<?php echo $item->ITEM_ID; ?>" />
				<input type  = "hidden" name="user" value="<?php echo $_SESSION['login']; ?>" />
				<input type  = "submit" name="Drop_Item" value="Drop Item"/>
	<?php } ?>
</div>
</br></br>
<section class= "profile_footer">
<footer-component></footer-component>
	</section>
</main>


</body>
<?php }}}

?>
</html>
