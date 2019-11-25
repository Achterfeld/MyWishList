<?php

namespace wishlist\model;

class Item extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'item';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function liste()
    {
        return $this->belongsTo('wishlist\model\Liste', 'liste_id');
    }

    public function __toString()
    {
        $str = "<div class='item'>
        <div class='num num_item'> $this->id </div>
        <div class='description'>"
        . $this->liste()->first()['titre'] . " ($this->liste_id) <br>
        <h3>$this->nom : $this->descr </h3><br>
        <a href=\"$this->url\" ></a>
        $this->tarif €
        </div><div><img src=\"/MyWishList/img/$this->img\"></img> 
        </div></div>";
        return $str;
    }
}
