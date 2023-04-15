<?php

class Item {
	private $ITEM_ID;
	private $ITEM_NAME;
	private $ITEM_DESCRIPTION;
	private $CAMPAIGN_ID;
	private $ACTIVE;
    private $HELD_BY;
	
	public function __construct($a, $b, $c, $d, $e, $f){
		$this->ITEM_ID          = $a;
		$this->ITEM_NAME        = $b;
		$this->ITEM_DESCRIPTION = $c;
		$this->CAMPAIGN_ID      = $d;
		$this->ACTIVE           = $e;
        $this->HELD_BY          = $f;
	}
	
	public function __get($var){	
		return $this->$var;
	}

	public function __set($var, $value){
		$this->$var = $value;
	}





}



?>