<?php

namespace wishlist\model;

class User extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    /**
     * Fonction permettant de retourner les listes de l'utilisateur.
     *
     * @return Liste[] Listes de l'utilisateur.
     */
    public function listes()
    {
        return $this->hasMany('wishlist\model\Liste', 'user_id');
    }


    /**
     * Fonction permettant de retourner les listes auxquelles l'utilisateur a participé.
     *
     * @return Liste[] Listes auxquelles l'utilisateur a participé.
     */
    public function aParticipe(){
        return $this->hasMany('wishlist\model\Item', 'user_id');    
	}
	
    /**
     * Fonction permettant de rendre une vue pour l'utilisateur.
     *
     */
    public function toString() {
    	$prenom = $this->prenom;
    	
    	$html = "<h3>$prenom</h3>";

		return $html;
    }
}
