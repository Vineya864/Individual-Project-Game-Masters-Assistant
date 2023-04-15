<!DOCTYPE html>
<html lang="EN">

<?php
/**used to log in to the camapign code for proccessing login can be found at the bottom of the page, sign up is only avalible form this page */
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
	<script src="../components/footer.js" type="text/javascript" defer></script>
	<title> Final Year Project		
	</title>
	
</head>

<body>
<header-component></header-component> 
	<main>
	<div class="return-to-main">
<button type= "button" onclick="location.href='index.php';">Back</button>
</div>
	<section id ="login">
		<h1>Log In </h1>
		<form method = "post" action= "">
		<label for   = "username"> Username </label>
		<input type  = "String" name = "username" placeholder="Username" required/> 	
		<br/><br/>
		<label for   = "password"> Password </label>
		<input type  = "password" name="password" 	placeholder="Password" required />
		<br/><br/>
		<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
		<input type  = "submit" name="user" value="Login"/>
		</form>
		
<?php
if (isset($_POST["user"])) {
	if (!empty($_POST['token'])) {
    	if (hash_equals($_SESSION['token'], $_POST['token'])) { 
			 $username=filter_var($_REQUEST['username'], FILTER_SANITIZE_STRING);
			 $pass= filter_var($_REQUEST['password'], FILTER_SANITIZE_STRING);
			 $model= new UserController(null,null);
			 
			 if($model->checkPassword($pass,$username)){
			 	$_SESSION['login'] = $username; 
			 	$user=$model->getUserByUsername($username);
			 		$url='../index.php';	
			 		echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';

			}else{
				echo "Incorect details"; 
			}
		}
	}else {
        echo "CSRF TOKEN DOES NOT MATCH";
    }
}
	
	?>


		<div id = "sign_up">
		<a href="sign_up.php">sign up</a></li>
		</div>
	</section>
	</main>


<section class= "index_footer_padded">
<footer-component></footer-component>
</section>

</body>
</html>
