<?php

namespace wishlist\controler;

use \Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\Liste;
use wishlist\model\Item;
use wishlist\model\User;
use wishlist\view\VuePagePerso;
use wishlist\authentification\Authentification;
use wishlist\exception\AuthException;


class pagePersoControler
{

	public function getPPerso()
	{

		if (isset($_SESSION['session'])) {
			$v = new VuePagePerso();

			$u = User::where('user_id', '=', $_SESSION['session']['user_id'])->first();
			$v = new vuePagePerso();
			$v->render($u);
		} else {
			$c = new IdentifiantControler();
			$c->getConnexion();
		}
	}

	public function connexion()
	{
		try {
			$app = new \Slim\Slim;
			$datas = $app->request();
			Authentification::authenticate($datas->post("Mail"), $datas->post("Passe"));
			$u = User::where('mail', '=', $datas->post("Mail"))->first();
			if (!is_null($u)) {
				Authentification::loadProfile($u->user_id);
				$this->getPPerso();
			}
		} catch (AuthException $ae) {

			echo "Email ou mot de passe invalide<br>";
		}
	}
}
