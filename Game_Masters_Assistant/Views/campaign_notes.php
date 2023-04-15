<?php

class CampaignNotes{
private $id;
private $campaign_id;
private $owner_id;
private $chapter;
private $notes;



    public function __construct($a,$b,$c,$d,$e,$f){
        $this->id          = $a;
        $this->campaign_id = $b;
        $this->campaign_id = $c;
        $this->chapter     = $d;
        $this->notes       = $e;
        $this->owner_id    = $f;
    }

    public function __get($var){	
        return $this->$var;
    }

    public function __set($var, $value){
        $this->$var = $value;
    }

}


?>