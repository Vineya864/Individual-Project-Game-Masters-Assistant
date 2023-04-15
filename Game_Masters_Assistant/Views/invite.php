<?php

class Invite {
	private $id;
	private $USER_ID;
	private $CAMPAIGN_ID;
	private $reponse;

	public function __construct($a, $b, $c, $d){
		$this->MESSAGE_ID = $a;
		$this->USER_ID = $b;
		$this->CAMPAIGN_ID = $c;
		$this->MESSAGE = $d;
	}
	
	public function __get($var){	
		return $this->$var;
	}

	public function __set($var, $value){
		$this->$var = $value;
	}





}



?>