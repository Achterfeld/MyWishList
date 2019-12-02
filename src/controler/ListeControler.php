<?php

require_once __DIR__ . '/vendor/autoload.php';

use \Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\Liste;
use wishlist\model\Item;


class CompteControler {   

    public function getAllItem() {
        $liste = Item::OrderBy('titre')->get();
        $v = new VueParticipant($liste);
        $v->render('ALL_ITEM_VIEW');
    }

    public function getItem($id) {
        $i = Item::where('id','=',$id)->first();
        $v = newItemView($i);
        $v->render('ITEM_VIEW');
    }

    public function getAllListe() {
        $liste = Liste::OrderBy('titre')->get();
        $v = new VueParticipant($liste);
        $v->render('ALL_LISTE_VIEW');
    }

    public function getListe($id) {
        $l = Liste::where('id','=',$id)->first();
        $v = new VueParticipant($l);
        $v = render('LISTE_VIEW');
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
    