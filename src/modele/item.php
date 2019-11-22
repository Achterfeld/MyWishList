<?php
namespace wishlist\modele;
class Item extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'item';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function liste() {
    	return $this->belongsTo('wishlist\modele\Liste', 'liste_id');
    }

    public function __toString() 
    {    
        $str ="
        (id) $this->id |
        (nom liste) ".$this->liste()->first()['titre']." |
        (liste_id) $this->liste_id |
        (nom) $this->nom |
        (descr) $this->descr |
        (img) $this->img |
        (url) $this->url |
        (tarif) $this->tarif" ;
        return $str; 
    } 

}
