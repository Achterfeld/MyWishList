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
        (no) $this->no |
        (titre) $this->titre |
        (user_id) $this->user_id |
        (description) $this->description |
        (expiration) $this->expiration ";/*|
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
