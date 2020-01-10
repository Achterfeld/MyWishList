<?php

namespace wishlist\controler;

use \Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\Liste;
use wishlist\model\Item;
use wishlist\view\VueHome;


class HomeControler
{
	/**
	 * Fonction permettant d'accéder au home.
	 *
	 * @param int $option Si le paramètre n'est pas renseigné il est égal à rien, dans le cas contraire il permet de modifier la vue home.
	 *
	 */
    public function getHome($option = "")
    {
        $v = new VueHome();
        $v->render($option);
    }
}
