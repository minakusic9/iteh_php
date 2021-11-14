<?php
include "broker.php";
class Controller{

    private $broker;
    public static $controller;
    private function __construct(){
      $this->broker=new Broker("localhost","root",'',"bioskop");
    }

    public static function getController(){
        if(!isset($controller)){
            $controller=new Controller();
        }
        return $controller;
    }
 
    public function obradiZahtev(){
        try {
           return vratiOdgovor(izvrsi());
        } catch (Exception $ex) {
            return $this->vratiGresku($ex->getMessage());
        }
    }

    private function izvrsi(){
        
    }

     private function vratiOdgovor($podaci){
        if(!isset($podaci)){
            return[
                "status"=>true,
            ];
        }
        return[
            "status"=>true,
            "data"=>$podaci
        ];
    }
     private function vratiGresku($greska){
        return[
            "status"=>false,
            "error"=>$greska
        ];
    }
}


?>