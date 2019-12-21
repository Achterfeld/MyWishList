<?php

namespace wishlist\controler;

use \Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\Liste;
use wishlist\model\Item;
use wishlist\model\User;
use wishlist\view\VuePagePerso;
use wishlist\authentification\Authentification;


class pagePersoControler {   

    public function getPPerso() {
        $v = new VuePagePerso();

        //TODO
        //Utiliser le user_id retenu dans la session
        if (isset($_SESSION['session'])) {
			$u = User::where('user_id','=',$_SESSION['session']['user_id'])->first();
            $v = new vuePagePerso();
            $v->render($u);
        }
    }

    public function connexion() {
    	try {
    		$app = new \Slim\Slim;
        	$datas = $app->request();
        	Authentification::authenticate($datas->post("Mail"),$datas->post("Passe"));
        	$u = User::where('mail','=',$datas->post("Mail"))->first();
        	Authentification::loadProfile($u->user_id);
        	$this->getPPerso();
    	} catch(AuthException $ae) {

    		echo "Email ou mot de passe invalide<br>";
    	}
    }
}