<?php

namespace wishlist\controler;

use \Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\User;
use wishlist\view\VueIdentifiant;


class IdentifiantControler {   

    public function insertUser() {
        //$nom, $prenom, $dateNaiss, $email, $hash
        $app = new \Slim\Slim;

        $v = new User(); //A FINIR , creer un user avec les tab post
    }
}