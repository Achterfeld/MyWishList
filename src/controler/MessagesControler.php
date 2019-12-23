<?php

namespace wishlist\controler;

use \Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\MessagesListes;

class MessagesControler
{

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
