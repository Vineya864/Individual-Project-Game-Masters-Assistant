<?php

include_once("../views/status_effects_view.php");
include_once("../views/status_effect.php");

require_once("../env.php");
class StatusEffectController {
	
	private $server;
    private $dbname;
    private $username;
    private $password;
    private $pdo;
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
	
	public function getEffectById($id) {
		$this->Connect();
		$query=$this->pdo->prepare("SELECT * FROM `status_effect` WHERE EFFECT_ID =?;");
		 $query->execute([$id]);
		  $row=$query->fetch();
	
		if ($row != null){
		return new StatusEffect($row["EFFECT_ID"], $row["EFFECT_NAME"], $row["NOTES"], $row["ACTIVE"], $row["CAMPAIGN_ID"]  );
		}
	}
	
	public function showCampaignEffect($id,$token){
		$this->Connect();
		$sth=$this->pdo->prepare("SELECT * FROM `status_effect` WHERE CAMPAIGN_ID =? INTERSECT SELECT * FROM `status_effect` WHERE ACTIVE = 1; ");
		$sth->execute([$id]);
		while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
				$effect=$this->getEffectById($row["EFFECT_ID"]);
				$view = new StatusEffectView();
				$view->displayEffectDropDown($effect,$token);
			}
	}

	public function showCampainEffectActiveStatus($id,$token){
		$this->Connect();
		$sth=$this->pdo->prepare("SELECT * FROM `status_effect` WHERE CAMPAIGN_ID =?; ");
		$sth->execute([$id]);
		while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
				$effect=$this->getEffectById($row["EFFECT_ID"]);
				$view = new StatusEffectView();
				$view->displayEffectActiveStatus($effect,$token);
			}
	}

	
	public function ChangeActiveStatus($id,$status){
		$this->Connect();
		$sth=$this->pdo->prepare("UPDATE status_effect SET ACTIVE=? WHERE EFFECT_ID =? ");
		$sth->execute([$status,$id]);
	}


	public function create_Effect($EFFECT_NAME, $NOTES,$CAMPAIGN_ID ){
			$this->Connect();
			$query = $this->pdo->prepare("INSERT INTO `status_effect` (`EFFECT_NAME`, `NOTES`, `CAMPAIGN_ID`) VALUES(?,?,?)");
			$query->execute([$EFFECT_NAME,$NOTES,$CAMPAIGN_ID ]);
				
	}
		
	public function delete_effect($effect_id){
		$this->Connect();
		$sth=$this->pdo->prepare("DELETE FROM `status_effect` WHERE EFFECT_ID =?; ");
		$sth->execute([$effect_id]);		
	}

	public function edit_effect($EFFECT_NAME, $NOTES, $effect_id){
		$this->Connect();
		$sth=$this->pdo->prepare("UPDATE status_effect SET EFFECT_NAME=?, NOTES=? WHERE EFFECT_ID =? ");
		$sth->execute([$EFFECT_NAME, $NOTES, $effect_id]);
	}

	public function delete_campaign($id){
		$this->Connect();
		$sth=$this->pdo->prepare("DELETE FROM `status_effect` WHERE CAMPAIGN_ID =?; ");
		$sth->execute([$id]);		
	}

	public function get_campaign($effectId){
		$this->Connect();
		$sth=$this->pdo->prepare("SELECT * FROM `status_effect` WHERE EFFECT_ID =?; ");
		$sth->execute([$effectId]);
		while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
			return($row["CAMPAIGN_ID"]);
		}

	}
}
?>