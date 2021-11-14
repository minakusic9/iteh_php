<?php

class FilmServis{

    private $broker;

    public function __construct($b){
        $this->broker=$b;
    }
    public function vratiSve(){
        return $broker->ucitaj("select * from film");
    }

    public function kreiraj($naziv,$trajanje,$ocena){
        
        $broker->upisi("insert into film(naziv,trajanje,ocena) values('".$naziv."',".$trajanje.",".$ocena.")");
    }
    public function izmeni($id,$naziv,$trajanje,$ocena){
        $broker->upisi("update film set naziv='".$naziv."', trajanje='".$trajanje."', ocena=".$ocena." where id=".$id);
    }
    public function obrisi($id){
        $broker->upisi("delete from film where id=".$id);
    }
}

?>