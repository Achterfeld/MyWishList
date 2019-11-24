<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;
use wishlist\modele\Liste;
use wishlist\modele\Item;


$str = '<head>
<meta charset="utf-8">
<meta name="robots" content="noindex,nofollow">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="./img/favicon.ico" type="image/x-icon"><link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="./style/style.css">
<title>My Wish List</title>
</head>';
echo $str;


$db = new DB();
$db->addConnection(parse_ini_file("src/conf/conf.ini"));

$db->setAsGlobal();
$db->bootEloquent();

$maxNo = Liste::max("no");

echo('
<form action="test.php" method="get">
Liste à afficher : <input type="number" min="1" max="'.$maxNo.'" name="liste"><br>
<input type="submit" value="Choisir sa liste"></input>
</form>
');


// Fonction de création d'un nouvel objet

/*
$i = new Item();
$i->nom = "test";
$i->liste_id = -1;
$i->save();

$i->liste_id = 1;
$i->save();
*/

$args = $_GET;

if (isset($args['liste'])) {
    $listeDesc = Liste::where('no', '=', $args['liste'])->get()->first();
    if (!is_null($listeDesc)) {
        echo "<h1>Description de la liste " . $args['liste'] . " :</h1><br> " . $listeDesc;
    }
}


if (isset($args['id'])) {
    $it = Item::where('id', '=', $args['id'])->get()->first();
    echo "<h1>L'item d'id " . $args['id'] . " est le suivant : </h1><br> " . $it;
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
