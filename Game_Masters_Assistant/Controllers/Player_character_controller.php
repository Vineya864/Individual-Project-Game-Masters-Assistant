<?php

include_once("../views/player_character_view.php");
include_once("../views/player_Character.php");
include_once("item_controller.php");
require_once("../env.php");

class PlayerCharacterController {
	
	private $server;
    private $dbname;
    private $username;
    private $password;
    private $pdo;
	# define the constructor which has four arguments for $server, $dbname, $username, $password. 
	# The $pdo field should be assigned as null  

	public function __construct($a,$b){
		$this->server = $a;
		$this->dbname = $b;
		$this->username = apache_getenv('USER_NAME');
		$this->password = apache_getenv('PASSWORD');
		$this->pdo =null;
	}
	
	
	
	public function Connect(){
		
	try{
	$this->pdo = new PDO("mysql:host=127.0.0.1;dbname=FYP", $this->username, $this->password );
	$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	} catch (PDOException $ex) {
    ?>
    <p>Sorry, a database error occurred.</p>
	<p> Error details: <em> <?= $ex->getMessage() ?> </em></p>
	<?php	
	}
	}
	
	
	
	public function getPlayerCharacterById($id) {
		$this->Connect();
		$query=$this->pdo->prepare("SELECT * FROM `campaign_characters` WHERE CHARACTER_ID =?;");
		 $query->execute([$id]);
		  $row=$query->fetch();
	
		if ($row != null){
		return new PlayerCharacter($row["CHARACTER_ID"], $row["CHARACTER_NAME"],$row["CHARACTER_STATS"], $row["PICTURE"],$row["CHARACTER_NOTES"]  );
		}
	}

	public function getIDFromName($given_id){
		$this->Connect();
		$id=filter_var($given_id,FILTER_SANITIZE_STRING);
		$query=$this->pdo->prepare("SELECT USER_ID FROM `user` WHERE USER_NAME =?;");
		$query->execute([$id]);
		$row=$query->fetch();
		return $row[0];
	}
	
	public function showCampainCharacters($id,$token){
		$this->Connect();
		$sth=$this->pdo->prepare("SELECT * FROM `campaign_characters` WHERE CAMPAIGN_ID =?; ");
		$sth->execute([$id]);

		while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
				$character=$this->getPlayerCharacterById($row["CHARACTER_ID"]);
				$view = new playerCharacterView();
				$view->displayCharacterDropDown($character,$token);

			}
		
	}

	public function showMyCampainCharacters($campaign_id,$user_id,$token) {
		$this->Connect();
		$sth=$this->pdo->prepare("SELECT * FROM `campaign_characters` WHERE CAMPAIGN_ID =? INTERSECT SELECT * FROM `campaign_characters` WHERE USER_ID = ?; ");
		$sth->execute([$campaign_id,$user_id]);
		while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
				$character=$this->getPlayerCharacterById($row["CHARACTER_ID"]);
				$view = new playerCharacterView();
				$view->displayCharacterDropDown($character,$token);
			}
	}

	public function showAllUserCharacters($id, $token){
		$this->Connect();
		$sth=$this->pdo->prepare("SELECT * FROM `campaign_characters` WHERE USER_ID = ?; ");
		$sth->execute([$id]);
		while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
				$character=$this->getPlayerCharacterById($row["CHARACTER_ID"]);
				$view = new playerCharacterView();
				$view->displayCharacterDropDown($character,$token);

			}
	}
	

	public function campaignMessage($id){
		$this->Connect();
		$sth=$this->pdo->prepare("SELECT * FROM `campaign_characters` WHERE CAMPAIGN_ID =?; ");
		$sth->execute([$id]);
		$destination=",";
		while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
			
				$destination = $destination . "," . $row["USER_ID"] ; 

				
			}
		return $destination;
		
	}

	public function findOwner($character_id){
		$this->Connect();
		$sth=$this->pdo->prepare("SELECT * FROM `campaign_characters` WHERE CHARACTER_ID =?; ");
		$sth->execute([$character_id]);
		while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
		return 	$row["USER_ID"];	
		}
	}

	public function edit_Character($NAME, $STATS, $character_id,$character_notes){
		$this->Connect();
		$sth=$this->pdo->prepare("UPDATE campaign_characters SET CHARACTER_NAME=?, CHARACTER_STATS=?, CHARACTER_NOTES=? WHERE CHARACTER_ID =? ");
		$sth->execute([$NAME, $STATS,$character_notes, $character_id]);
	}

	public function add_image($character_id,$image){
		$true_path =$image; 
		$this->Connect();
		$sth=$this->pdo->prepare("SELECT * FROM `campaign_characters` WHERE CHARACTER_ID =?; ");
		$sth->execute([$character_id]);
		while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
			$picture=$row["PICTURE"];
		}
		if(is_null($picture)){
			$sth=$this->pdo->prepare("UPDATE campaign_characters SET PICTURE=? WHERE CHARACTER_ID =? ");
			$sth->execute([$image, $character_id]);
		}else{
			if(is_file($picture)){ 	
                unlink($picture); 
				$sth=$this->pdo->prepare("UPDATE campaign_characters SET PICTURE=? WHERE CHARACTER_ID =? ");
				$sth->execute([$image, $character_id]);
            } else{
				$sth=$this->pdo->prepare("UPDATE campaign_characters SET PICTURE=? WHERE CHARACTER_ID =? ");
				$sth->execute([$image, $character_id]);
			}
		}
	}

	public function delete_Character($character_id, $campaign,$user_id){
		$this->Connect();
		$sth=$this->pdo->prepare("SELECT * FROM `campaign_characters` WHERE CHARACTER_ID =?; ");
		$sth->execute([$character_id]);
		while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
			$picture=$row["PICTURE"];
		}
		$sth=$this->pdo->prepare("DELETE FROM `campaign_characters` WHERE CHARACTER_ID =?; ");
		$sth->execute([$character_id]);	
		$item= new ItemController(null,null);
		$item->characterDrop($campaign,$user_id);
		if(is_file($picture)){ 	
			unlink($picture); 
		}
	}
	
	public function deleteAccount($user_id){
		$this->Connect();
		$sth=$this->pdo->prepare("SELECT * FROM `campaign_characters` WHERE USER_ID = ?; ");
		$sth->execute([$user_id]);
		$item= new ItemController(null,null);
		while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
			$item->delete_Character($row["CHARACTER_ID"],$row["CAMPAIGN_ID"],$row["USER_ID"]);
		}

	}

	public function delete_campaign($id){
		$this->Connect();
		$sth=$this->pdo->prepare("SELECT * FROM `campaign_characters` WHERE CAMPAIGN_ID = ?; ");
		$sth->execute([$id]);
		while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
			$this->delete_Character($row["CHARACTER_ID"],$row["CAMPAIGN_ID"],$row["USER_ID"]);
		}
		if(is_dir("../Resources/uploads/".$id."/player_images")){
			$toRemove = glob("../Resources/uploads/".$id.'/player_images');
        	foreach($toRemove as $file){
            if(is_file($file)){ 
                unlink($file); 
            }  
        } 
			rmdir("../Resources/uploads/".$id."/player_images");
		}
		

	}
	


	public function create_character($character_name, $character_stats, $character_notes,$campaign_id,$owner){
		$this->Connect();
		$query = $this->pdo->prepare("INSERT INTO `campaign_characters` (`CHARACTER_NAME`,`CHARACTER_STATS`,`CHARACTER_NOTES`, `CAMPAIGN_ID`, `USER_ID`) VALUES(?,?,?,?,?)");
		$query->execute([$character_name, $character_stats, $character_notes, $campaign_id, $owner]);
	}


	public function get_character_campaign($id){
		$this->Connect();
		$sth=$this->pdo->prepare("SELECT * FROM `campaign_characters` WHERE CHARACTER_ID =?; ");
		$sth->execute([$id]);
		while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
			return($row["CAMPAIGN_ID"]);
		}
	}
	
	
}





?>