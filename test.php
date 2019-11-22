<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;
use wishlist\modele\Liste;
use wishlist\modele\Item;


$db = new DB();
$db->addConnection(parse_ini_file("src/conf/conf.ini"));

$db->setAsGlobal();
$db->bootEloquent();

/*$idNvObjet=100;
$testAjout = Item::where('id','=',$idNvObjet)->get()->first();

if (is_null($testAjout)){
    echo "Création de l'objet d'id $idNvObjet";
*/

/*
$i = new Item();
$i->nom = "test";
$i->liste_id = -1;
$i->save();

$i->liste_id = 1;
$i->save();
*/


/*
}else{
    echo $testAjout;
}*/



$args = $_GET;

if (isset($args['liste'])) {
    $listeDesc = Liste::where('no', '=', $args['liste'])->get()->first();
    if (!is_null($listeDesc)){
        echo "<h1>Description de la liste ".$args['liste']." :</h1><br> ".$listeDesc;
    }
}


if (isset($args['id'])) {
    $it = Item::where('id', '=', $args['id'])->get()->first();
    echo "<h1>L'item d'id ".$args['id']." est le suivant : </h1><br> ".$it;
}


//echo $args['val'];



echo "<br><br>";
echo "<h1>Liste des listes créées :</h1> <br> ";

$listes = Liste::get();

foreach ($listes as $liste) {
    echo $liste . "<br><br>";
}
echo "<br>";
echo "<br>";
echo "<h1>Liste des items créés :</h1> <br> ";

$items = Item::get();

foreach ($items as $item) {
    echo $item . "<br><br>";
}
