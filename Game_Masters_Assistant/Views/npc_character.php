<?php

class NPCCharacter {
	private $NPC_ID;
	private $NPC_NAME;
	private $NPC_STATS;
	private $NOTES;
	private $ACTIVE;

	public function __construct($a, $b, $c, $d, $e){
		$this->NPC_ID    = $a;
		$this->NPC_NAME  = $b;
		$this->NPC_STATS = $c;
		$this->NOTES	 = $d;
		$this->ACTIVE    = $e;
	}
	
	public function __get($var){	
		return $this->$var;
	}

	public function __set($var, $value){
		$this->$var = $value;
	}




}



?>