<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\Liste;
use wishlist\model\Item;


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


echo ('<div id="navBarre"> 
<div>Bonjour, bienvenue dans MyWishList</div>
<div style="flex:1"></div>
<div><a href="./" >Se connecter</a></div>
<div><a href="./" >S\'inscrire</a></div>
</div>');

$app = new \Slim\Slim;

$app->get('/liste', function () {
    echo "<h1>LISTE</h1>";

    $listes = Liste::get();

    foreach ($listes as $liste) {
        echo $liste . "<br><br>";
    }
});

$app->get('/item/:id', function ($id) {
    echo "<h1>Item n° $id</h1>";


    $it = Item::where('id', '=', $id)->get()->first();
    echo "<h1>L'item d'id " . $id . " est le suivant : </h1><br> " . $it;
});

$app->get('/liste/:id', function ($id) {
    echo "<h1>liste n° $id</h1>";



    $listeDesc = Liste::where('no', '=', $id)->get()->first();
    if (!is_null($listeDesc)) {
        echo "<h1>Description de la liste " . $id . " :</h1><br> " . $listeDesc;
    }
});

$app->get('/', function () {
    echo "<h1>index</h1>";
});

$app->run();
