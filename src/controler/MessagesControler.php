<?php

namespace wishlist\controler;

use \Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\MessagesListes;

class MessagesControler
{
    /**
     * Fonction permettant d'ajouter des messages aux listes. 
     *
     * La fonction permet d'ajouter des messages aux listes grâce au numéro de la liste en question?.
     * La fonction filtre les données récupérées dans le tableau post.
     *
     * @param int $no Numéro de la liste.
     */
    public function ajoutMessage($no)
    {

        $app = new \Slim\Slim;
        $m = new MessagesListes();

        $datas = $app->request();

        $m->auteur = filter_var($datas->post("auteur"), FILTER_SANITIZE_SPECIAL_CHARS);;
        $m->message = filter_var($datas->post("message"), FILTER_SANITIZE_SPECIAL_CHARS);;
        $m->liste_id = $no;

        $m->save();
    }
}
