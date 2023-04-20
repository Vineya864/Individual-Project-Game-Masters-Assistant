<?php

include_once("../views/campaign_view.php");
include_once("../views/campaign.php");
require_once("../env.php");

class CampaignController {
	
	private $server;
    private $dbname;
    private $username;
    private $password;
    private $pdo;
	//populate variables
	public function __construct($a,$b){
		$this->server = $a;
		$this->dbname = $b;
		$this->username = apache_getenv('USER_NAME');
		$this->password = apache_getenv('PASSWORD');
		$this->pdo =null;
	}
	
	
	//conntect to the database
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
	
		//given id show camapign using view
	public function showCampaignById($id) {
		$this->Connect();
		$query=$this->pdo->prepare("SELECT * FROM `campaign` WHERE CAMPAIGN_ID =?;");
		$query->execute([$id]);
		$row=$query->fetch();
	
		if ($row != null){
		$campaign=$this->getCampaignById($row["CAMPAIGN_ID"]);
		$view = new campaignView();
		$view->displayCampagin($campaign);
	
		}
	}
	//using view show all campaigns owend by given dm
	public function showCampaignByDm($gm, $token){
		$this->Connect();
		$query=$this->pdo->prepare("SELECT * FROM `campaign` WHERE GAME_MASTER_ID =?;");
		$query->execute([$gm]);
		while($row =  $query->fetch(PDO::FETCH_ASSOC)) {
			if ($row != null){
				$campaign_view= new campaignView(null,null);
				$campaign_view->displayCampaginSelectionGm(new Campaign($row["CAMPAIGN_ID"], $row["CAMPAIGN_NAME"]),$token);
			}
		}
	}
	//check if the id is a game master
	public function isGM($gm){
		$this->Connect();
		$query=$this->pdo->prepare("SELECT * FROM `campaign` WHERE GAME_MASTER_ID =?;");
		$query->execute([$gm]);
		$row=$query->fetch();
		if ($row != null){
		 return true;
		}else{
			return false;
		}
		
	}
	//show all cAMPAIGS WITH ID using view
	public function showCampaignSelectionByID($ID, $token){
		$this->Connect();
		$query=$this->pdo->prepare("SELECT * FROM `campaign` CAMPAIGN_ID =?;");
		$query->execute([$gm]);
		while($row =  $query->fetch(PDO::FETCH_ASSOC)) {
			if ($row != null){
				$campaign_view= new campaignView(null,null);
				$campaign_view->displayCampaginSelectionGm(new Campaign($row["CAMPAIGN_ID"], $row["CAMPAIGN_NAME"]),$token);
			}
		}
	}
	//return the campagin id
	public function getCampaignById($id) {
		$this->Connect();
		$query=$this->pdo->prepare("SELECT * FROM `campaign` WHERE CAMPAIGN_ID =?;");
		$query->execute([$id]);
		$row=$query->fetch();
	
		if ($row != null){
		return new Campaign($row["CAMPAIGN_ID"], $row["CAMPAIGN_NAME"]);
		}
	}

	//return the id of the game master
	public function getGMByCampagin($id) {
		$this->Connect();
		$query=$this->pdo->prepare("SELECT * FROM `campaign` WHERE CAMPAIGN_ID =?;");
		$query->execute([$id]);
		$row=$query->fetch();
	
		if ($row != null){
		return $row["GAME_MASTER_ID"];
		}
	}

	//upload a new campaing to database
	public function createCampaign($name, $masterId ){
		$this->Connect();
		$query = $this->pdo->prepare("INSERT INTO `campaign` (`CAMPAIGN_NAME`, `GAME_MASTER_ID`) VALUES(?,?)");
		$query->execute([$name, $masterId ]);
		
		return $this->pdo->lastInsertId();		
	}

	//change owner ship of given campaign to given user
	public function change_master($campaign_id,$id){
		$this->Connect();
		$sth=$this->pdo->prepare("UPDATE `campaign` SET GAME_MASTER_ID=? WHERE CAMPAIGN_ID =? ");
		$sth->execute([$id,$campaign_id]);
	}
	//remove the campaign from the databases
	public function delete_campaign($campaign_id){
		$this->Connect();
		$sth=$this->pdo->prepare("DELETE FROM `campaign` WHERE CAMPAIGN_ID =?; ");
		$sth->execute([$campaign_id]);		
	}
	
}





?>