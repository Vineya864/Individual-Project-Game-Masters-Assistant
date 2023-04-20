<?php

include_once("../views/message_view.php");
include_once("../views/message.php");
require_once("../env.php");

class MessageController {
	
	private $server;
    private $dbname;
    private $username;
    private $password;
    private $pdo;
	//set up variables 

	public function __construct($a,$b){
		$this->server = $a;
		$this->dbname = $b;
		$this->username = apache_getenv('USER_NAME');
		$this->password = apache_getenv('PASSWORD');
		$this->pdo =null;
	}
	
	
	//connect
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
	//return the message using id
	public function getMessageById ($id){
		$this->Connect();
		$query=$this->pdo->prepare("SELECT * FROM `message` where MESSAGE_ID =? ;");
		$query->execute([$id]);
		$row=$query->fetch();
		if ($row != null){
			return new Message($row["MESSAGE_ID"],$row["USER_ID"],$row["CAMPAIGN_ID"],$row["MESSAGE"],$row["DESTINATION"]);
		}
	
	}
	
	//using view show all messages in the campaign
	public function showMessageByCampaignId($id,$destination) {
		$this->Connect();
		$sth=$this->pdo->prepare(" SELECT * FROM `message` where CAMPAIGN_ID = ? INTERSECT SELECT * FROM `message` Where DESTINATION like ? ORDER BY DATE_TIME ;");
		$destinationSearch= "%," . $destination . ",%";
		$sth->execute([$id,$destinationSearch]);
		while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
				$message=$this->getMessageById($row["MESSAGE_ID"]);
				$view = new MessageView();
				$view->displayMessage($message);
			}
	
	}
	
	//save a new message to the database using the current date
	public function addMessage( $userId, $campaignId, $message, $destination, $username ){
		$date = date("Y/m/d");
		$this->Connect();
		$message = filter_var($message,FILTER_SANITIZE_STRING);
		$message = $username . ":" . $message ;
		$sth= $this->pdo->prepare("INSERT INTO message(USER_ID, CAMPAIGN_ID, MESSAGE, DESTINATION, DATE_TIME) VALUES(?,?,?,?,?)");
		$sth->execute([$userId, $campaignId, $message, $destination, $date]);
		
		
	}




}
?>