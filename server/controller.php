<?php
include "broker.php";
include "filmServis.php";
include "salaServis.php";
include "prikazServis.php";
class Controller{

    private $broker;
    private $filmServis;
    private $salaServis;
    private $prikazServis;
    private static $controller;
    
    private function __construct(){
        $this->broker=new Broker("localhost","root",'',"bioskop");
        $this->filmServis=new FilmServis($this->broker);
        $this->salaServis=new SalaServis($this->broker);
        $this->prikazServis=new PrikazServis($this->broker);
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

        if($akcija=='film.read'){
            if($metoda!=="GET"){
                throw new Exception("Akcija se moze pozvati samo GET metodom");
            }
            return $this->filmServis->vratiSve();
        }
        if($akcija=='film.create'){
            if($metoda!=="POST"){
                throw new Exception("Akcija se moze pozvati samo POST metodom");
            }
            $this->filmServis->kreiraj($POST["naziv"],$POST["trajanje"],$POST["ocena"]);
            return null;
        }
        if($akcija=='film.update'){
            if($metoda!=="POST"){
                throw new Exception("Akcija se moze pozvati samo POST metodom");
            }
            $this->filmServis->izmeni($POST["id"],$POST["naziv"],$POST["trajanje"],$POST["ocena"]);
            return null;
        }
        if($akcija=='film.delete'){
            if($metoda!=="POST"){
                throw new Exception("Akcija se moze pozvati samo POST metodom");
            }
            $this->filmServis->obrisi($POST["id"]);
            return null;
        }
        if($akcija=='sala.read'){
            if($metoda!=="GET"){
                throw new Exception("Akcija se moze pozvati samo GET metodom");
            }
            return $this->salaServis->vratiSve();
        }
        if($akcija=='prikaz.read'){
            if($metoda!=="GET"){
                throw new Exception("Akcija se moze pozvati samo GET metodom");
            }
            return $this->prikazServis->vratiSve();
        }
        if($akcija=='prikaz.create'){
            if($metoda!=="POST"){
                throw new Exception("Akcija se moze pozvati samo POST metodom");
            }
            $this->prikazServis->kreiraj($POST["filmId"],$POST["salaId"],$POST["cena"],$POST["datum"]);
            return null;
        }
        if($akcija=='prikaz.delete'){
            if($metoda!=="POST"){
                throw new Exception("Akcija se moze pozvati samo POST metodom");
            }
            $this->prikazServis->obrisi($POST["id"]);
            return null;
        }
        throw new Exception("Akcija nije podrzana");
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