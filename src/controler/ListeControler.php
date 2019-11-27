<?php

require_once __DIR__ . '/vendor/autoload.php';

use \Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\Liste;
use wishlist\model\Item;


class CompteControler
{
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
}
