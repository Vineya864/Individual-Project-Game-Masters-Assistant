<?php

include_once("../Controllers/Player_character_controller.php");
include_once("../Controllers/campaign_controller.php");
include_once("../Controllers/message_controller.php");
include_once("../Controllers/user_controller.php");
include_once("../Controllers/npc_character_controller.php");
include_once("../Controllers/shared_image_controller.php");
include_once("errors.php");

//if the request is sent
	if(isset($_POST['messageSend'])){
		//set up controllers for tasks
		$user          = new UserController(null,null);
		$user_class    = ($user->getUserByUsername($_SESSION['login']));
		$user_id       = $user_class->id;
		$userName	   = $_SESSION['login'];
		$campaign_id   = $_SESSION["Campaign"];
		$role	       = $_SESSION["role"];
		$location 	   = $_POST['page'] ;
		//if hash passes
		if (hash_equals($_SESSION['token'], $_POST['token'])) {
		$message= new MessageController(null,null);
		$text= filter_var($_POST['messageText'], FILTER_SANITIZE_STRING);
		//look for command in message
		$pos = strpos($text, ":");
		$invite        = new InviteController(null,null);
		$player_class  = new PlayerCharacterController(null,null); 
		$campaign_class = new CampaignController(null,null); 
		//if no command send message
		if ($pos === false){
			$destination =$invite->campaignMessage($campaign_id);
			$destination = $destination . "," . $user_id . ",";
			$destination = $destination . "," . $campaign_class->getGMByCampagin($campaign_id). "," ;
			$result      = $message -> addMessage( $user_id, $campaign_id, $text,$destination, $userName);
			header("Location:$location");			
		}else{
			$split=explode(":", $text);
			//if dice roll dice
			if($split[0]=="dice"){
				if ($role != "GM"){
					$destination =$invite->campaignMessage($campaign_id);
					$destination = $destination . "," . $campaign_class->getGMByCampagin($campaign_id). "," ;
				}
				$destination = $destination . "," . $user_id . ",";
				$dice=explode("d",$split[1]);
				$amount= $dice[0];
				$diceValue=$dice[1];
				//check that a number has been given
				if(is_numeric($amount) && is_numeric($diceValue)){
				$total=0;
				for ($x =0; $x<$amount; $x++){
					$total= $total +rand(1,$diceValue);
				}//check for public role
				if ($role != "GM"){
					$result= $message -> addMessage( $user_id, $campaign_id, "Dice:" . $total,$destination, $userName );		
				}else{
					$result= $message -> addMessage( $user_id, $campaign_id, "Dice:" . $total,$destination, "GM" );	
				}
				$total=0;
			}
				header("Location:$location");
			
			//if announce check if gm then if true make the announcment. refresh if not gm
			}elseif($split[0]=="announce"){
				if ($role == "GM"){
				  $destination =$invite->campaignMessage($campaign_id);
				  $destination =$invite->campaignMessage($campaign_id);
				  $destination = $destination . "," . $user_id . ",";
				  $result= $message -> addMessage( $user_id, $campaign_id,$split[1],$destination, "Announcement" );
				}
				header("Location:$location");
			}else{	//whisper			
			    $destination =$invite->campaignMessage($campaign_id);
			    $destination = "," . $user_id . ",";
				$destination = $destination  . $player_class->getIDFromName($split[0]) . ",";
				$result= $message -> addMessage( $user_id, $campaign_id, $split[0] . ":" . $split[1],$destination, $userName );
				header("Location:$location");
			}

		}
        exit;
		}else{
			tokenError();
		}
			
	}




	

?>