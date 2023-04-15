<!DOCTYPE html>
<html lang="EN">

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
	<section id="help_collapsibles">
	
		<section id="create_account">
		<button type="button" class="collapsible" >Create an Account</button>
		<div class="content">

			You will need to set up an account using a unique username and a password.</br>
			This can be done by pressing the log in button found on the top left of the screen and then pressing create account on the login screen </br>
			This account will be used to store the characters and notes you create and invite you to join campaigns.</br>
			As a Game master this will also be the account to store your campaigns.</br>
			You may use the same account to act as a Game master and a player.</br>
		</div>
		</section>

		<section id="joining_campaign">
		<button type="button" class="collapsible" >Joining a Campaign</button>
		<div class="content">
			To join a campaing you first must be invited to it. A Game master can invite you to a campaign by using the manage campaign tab.</br>
			This will allow them to uuse your username to send you a game invite. Current Campaigns and invites can be seen by pressing join campaign.</br>
			You must accept a campaign invite before you will be able to join a campaign and create characters or notes. </br>
		</div>
		</section>
		<section id ="launching_campaign">
		<button type="button" class="collapsible" >Create a Campaign</button>
		<div class="content">
			To create a campaign you must press the launch campaing button. This will allow you to access all the camapings you are a Game Master for and Create New Campaigns. </br>
			Place the name of the campaign you wish to create in the text box and press create.</br>
			You will see a new option with the name of the campaign you just created avalible. clicking this option will allow you to access your campaign. </br>
		</div>
		</section>


	<section id="managing_a_campaign">
	<button type="button" class="collapsible" >Managing a Campaign</button>
		<div class="content">
		A campaign can be managed in the manage campaing tab avalible from the Game Masters window.</br>
		Here you will be able to invite Players, Remove Players, Change the Game Master of a Campaign and delete a Campaign</br>
		Once deleted a campaign can not be recovered </br>
		<div>
	</section>
	<section id= "character_creation">	
	<button type="button" class="collapsible" >Create an Character</button>
		<div class="content">
		The character Creation window can be accessed by pressing the character creation button on the player or Game master view.</br>
		Characters will be created linked to the current accessed campaign. </br>
		Once Created any Detail about a character can be changed and a picture can be added. </br>
		To edit a created character got to the either the player or Game master screen and press the Player Characters tab. </br>
		This will open a drop down where the character will be listed. To see and edit the character sheet press the see details button linked with the character. </br>
		This will show you the character sheet. By pressing the edit character button you are able to change details and add a picture (only one character picture can be used).</br>
		If you delete the character they cannot be recovered.</br>
		Only the Character Owner and the Game master can view the Character sheet. </br>
		Characters can also be accessed throught the my account screen. </br>
		</div>
	</section>
	<section id="monsters_npc_items">
	<button type="button" class="collapsible" >Monsters NPCs and Items</button>
		<div class="content">
		Profiles can be created for monsters, items and npcs by the Game Master. These are only viewable by the Game master. </br>
		To create a monster, item or Npc click the respective "manage items","manage Npc", "manage monsters" option On the Game Master Screen. </br>
		this will allow you to see all the relevent created profiles and create new profiles.</br>
		When a profile is created it will be inactive this means that it cannot be seen on the main Game Master screen. </br>
		Press the make active button to make the profile visible </br>
		An active Item can also be assinged to a player which will allow the player to view the profile </br>
	</div>
	</section>
	<section id="uploading_a_picture">
	<button type="button" class="collapsible" >Upload a Picture</button>
		<div class="content">
		There are three types of picture that can be used. Character Pictures, Wallpapers, And Campaign Pictures </br>
		Character pictures are displayed on the character sheet and are a representation of the player character </br>
		Wallpapers can be uploaded by the Game master by the upload image option and will be used as a background for the campaign windows. </br>
		Campaign pictures are uploaded the same way but are shown in the middle of the Campaign window.</br>
		Players are only able to see active pictures and only one wallpapers and one campaign picture can be active at one time.</br>
		Pictures can be deleted when they are no longer needed. </br>
		Pictures must be uploaded in JPG format.</br> 
		When a new Character picture is uploaded the old picture Linked to that character will be deleted</br>
		If the campaign is deleted all pictures are delted</br>
		Pictures will be avalible to the new Game Master if the Game Master Changes.</br>
	</div>
	</section>
	<section id= "delete_account">
	<button type="button" class="collapsible" >Deleting Your Account</button>
	<div class="content">
		To delete your account go to the my account window.</br>
		A acount cannot be delete if they are recorded as a Game master for a campaign. Delete the campaign or change Game master.</br>
		Deleteing an account will remove all characters and notes linked to that account these can not be recovered. </br>
		Once the account is deleted you will be logged out. </br>
	</div>
	</section>
</section>
	</main>
<footer-component></footer-component>


</body>
</html>
