<?php

include_once("../views/item_view.php");
include_once("../views/item.php");
require_once("../env.php");

class ItemController {
	
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
	
	
	
	public function getItemById($id) {
		$this->Connect();
		$query=$this->pdo->prepare("SELECT * FROM `items` WHERE ITEM_ID =?;");
		 $query->execute([$id]);
		  $row=$query->fetch();
	
		if ($row != null){
		return new Item($row["ITEM_ID"], $row["ITEM_NAME"],$row["ITEM_DESCRIPTION"], $row["CAMPAIGN_ID"], $row["ACTIVE"], $row["HELD_BY"]  );
		}
	}
	
	public function showCampainItems($id,$token){
		$this->Connect();
		$sth=$this->pdo->prepare("SELECT * FROM `items` WHERE CAMPAIGN_ID =? INTERSECT SELECT * FROM `items` WHERE ACTIVE = 1; ");
		$sth->execute([$id]);

		while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
				$item =$this->getItemById($row["ITEM_ID"]);
				$view = new ItemView();
				$view->displayItemDropDown($item,$token);

			}
		
	}

	public function showItemActiveStatus($id,$token){
		$this->Connect();
		$sth=$this->pdo->prepare("SELECT * FROM `items` WHERE CAMPAIGN_ID =?; ");
		$sth->execute([$id]);
		while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
				$item =$this->getItemById($row["ITEM_ID"]);
				$view = new ItemView();
				$view->displayItemActiveStatus($item,$token);
			}
	}

	
	public function ChangeActiveStatus($id,$status){
		$this->Connect();
		$sth=$this->pdo->prepare("UPDATE items SET ACTIVE=? WHERE Item_ID =? ");
		$sth->execute([$status,$id]);
		
	}


	public function create_Item($ITEM_NAME, $ITEM_DESCRIPTION, $CAMPAIGN_ID ){
	
			$this->Connect();
			$query = $this->pdo->prepare("INSERT INTO`items` (`ITEM_NAME`,`ITEM_DESCRIPTION`,`CAMPAIGN_ID`) VALUES(?,?,?)");
			$query->execute([$ITEM_NAME, $ITEM_DESCRIPTION,$CAMPAIGN_ID ]);
				
	}
		

	public function delete_Item($item_id){
		$this->Connect();
		$sth=$this->pdo->prepare("DELETE FROM `items` WHERE ITEM_ID =?; ");
		$sth->execute([$item_id]);		
	}

	public function edit_item($ITEM_NAME, $ITEM_DESCRIPTION, $ITEM_ID){
		$this->Connect();
		$sth=$this->pdo->prepare("UPDATE items SET ITEM_NAME=?, ITEM_DESCRIPTION=? WHERE ITEM_ID =? ");
		$sth->execute([$ITEM_NAME, $ITEM_DESCRIPTION, $ITEM_ID]);
	}

	public function drop_item($player_id,$item_id){
		$this->Connect();
		$list=$this->getItemById($item_id)->HELD_BY;
		$search=",".$player_id.",";
		$new_list= str_replace($search,"",$list);
		$sth=$this->pdo->prepare("UPDATE items SET HELD_BY=? WHERE ITEM_ID =? ");
		$sth->execute([$new_list, $item_id]);
	}
	public function add_item($player_id,$item_id){
		$this->Connect();
		$list=$this->getItemById($item_id)->HELD_BY;
		$new_list= $list.",".$player_id.",";
		$sth=$this->pdo->prepare("UPDATE items SET HELD_BY=? WHERE ITEM_ID =? ");
		$sth->execute([$new_list, $item_id]);
		return $this->pdo->lastInsertId();
	}
	public function delete_campaign($campaign_id){
		$this->Connect();
		$sth=$this->pdo->prepare("DELETE FROM `items` WHERE CAMPAIGN_ID =?; ");
		$sth->execute([$campaign_id]);		
	}

	public function held_by($item_id,$user_id){
		$this->Connect();
		$search_id=",".$user_id.",";
		$sth=$this->pdo->prepare("SELECT * FROM `items` WHERE ITEM_ID =? INTERSECT SELECT * FROM `items` WHERE HELD_BY like ?; ");
		$sth->execute([$item_id,$search_id]);
		while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
			if(is_null($row)){
				return false;
			}else{
				return true;
			}
		}
	}
	

	public function showMyItems($campaign_id,$user_id,$token) {
		$this->Connect();
		$search_id=",".$user_id.",";
		$sth=$this->pdo->prepare("SELECT * FROM `items` WHERE CAMPAIGN_ID =? INTERSECT SELECT * FROM `items` WHERE HELD_BY like ?; ");
		$sth->execute([$campaign_id,$search_id]);
		while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
				$item=$this->getItemById($row["ITEM_ID"]);
				$view = new ItemView();
				$view->displayItemDropDown($item,$token);
			}
	}

	public function characterDrop($campaign_id,$user_id) {
		$this->Connect();
		$search_id=",".$user_id.",";
		echo $search_id;
		$sth=$this->pdo->prepare("SELECT * FROM `items` WHERE CAMPAIGN_ID =? INTERSECT SELECT * FROM `items` WHERE HELD_BY like ?; ");
		$sth->execute([$campaign_id,$search_id]);
		while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
				$this->drop_item($user_id,$row["ITEM_ID"]);
			}
	}




}

?>