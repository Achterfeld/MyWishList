<?php

namespace wishlist\controler;

use \Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\User;
use wishlist\view\VueIdentifiant;
use wishlist\view\VueConnexion;

class IdentifiantControler {   

    public function insertUser() {

        $app = new \Slim\Slim;
        $datas = $app->request();
        
        $v = new User();
        
    	$v->prenom = $datas->post("Prenom");
    	$v->mail = $datas->post("Mail");

		$salt = random_bytes(32);
		$salt = bin2hex($salt);
        
        $v->salt = $salt;
    	$hash1 = password_hash($datas->post("Passe1"), PASSWORD_DEFAULT, ['cost'=> 12, 'salt'=>$salt]);
    	$hash2 = password_hash($datas->post("Passe2"), PASSWORD_DEFAULT, ['cost'=> 12, 'salt'=>$salt]);
        
        if ($hash1 == $hash2) {
        	$v->hash = $hash1;
        }

        $v->save();
    }

    public function getConnexion() {
    	$v = new VueConnexion();
        $v->render();
    }
}