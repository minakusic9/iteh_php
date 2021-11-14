<?php

class PrikazServis{

    private $broker;

    public function __construct($b){
        $this->broker=$b;
    }
    public function vratiSve(){
        $data= $broker->ucitaj("select p.*, s.naziv as 'naziv_sale', f.naziv as 'naziv_filma', f.trajanje from prikaz p inner join sala s on(s.id=p.sala) inner join film f on (f.id=p.film_id)");
        $res=[];
        foreach($data as $element){
            $res[]=[
                "id"=>intval($element->id),
                "cena"=>doubleval($element->cena),
                "datum"=>$element->datum,
                "film"=>[
                    "id"=>intval($element->film_id),
                    "naziv"=>$element->naziv_filma,
                    "trajanje"=>intval($element->trajanje)
                ],
                "sala"=>[
                    "id"=>intval($element->sala),
                    "naziv"=>$element->naziv_sale
                ]
            ];
        }
        return $res;
    }

    public function kreiraj($filmId,$salaId,$cena,$datum){
        
        $film=$broker->ucitaj("select * from film where id=".$filmId);
        $trajanje=intval($film->trajanje);
        $prikazi=$broker->ucitaj("select * from prikaz where sala=".$salaId);
        $vreme=strtotime($datum);
        foreach ($prikazi as $prikaz) {
            $vremePrikaza=strtotime($prikaz->datum);
            if($vremePrikaza<$vreme && ($vremePrikaza+$trajanje*60000)>$vreme && $salaId==intval($prikaz->sala)){
                throw new Exception("Sala je zauzeta u ovom terminu");
            }
            $broker->upisi("insert into prikaz(film_id,sala,cena,datum) values(".$filmId.",".$salaId.",".$cena.",'".$datum."')");
        }
    }
   
    public function obrisi($id){
        $broker->upisi("delete from prikaz where id=".$id);
    }
}

?>