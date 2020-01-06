<?php

namespace wishlist\model;

class User extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    public function listes()
    {
        return $this->hasMany('wishlist\model\Liste', 'user_id');
    }


    public function aParticipe(){
        return $this->hasMany('wishlist\model\Item', 'user_id');    
	}
	
    public function toString() {
    	$prenom = $this->prenom;
    	
    	$html = "<h3>$prenom</h3>";

		return $html;
    }
}
