<?php

namespace wishlist\modele;

class Liste extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'liste';
    protected $primaryKey = 'no';
    public $timestamps = false;

    public function item()
    {
        return $this->hasMany('wishlist\modele\item', 'liste_id');
    }


    public function __toString()
    {
        $str = "
        <div class='list'>
        <div class='num num_liste'>$this->no</div>
        <h3>$this->titre : $this->description </h3><br>
        (user_id) $this->user_id |
        expire le $this->expiration <br><br>";/*|
        token $this->token " ;*/

        $itDedans = $this->item()->get();
        $str .= "<ul>";
        foreach ($itDedans as $key => $value) {
            $str .= "<li>$value->nom</li> ";
        }
        $str .= "</ul></div>";

        return $str;
    }
}
