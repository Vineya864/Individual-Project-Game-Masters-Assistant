<!DOCTYPE html>
<html lang="EN">

<?php
/**
 * used to create a new user account
 */
session_start();
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token= $_SESSION['token'];

include_once("../Controllers/user_controller.php");
?>

<head>
	<meta charset ="UTF-8"/>
	  <link href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.2.0/normalize.min.css" rel="stylesheet" />
	<link href="../Css/style_main.css" rel="stylesheet" />
	<link href="../Css/sizing.css" rel="stylesheet" />
	<script src="../Components/header.js" type="text/javascript" defer></script>
	<script src="../Components/footer.js" type="text/javascript" defer></script>
	<title> Final Year Project		
	</title>
	
</head>

<body>
<header-component></header-component> 
	<main>
	<div class="return-to-main">
<button type= "button" onclick="location.href='login.php';">Back</button>
</div>
	<section id ="login">
	<section id ="create_account">
		<h1>Create Account </h1>
		<form method = "post" action= "">
		<label for   = "username"> Username </label>
		<input type  = "String" name = "username" placeholder="Username" required/> 	
		<br/><br/>
		<label for   = "password"> Password </label>
		<input type  = "password" name="password" 	placeholder="Password"  />
		<br/><br/>
		<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
		<input type  = "submit" name="user" value="Create Account"/>
		</form>


		<?php
		if (isset($_POST["user"])) {
			if (!empty($_POST['token'])) {
    			if (hash_equals($_SESSION['token'], $_POST['token'])) {
			 		$username=filter_var($_POST['username'], FILTER_SANITIZE_STRING);
			 		$pass= filter_var($_POST['password'], FILTER_SANITIZE_STRING);
			 		if(preg_match("/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])/", $pass)){
			 			$model= new UserController(null,null);
			 				if(!($model->userExists($username))){
								$model->addAccount($username,password_hash($pass, PASSWORD_DEFAULT));
								if($model->checkPassword($pass,$username)){
									$_SESSION['login'] = $username; 
									$user=$model->getUserByUsername($username);
									$url='../index.php';
									echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
			 					}
							}else{
								echo "Username Already in use";
							}
					}else{
						echo "Incorect Details Please Check password Meets Requierements "; 
					}
				}
				}else {
        			echo "CSRF TOKEN DOES NOT MATCH";
    			}
}
	
	?>
		
	</section>
    </section>
	</main>

	<section class= "index_footer_padded">
<footer-component></footer-component>
</section>


</body>
</html>
