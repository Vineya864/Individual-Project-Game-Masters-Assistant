<?php

include_once("../views/campaign_notes_view.php");
include_once("../views/campaign_notes.php");
require_once("../env.php");

class CampaignNotesController {
	
	private $server;
    private $dbname;
    private $username;
    private $password;
    private $pdo;
// define the constructor which has four arguments for $server, $dbname, $username, $password. 
	// The $pdo field should be assigned as null  

	public function __construct($a,$b){
		$this->server = $a;
		$this->dbname = $b;
		$this->username = apache_getenv('USER_NAME');
		$this->password = apache_getenv('PASSWORD');
		$this->pdo =null;
	}
	
	
	//connect to database
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
	
	

	//show the notes for the owner and campaign
	public function ShowNotes($ownerID, $campaignID,$token) {
		$this->Connect();
		$query=$this->pdo->prepare("SELECT * FROM `notes` WHERE CAMPAIGN_ID =?  INTERSECT SELECT * FROM `notes` WHERE OWNER_ID = ? ;");	
		$query->execute([$campaignID,$ownerID]);
		$view = new campaignNotesView();
		while($row =  $query->fetch(PDO::FETCH_ASSOC)) {
			$note=$this->getNoteById($row["NOTE_ID"]);
			$view->displayCampaginNotesTabs($note,$token);
			$view->displayCampaginNotesContent($note,$token);
		}
		

	}
	//create a new note and save to database
	public function create_note($note_chapter,$note_text,$user_id,$campaign_id){
		$this->Connect();
		$query = $this->pdo->prepare("INSERT INTO`notes` (`CAMPAIGN_ID`,`OWNER_ID`, `CHAPTER`, `NOTES`) VALUES(?,?,?,?)");
		$query->execute([$campaign_id, $user_id, $note_chapter,$note_text]);
	}
	//update the saved note
	public function edit_note($note_chapter, $note_text, $note_id){
		$this->Connect();
		$sth=$this->pdo->prepare("UPDATE `notes` SET CHAPTER=?, NOTES=? WHERE NOTE_ID =? ");
		$sth->execute([$note_chapter, $note_text, $note_id]);
	}
	//remove not from databse
	public function delete_note($note_id){
		$this->Connect();
		$sth=$this->pdo->prepare("DELETE FROM `notes` where NOTE_ID =? ;");
		$sth->execute([$note_id]);
	}
	//return given id note if found
	public function getNoteByID($id){
		$this->Connect();
		$query=$this->pdo->prepare("SELECT * FROM `notes` where NOTE_ID =? ;");
		$query->execute([$id]);
		$row=$query->fetch();
		if ($row != null){
			return new CampaignNotes($row["NOTE_ID"],$row["CAMPAIGN_ID"],$row["OWNER_ID"],$row["CHAPTER"],$row["NOTES"],$row["OWNER_ID"]);
		}
	}

	//delete all notes linked to campaign 
	public function delete_campaign($campaign_id){
		$this->Connect();
		$sth=$this->pdo->prepare("DELETE FROM `notes` where CAMPAIGN_ID =? ;");
		$sth->execute([$campaign_id]);
	}

	//check that the given id has access to the note
	public function check_owner($userId, $noteId){
		if($userId==($this->getNoteByID($noteId))->owner_id){
			return true;
		}else{
			return false;
		}
	}

	
}





?>