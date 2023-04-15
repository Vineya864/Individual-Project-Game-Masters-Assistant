<!DOCTYPE html>
<html lang="EN">
<?php
/* main page shown when the system loads is given as a redicret from root */
?>
<head>

<?php
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token= $_SESSION['token'];
?>
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
	<section class = "user_options">
	<h1> Game Masters Assistant </h1>
	<ul class = "options">
        <li><a href="join_selection.php">Join A Campaign</a></li>
		<li><a href="launch_selection.php">Launch A Campaign</a></li>
        <li><a href="help_page.php">Help</a></li>
        <li><a href="my_account.php">My Account</a></li>

	
	</section>
	

	<section class= "index_footer_padded">
<footer-component></footer-component>
</section>		
	</main>


</body>
</html>
