<?php

class Campaign {
	private $CAMPAIGN_ID;
	private $CAMPAIGN_NAME;

	
	public function __construct($a, $b){
		$this->CAMPAIGN_ID = $a;
		$this->CAMPAIGN_NAME = $b;
	}
	
	public function __get($var){	
		return $this->$var;
	}

	public function __set($var, $value){
		$this->$var = $value;
	}





}



?>