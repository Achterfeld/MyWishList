<?php

require_once __DIR__ . '/vendor/autoload.php';

use \Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\Liste;
use wishlist\model\Item;


class ListeControler {   

    public function getItem($id) {
        $i = Item::where('id','=',$id)->first();
        $v = newItemView($i);
        $v->render(VueParticipant::ITEM);
    }

    public function getAllListe() {
        $liste = Liste::OrderBy('titre')->get();
        $v = new VueParticipant($liste);
        $v->render(VueParticipant::ALL_LIST);
    }

    public function getListe($id) {
        $l = Liste::where('id','=',$id)->first();
        $v = new VueParticipant($l);
        $v = render(VueParticipant::ALL_LIST_ITEMS);
    }
}
    /**
    static function afficherTout()
    {
        $listes = Liste::get();

        foreach ($listes as $liste) {
            echo $liste . "<br><br>";
        }
    }

    static function afficherParID($id)
    {

        $listeDesc = Liste::where('no', '=', $id)->get()->first();
        if (!is_null($listeDesc)) {
            echo "<h1>Description de la liste " . $id . " :</h1><br> " . $listeDesc;
        }
    }
    */
    