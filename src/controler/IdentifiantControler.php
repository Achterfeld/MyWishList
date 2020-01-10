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
    /**
     * Cette fonction permet de rendre la page de déconnexion.
     */
    public function pageDeconnexion()
    {

        Authentification::disconnect();
        $v = new VueDeconnexion();
        $v->render();
    }

    /**
     * Cette fonction permet d'insérer un user dans la base de données.
     * 
     * Récupère dans le tableau post le prénom, le mot de passe 1, le mot de passe 2, et le mail. Une fois les données récupérées il utilise la fonction createUser de Anthentification. Si tout se passe bien la page de connexion est affichée, dans le cas contraire une erreur est affichée.
     * 
     *
     */
    public function insertUser()
    {
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
                case Authentification::Pb_MDP:
                    $c->getHome(VueHome::PB_MDP);
                    break;

                case Authentification::Pb_Mail:
                    $c->getHome(VueHome::PB_MAIL);
                    break;
            }
        }
    }

    /**
     * Fonction permettant de rendre la vue de connexion.
     */
    public function getConnexion()
    {
        $v = new VueConnexion();
        $v->render();
    }
}
