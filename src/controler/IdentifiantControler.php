<?php

namespace wishlist\controler;

use \Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\User;
use wishlist\view\VueIdentifiant;
use wishlist\view\VueConnexion;
use wishlist\authentification\Authentification;

class IdentifiantControler {   

    public function insertUser() {

        /*$app = new \Slim\Slim;
        $datas = $app->request();
        
        $v = new User();
        
    	$v->prenom = $datas->post("Prenom");
    	$v->mail = $datas->post("Mail");

    	$hash1 = password_hash($datas->post("Passe1"), PASSWORD_DEFAULT, ['cost'=> 12]);
        
        if (password_verify($datas->post("Passe2"),$hash1)) {
        	$v->hash = $hash1;
            $v->save();
        }
        else
            echo "republicas bananas";*/
        $app = new \Slim\Slim;
        $datas = $app->request();
        Authentification::createUser($datas->post("Prenom"),$datas->post("Passe1"),$datas->post("Passe2"),$datas->post("Mail"));

    }

    public function getConnexion() {
    	$v = new VueConnexion();
        $v->render();
    }
}