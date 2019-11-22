<?php
namespace wishlist\modele;
class Liste extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'liste';
    protected $primaryKey = 'no';
    public $timestamps = false;

    public function item() {
    	return $this->hasMany('wishlist\modele\item', 'liste_id');
    }

    
    public function __toString() 
    {    
        $str ="
        no $this->no |
        user_id $this->user_id |
        titre $this->titre |
        description $this->description |
        expiration $this->expiration ";/*|
        token $this->token " ;*/

        $itDedans = $this->item()->get();

        foreach ($itDedans as $key => $value) {
            $str=$str."<br>$value->nom ";
        }
        return $str; 
    } 
}
