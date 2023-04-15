<?php

class User{
private $id;
private $username;



    public function __construct($a,$b){
        $this->id = $a;
        $this->username = $b;
    }

    public function __get($var){	
        return $this->$var;
    }

    public function __set($var, $value){
        $this->$var = $value;
    }

}


?>