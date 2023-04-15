<?php

class NPCMonster {
	private $MONSTER_ID;
	private $MONSTER_NAME;
	private $MONSTER_STATS;
	private $NOTES;
	private $ACTIVE;

	public function __construct($a, $b, $c, $d, $e){
		$this->MONSTER_ID    = $a;
		$this->MONSTER_NAME  = $b;
		$this->MONSTER_STATS = $c;
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