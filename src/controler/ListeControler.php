<?php

namespace wishlist\controler;

use \Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\Liste;
use wishlist\model\Item;
use wishlist\view\VueParticipant;


class ListeControler {   

    public function getItem($id) {
        $i = Item::where('id','=',$id)->first();
        $v = new VueParticipant($i);
        $v->render(VueParticipant::ITEM_VIEW);
    }

    public function getAllListe() {
        $liste = Liste::OrderBy('titre')->get();
        $v = new VueParticipant($liste);
        $v->render(VueParticipant::ALL_LIST_VIEW);
    }

    public function getAllItem() {
        $liste = Item::get();
        $v = new VueParticipant($liste);
        $v->render(VueParticipant::ALL_ITEM_VIEW);
    }

    public function getListe($no) {
        $l = Liste::where('no','=',$no)->first();
        $v = new VueParticipant($l);
        $v -> render(VueParticipant::LIST_VIEW);
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
    