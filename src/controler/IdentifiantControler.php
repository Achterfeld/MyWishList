<?php

namespace wishlist\controler;

use \Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\User;
use wishlist\view\VueIdentifiant;
use wishlist\view\VueConnexion;
use wishlist\view\VueDeconnexion;
use wishlist\authentification\Authentification;
use wishlist\view\VueHome;

class IdentifiantControler
{

    public function pageDeconnexion()
    {

        Authentification::disconnect();
        $v = new VueDeconnexion();
        $v->render();
    }

    public function insertUser()
    {

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

        $prenom = $datas->post("Prenom");
        $p1 = $datas->post("Passe1");
        $p2 = $datas->post("Passe2");
        $mail = $datas->post("Mail");
        $creationOK = Authentification::createUser($prenom, $p1, $p2, $mail);
        if ($creationOK == Authentification::Insertion_OK) {
            $this->getConnexion();
        } else {
            $c = new HomeControler();
            switch ($creationOK) {
                case Authentification::Pb_MDP :
                    $c->getHome(VueHome::PB_MDP);
                    break;

                case Authentification::Pb_Mail:
                    $c->getHome(VueHome::PB_MAIL);
                    break;
            }
        }
    }

    public function getConnexion()
    {
        $v = new VueConnexion();
        $v->render();
    }
}
