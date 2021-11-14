<?php

class Broker{
   
    private $mysqli;
    public function __construct($host,$username,$pass,$db){
        $this->mysqli = new mysqli($host,$username,$pass,$db);
        $this->mysqli->set_charset("utf8");
    }
    function izvrsiCitanje($upit){
        $rezultat=$this->mysqli->query($upit);
       
        if(!$rezultat){
          throw new Exception($this->mysqli->error);
        }
        $rez=[];
            while($red=$rezultat->fetch_object()){
                $rez[]=$red;
            }
            return $rez;
    }
    function izvrsiIzmenu($upit){
        $rezultat=$this->mysqli->query($upit);
    
        if(!$rezultat){
           throw new Exception($this->mysqli->error);
        }
       
    }
   
}

?>
