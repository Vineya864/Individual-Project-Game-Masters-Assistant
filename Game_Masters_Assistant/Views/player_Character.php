<?php

class PlayerCharacter {
	private $CHARACTER_ID;
	private $CHARACTER_NAME;
	private $CHARACTER_STATS;
	private $PICTURE;
	private $CHARACTER_NOTES;

	public function __construct($a, $b, $c, $d, $e){
		$this->CHARACTER_ID    = $a;
		$this->CHARACTER_NAME  = $b;
		$this->CHARACTER_STATS = $c;
		$this->PICTURE		   = $d;
		$this->CHARACTER_NOTES = $e;
	}
	
	public function __get($var){	
		return $this->$var;
	}

	public function __set($var, $value){
		$this->$var = $value;
	}





}



?>