<?php

class SharedImage{
private $id;
private $path;
private $active;
private $back_ground;



    public function __construct($a,$b,$c,$d){
        $this->id           = $a;
        $this->path         = $b;
        $this->active       = $c;
        $this->back_ground = $d;
    }

    public function __get($var){	
        return $this->$var;
    }

    public function __set($var, $value){
        $this->$var = $value;
    }

}


?>