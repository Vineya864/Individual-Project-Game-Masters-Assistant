<!DOCTYPE html>
<html lang="EN">
<?php
/**used by player to access a campaign and respond to invites */
session_start();
if (empty($_SESSION['token'])) {
	$url='login.php';//redirect to account	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
if (empty($_SESSION['login'])) {
	$url='login.php';//redirect to account	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
include_once("../functions_php/errors.php");
include_once("../Controllers/campaign_controller.php");
include_once("../Controllers/user_controller.php");
include_once("../Controllers/invite_controller.php");

$user= new UserController(null,null);
$user_class = ($user->getUserByUsername($_SESSION['login']));
$user_id = $user_class->id;
$token = $_SESSION['token'];
$invite= new InviteController(null,null);
if (isset($_POST["Campaign"])) {
	if (hash_equals($_SESSION['token'], $_POST['token'])) {
		if($invite->invited($user_id,$_REQUEST['Campaign_id'])){
			$_SESSION["Campaign"] = $_REQUEST['Campaign_id'];
   	 		$_SESSION["role"]= "PLAYER";
			$url='player_pannel.php';//redirect to account
		}else{
			$url='index.php';
		}	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
	tokenError();
}
}
if (isset($_POST["refuse_invite"])) {
	if (hash_equals($_SESSION['token'], $_POST['token'])) {
		$invite->resolve_invite($_REQUEST["invite_id"], 0);
		}else{
			tokenError();
		}
}
if (isset($_POST["accept_invite"])) {
	if (hash_equals($_SESSION['token'], $_POST['token'])) {
		$invite->resolve_invite($_REQUEST["invite_id"], 1);
		}else{
			tokenError();
		}
}





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
	<button type= "button" onclick="location.href='index.php';">Return to Main Menu</button>
	<section id ="campaign_selection_list">
	<h1>Current Campaigns:</h1>
	<section id="campaigns">
	<?php
	$invite->ShowAccepted($user_id,$token); 
	?>
	</section>
	<h2>Pending Invites:</h2>
	<section id ="invites">
	<?php
    $invite->ShowInvited($user_id,$token); 
	?>
	</section>
	<?php } }?>
</section>
<section class= "join_selection_footer">
<footer-component></footer-component>
</section>
</main>

</body>
</html>
