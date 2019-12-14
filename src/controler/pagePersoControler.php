<?php

namespace wishlist\controler;

use \Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\Liste;
use wishlist\model\Item;
use wishlist\model\User;
use wishlist\view\VuePagePerso;


class pagePersoControler {   

    public function getPPerso() {
        $v = new VuePagePerso();

        //TODO
        //Utiliser le user_id retenu dans la session
        
        $u = User::where('user_id','=','1')->first();

        $v->vuePPerso($u);
//        $v->render();
    }
}