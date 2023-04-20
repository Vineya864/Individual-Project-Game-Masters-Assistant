<?php

include_once("../views/invite.php");
include_once("../views/invite_view.php");
include_once("../views/campaign.php");
include_once("../views/campaign_view.php");
include_once("../Controllers/campaign_controller.php");
include_once("../views/user.php");
include_once("../Controllers/user_controller.php");


class InviteController {
	
	private $server;
    private $dbname;
    private $username;
    private $password;
    private $pdo;
	// set vairiables for connection

	public function __construct($a,$b){
		$this->server = $a;
		$this->dbname = $b;
		$this->username = apache_getenv('USER_NAME');
		$this->password = apache_getenv('PASSWORD');
		$this->pdo =null;
	}
	
	
	//connect to the database
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
	//create a new invite without response
	public function send_invite($userID, $campaignID){
		$this->Connect();
		$sth= $this->pdo->prepare("INSERT INTO invites(PLAYER_ID, CAMPAIGN_ID) VALUES(?,?)");
		$sth->execute([$userID, $campaignID]);
		return $this->pdo->lastInsertId();		
				
	}
	//get all accepted user invites and display using view
	public function ShowAccepted($userID,$token){
		$campaign  = new CampaignController(null,null);
		$view = new CampaignView();
		$this->Connect();
		$sth=$this->pdo->prepare(" SELECT * FROM invites where PLAYER_ID = ? INTERSECT SELECT * FROM `invites` Where RESPONSE = 1 ;");
		$sth->execute([$userID]);
		while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
			$campaign_found=$campaign->getCampaignById($row["CAMPAIGN_ID"]);
			$view->showCampaignSelectionByID($campaign_found,$token);
		}
	}
	//show all invited campaings without a response uses view
	public function ShowInvited($userID,$token){
		$campaign  = new CampaignController(null,null);
		$view = new CampaignView();
		$user  = new UserController(null,null);
		$invite_view= new InviteView();
		$this->Connect();
		$sth=$this->pdo->prepare(" SELECT * FROM invites where PLAYER_ID = ? INTERSECT SELECT * FROM `invites` Where RESPONSE IS NULL ;");
		$sth->execute([$userID]);
		while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
			$campaign_found=$campaign->getCampaignById($row["CAMPAIGN_ID"]);
			$gm=$user->getUserByID($campaign->getGMByCampagin($row["CAMPAIGN_ID"]));
			$invite_id=$row["INVITE_ID"];
			$invite_view->showInviteOptions($campaign_found->CAMPAIGN_NAME, $gm->username,$invite_id,$token);
		}

	}


//check if invited to campaign
public function invited($userID,$inviteID){
	$this->Connect();
	$sth=$this->pdo->prepare(" SELECT * FROM invites where PLAYER_ID = ? INTERSECT SELECT * FROM `invites` Where CAMPAIGN_ID = ? ;");
	$sth->execute([$userID,$inviteID]);
	while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
		if(is_null($row["INVITE_ID"])){
			return false;
		}else{
			return true;
		}
	}

}
//update the invite true or false
	public function resolve_invite($id, $answer){
		$this->Connect();
		$sth=$this->pdo->prepare("UPDATE invites SET RESPONSE=? WHERE INVITE_ID =? ");
		$sth->execute([$answer,$id]);
	}
//find if the user has been ivited what the ivite number was
	public function getIdByUserIdCampaignId($remove_user,$campaign_id){
		$this->Connect();
		$sth=$this->pdo->prepare(" SELECT * FROM invites where CAMPAIGN_ID = ? INTERSECT SELECT * FROM `invites` Where PLAYER_ID like ? ;");
		$sth->execute([$campaign_id,$remove_user]);
		$row=$sth->fetch();
		if ($row != null){
			return ($row["INVITE_ID"]);
		}

	}
//show all players that have accepted invites uses view
	public function showAllPlayers($campaign_id){
		$user  = new UserController(null,null);
		$view = new InviteView();
		$this->Connect();
		$sth=$this->pdo->prepare(" SELECT * FROM invites where CAMPAIGN_ID = ? INTERSECT SELECT * FROM `invites` Where RESPONSE like '1' ;");
		$sth->execute([$campaign_id]);
		while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
			$player=$user->getUserByID($row["PLAYER_ID"]);
			$view->displayPlayers($player);
		}

	}
//delet an invite with id
	public function remove_invite($id){
		$this->Connect();
		$sth=$this->pdo->prepare("DELETE FROM invites WHERE INVITE_ID =?; ");
		$sth->execute([$id]);		
	}
//delete all invites linked to campaign
	public function delete_campaign($id){
		$this->Connect();
		$sth=$this->pdo->prepare("DELETE FROM invites WHERE CAMPAIGN_ID  =?; ");
		$sth->execute([$id]);	
	}


	

//get list of all ids from the campaign users.
	public function campaignMessage($id){
		$this->Connect();
		$sth=$this->pdo->prepare("SELECT * FROM `invites` WHERE CAMPAIGN_ID =? INTERSECT SELECT * FROM `invites` Where RESPONSE like '1'; ");
		$sth->execute([$id]);
		$destination=",";
		while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
			
				$destination = $destination . "," . $row["PLAYER_ID"] ; 

				
			}
		return $destination;
		
	}




}
?>