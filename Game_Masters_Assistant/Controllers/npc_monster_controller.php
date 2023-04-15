<?php

include_once("../views/npc_monster_view.php");
include_once("../views/npc_monster.php");
require_once("../env.php");


class NPCMonsterController {
	
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
	
	
	
	public function getNPCMonsterById($id) {
		$this->Connect();
		$query=$this->pdo->prepare("SELECT * FROM `npc_monster` WHERE MONSTER_ID =?;");
		 $query->execute([$id]);
		  $row=$query->fetch();
		if ($row != null){
			return new NPCMonster($row["MONSTER_ID"], $row["MONSTER_NAME"],$row["MONSTER_STATS"], $row["NOTES"], $row["ACTIVE"]  );
		}
	}
	
	public function showCampainMonster($id,$token){
		$this->Connect();
		$sth=$this->pdo->prepare("SELECT * FROM `NPC_monster` WHERE CAMPAIGN_ID =? INTERSECT SELECT * FROM `NPC_monster` WHERE ACTIVE = 1; ");
		$sth->execute([$id]);

		while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
				$character=$this->getNPCMonsterById($row["MONSTER_ID"]);
				$view = new NPCMonsterView();
				$view->displayCharacterDropDown($character,$token);
			}
		
	}

	public function showCampainMonsterActiveStatus($id,$token){
		$this->Connect();
		$sth=$this->pdo->prepare("SELECT * FROM `NPC_monster` WHERE CAMPAIGN_ID =?; ");
		$sth->execute([$id]);
		while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
				$character=$this->getNPCMonsterById($row["MONSTER_ID"]);
				$view = new NPCMonsterView();
				$view->displayCharacterActiveStatus($character,$token);
			}
	}

	
	public function ChangeActiveStatus($id,$status){
		$this->Connect();
		$sth=$this->pdo->prepare("UPDATE npc_monster SET ACTIVE=? WHERE MONSTER_ID =? ");
		$sth->execute([$status,$id]);
		
	}


	public function create_monster($NPC_NAME, $NPC_STATS, $NOTES,$CAMPAIGN_ID ){
	
			$this->Connect();
			$query = $this->pdo->prepare("INSERT INTO`npc_monster` (`MONSTER_NAME`,`MONSTER_STATS`, `NOTES`, `CAMPAIGN_ID`) VALUES(?,?,?,?)");
			$query->execute([$NPC_NAME, $NPC_STATS, $NOTES,$CAMPAIGN_ID ]);
				
	}
		

	public function delete_NPC($character_id){
		$this->Connect();
		$sth=$this->pdo->prepare("DELETE FROM `npc_monster` WHERE MONSTER_ID =?; ");
		$sth->execute([$character_id]);		
	}

	public function edit_NPC($NPC_NAME, $NPC_STATS, $NOTES, $character_id){
		$this->Connect();
		$sth=$this->pdo->prepare("UPDATE npc_monster SET MONSTER_NAME=?, MONSTER_STATS=?, NOTES=? WHERE MONSTER_ID =? ");
		$sth->execute([$NPC_NAME, $NPC_STATS, $NOTES, $character_id]);
	}

	public function delete_campaign($id){
		$this->Connect();
		$sth=$this->pdo->prepare("DELETE FROM `npc_monster` WHERE CAMPAIGN_ID =?; ");
		$sth->execute([$id]);		
	}

	public function get_campaign($npcId){
		$this->Connect();
		$sth=$this->pdo->prepare("SELECT * FROM `NPC_monster` WHERE MONSTER_ID =?; ");
		$sth->execute([$npcId]);
		while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
			return($row["CAMPAIGN_ID"]);
		}

	}

	




}

	
	
	






?>