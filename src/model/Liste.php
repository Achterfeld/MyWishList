<?php

namespace wishlist\model;

class Liste extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'liste';
    protected $primaryKey = 'no';
    public $timestamps = false;

    public function item()
    {
        return $this->hasMany('wishlist\model\Item', 'liste_id');
    }

    public static function possede(){
        return $this->belongsTo('wishlist\model\User','user_id');
    }


    public function __toString()
    {
        $str = "
        <div class='list'>
        <div class='num num_liste'>$this->no</div>
        <h3>$this->titre : $this->description </h3><br>
        Numéro d'utilisateur : $this->user_id |
        expire le $this->expiration <br><br>";/*|
        token $this->token " ;*/

        $itDedans = $this->item()->get();
        $str .= "<ul>";
        foreach ($itDedans as $key => $value) {

            $str .= "<li><a class='lienSCouleur' href='/myWishList/item/reservation/$value->id'>$value->nom</a></li> ";
        }
        $str .= "</ul></div>";

        return $str;
    }
}
