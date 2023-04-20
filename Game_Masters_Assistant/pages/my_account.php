<!DOCTYPE html>
<html lang="EN">
<?php
/***
 * change username, change password, delete account, access all characters
 * delete account will cascade and delete characters and notes
 * cannot delete if a gm  
 */
session_start();
if (empty($_SESSION['token'])) {
	$url='login.php';//redirect to login	
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
}else{
	include_once("../Controllers/user_controller.php");
	include_once("../Controllers/Player_character_controller.php");
	include_once("../Controllers/campaign_controller.php");
	$user            = new UserController(null,null);
	$user_class      = ($user->getUserByUsername($_SESSION['login']));
	$user_id         = $user_class->id;
	$userName	     = $_SESSION['login'];
	$token           = $_SESSION['token'];
	$character_model = new PlayerCharacterController(null,null);
	$campaign_model = new CampaignController(null,null);
	if (isset($_POST["Open_Details_Character"])) {
		if (hash_equals($_SESSION['token'], $_POST['token'])) {
		$_SESSION['current_character']= $_REQUEST['user_character'];
		?>
		<script>window.open("character_details.php");
		 window.location.replace("my_account.php"); 
		</script>
		<?php
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
	<button type= "button" onclick="location.href='index.php';">Return to Main Menu</button></br>
		<section id= "my_account">
		<h1>My Account	</h1>
		<h2> <?php echo $userName ?></h2>
		<section id= "account_characters">
		<h3>My Characters</h3>
		<?php 
		$character_model->showAllUserCharacters($user_id,$token);
		?>
		</section>
		<section id= "account_change">
		<h3>Change username or password </h3>
		<form method = "post" action= "">
			<label for   = "username"> Username </label>
			<input type  = "String" name = "username" placeholder="Username" required/> 	
			<br/><br/>
			<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
			<input type  = "submit" name="userName" value="Change User Name"/>
		</form>
		<?php
		if (isset($_POST["userName"])) {
		if (hash_equals($_SESSION['token'], $_POST['token'])) {
			$newUsername=filter_var($_POST['username'], FILTER_SANITIZE_STRING);
			if(!($user->userExists($newUsername))){
				$user->changeName($userName,$newUsername);
				$url='my_account.php';
				echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
				$_SESSION['login'] = $newUsername;
			}else{
				echo "username in use";
			} 
		}else{
			echo "token error";
		}
		}
		
		?>

		<form method = "post" action= "">
			<label for   = "password"> Current Password </label>
			<input type  = "password" name="current_password" 	placeholder="Password"  />
			<br/><br/>
			<label for   = "password">  New Password </label>
			<input type  = "password" name="new_password" 	placeholder="Password"  />
			<br/><br/>
			<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
			<input type  = "submit" name="userPassword" value="Change User Password"/>
		</form>
		<?php

		if (isset($_POST["userPassword"])) {
			if (hash_equals($_SESSION['token'], $_POST['token'])) {
				$newPass=filter_var($_POST['new_password'], FILTER_SANITIZE_STRING);
				$oldPass=filter_var($_POST['current_password'], FILTER_SANITIZE_STRING);
				if(preg_match("/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])/", $newPass)){
					$user->changePassword($userName,password_hash($newPass, PASSWORD_DEFAULT),$oldPass);
					$url='my_account.php';
					echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
		
			}else{
				echo "Password Does not meet complexity requirements";
			}
		}
	}
		?>
		<form method = "post" action= "">
			<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
			<input type  = "submit" name="deleteAccount" value="Delete account"/>
		</form>
		<?php

		if (isset($_POST["deleteAccount"])) {
			if (hash_equals($_SESSION['token'], $_POST['token'])) {
				if(!$campaign_model->isGm($user_id)){
					$character_model->deleteAccount($user_id);
					$user->deleteAccount($user_id);
					$url='login.php';
					echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
				}else{
					echo "plese transfer ownership of or delete campaigns before delete";
				}
			}
		}
	
	?>
	</section>
	</section>
	</main>
	<section class= "account_footer">
<footer-component></footer-component>
	</section>


</body>
<?php }?>
</html>
