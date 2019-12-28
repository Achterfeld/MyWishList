<?php

namespace wishlist\controler;

use \Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\Liste;
use wishlist\model\Item;
use wishlist\view\VueCreation;
use wishlist\view\VueGenerale;
use wishlist\view\VueHome;


class notFoundControler
{

    public function get404()
    {

        $html = <<<END
        <div style="display: flex;">
        <img style="width: 50vw;height : 100%" src="/myWishList/img/404.png" >
        <h1><a href='/myWishList'  style="color:#000; text-decoration:underline"> Retour à l'accueil</a></h1>
        
        </div>

END;

        $v = new VueGenerale();
        VueGenerale::renderPage($html);
    }
}
