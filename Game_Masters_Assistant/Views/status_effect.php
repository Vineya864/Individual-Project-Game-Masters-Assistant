<?php

class StatusEffect {
	private $EFFECT_ID;
	private $EFFECT_NAME;
	private $NOTES;
    private $CAMPAIGN_ID;
	private $ACTIVE;

	public function __construct($a, $b, $c, $d,$e){
		$this->EFFECT_ID    = $a;
		$this->EFFECT_NAME  = $b;
		$this->NOTES	    = $c;
		$this->ACTIVE       = $d;
        $this->CAMPAIGN_ID  = $e;
	}
	
	public function __get($var){	
		return $this->$var;
	}

	public function __set($var, $value){
		$this->$var = $value;
	}




}



?>