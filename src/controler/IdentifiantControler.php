<?php

namespace wishlist\controler;

use \Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\User;
use wishlist\view\VueIdentifiant;


class IdentifiantControler {   

    public function insertUser() {

        $app = new \Slim\Slim;
        $datas = $app->request();
        
        $v = new User();
        
        $v->nom = $datas->post("Nom");
    	$v->prenom = $datas->post("Prenom");
    	$v->dateNaiss = $datas->post("DNaiss");
    	$v->mail = $datas->post("Mail");

		$salt = substr(base64_encode(random_bytes(64)),0,10);
        $salt = strtr($salt, '+/', '-_');
        
        $v->salt = $salt;
    	$hash1 = md5($datas->post("Passe1").$salt);
    	$hash2 = md5($datas->post("Passe2").$salt);
        
        if ($hash1 == $hash2) {
        	$v->hash = $hash1;
        }

        $v->save();
    }
}