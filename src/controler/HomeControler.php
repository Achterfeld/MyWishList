<?php

namespace wishlist\controler;

use \Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\Liste;
use wishlist\model\Item;
use wishlist\view\VueHome;


class HomeControler {   

    public function getHome($option="") {
        $v = new VueHome();
        $v->render($option);
    }
}