<?php

namespace wishlist\controler;

use \Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\Liste;
use wishlist\model\Item;
use wishlist\view\VueCreation;
use wishlist\view\VueGenerale;
use wishlist\view\VueHome;


class notFoundControler {   

    public function get404() {

        $html=<<<END
        <a href='\myWishList' class='lienSCouleur'> Retour à l'accueil</a> 
        <br>
        Page introuvable, voulez-vous revenir à l'accueil ?


END;

        $v = new VueGenerale();
        VueGenerale::renderPage($html);
    }
}