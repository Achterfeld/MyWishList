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
        if (isset($_SESSION['user_id'])) {
			$u = User::where('user_id','=',$_SESSION['session']['user_id'])->first();
	        $v->vuePPerso($u);
        }
//        $v->render();
    }
}