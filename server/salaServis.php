<?php

class SalaServis{

    private $broker;

    public function __construct($b){
        $this->broker=$b;
    }
    public function vratiSve(){
        return $broker->ucitaj("select * from sala");
    }
}

?>