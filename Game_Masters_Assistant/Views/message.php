<?php

class Message {
	private $MESSAGE_ID;
	private $USER_ID;
	private $CAMPAIGN_ID;
	private $MESSAGE;
	private $DESTINATION;
	
	public function __construct($a, $b, $c, $d, $e){
		$this->MESSAGE_ID = $a;
		$this->USER_ID = $b;
		$this->CAMPAIGN_ID = $c;
		$this->MESSAGE = $d;
		$this->DESTINATION =$e;
	}
	
	public function __get($var){	
		return $this->$var;
	}

	public function __set($var, $value){
		$this->$var = $value;
	}





}



?>