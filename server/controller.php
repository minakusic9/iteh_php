<?php
include "broker.php";
include "filmServis.php";
class Controller{

    private $broker;
    private $filmServis;
    private static $controller;
    
    private function __construct(){
        $this->broker=new Broker("localhost","root",'',"bioskop");
        $this->filmServis=new FilmServis($this->broker);
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
        $akcija=$_GET["akcija"];
        $metoda=$_REQUEST['REQUEST_METHOD'];

        if($akcija=='filmovi.read'){
            if($metoda!=="GET"){
                throw new Exception("Akcija se moze pozvati samo GET metodom");
            }
            return $this->filmServis->vratiSve();
        }
        if($akcija=='filmovi.create'){
            if($metoda!=="POST"){
                throw new Exception("Akcija se moze pozvati samo POST metodom");
            }
            $this->filmServis->kreiraj($POST["naziv"],$POST["trajanje"],$POST["ocena"]);
            return null;
        }
        if($akcija=='filmovi.update'){
            if($metoda!=="POST"){
                throw new Exception("Akcija se moze pozvati samo POST metodom");
            }
            $this->filmServis->izmeni($POST["id"],$POST["naziv"],$POST["trajanje"],$POST["ocena"]);
            return null;
        }
        if($akcija=='filmovi.delete'){
            if($metoda!=="POST"){
                throw new Exception("Akcija se moze pozvati samo POST metodom");
            }
            $this->filmServis->obrisi($POST["id"]);
            return null;
        }
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