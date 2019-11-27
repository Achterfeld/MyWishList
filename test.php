<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\Liste;
use wishlist\model\Item;



$app = new \Slim\Slim ;


$str = '<head>
<meta charset="utf-8">
<meta name="robots" content="noindex,nofollow">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="./img/favicon.ico" type="image/x-icon"><link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="/MyWishList/style/style.css">
<title>My Wish List</title>
</head>';
echo $str;




$db = new DB();
$db->addConnection(parse_ini_file("src/conf/conf.ini"));

$db->setAsGlobal();
$db->bootEloquent();


echo('<div id="navBarre"> 
<div>Bonjour, bienvenue dans MyWishList</div>
<div style="flex:1"></div>
<div><a href="./" >Se connecter</a></div>
<div><a href="./" >S\'inscrire</a></div>
</div>');

$app->get('/liste',function (){
    echo "<h1>LISTE</h1>";
});

$app->get('/item/:id',function ($id){
    echo "<h1>Item n° $id</h1>";
});

$app->get('/',function(){
    


$maxNo = Liste::max("no");

$maxNoItem = Item::max("id");
echo('
<div id = "formulaires">
<form action="test.php" method="get">

<h1>Affichage liste</h1>
<input type="number" placeholder="Numéro de la liste à afficher" min="1" max="' . $maxNo . '" name="liste"><br>
<input type="submit" value="Choisir sa liste"></input>

</form>


<form action="test.php" method="post">

<h1>Création liste</h1>
<input type="text" placeholder="Titre" name="titreNouvelleListe"><br>
<input type="text" placeholder="Description" name="descriptionNouvelleListe"><br>
<input type="text" placeholder="Titre" name="titreNouvelleListe"><br>
Limite de validité : <input type="date" name="dateLimiteNouvelleListe"><br>
<input type="submit" value="Ajouter une liste"></input>

</form>


<form action="test.php" method="post">

<h1>Ajout dans liste</h1>
<input type="number" placeholder="Liste dans laquelle ajouter" min="1" max="' . $maxNo . '" name="aAjouterDansListe"><br>
<input type="number" placeholder="Objet à ajouter" min="1" max="' . $maxNoItem . '" name="itemAAjouter"><br>
<input type="submit" value="Ajouter dans la liste"></input>

</form>

</div>
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

});

$app->run();