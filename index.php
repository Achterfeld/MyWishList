<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\Liste;
use wishlist\model\Item;
use wishlist\controler\ListeControler;
use wishlist\controler\HomeControler;

$db = new DB();
$db->addConnection(parse_ini_file("src/conf/conf.ini"));

$db->setAsGlobal();
$db->bootEloquent();

$app = new \Slim\Slim;


//Affichage de toutes les listes

$app->get('/liste', function () {
    
    $c = new ListeControler();
    $liste = $c->getAllListe();

});

//Affichage de tous les items

$app->get('/item', function () {


    $c = new ListeControler();
    $liste = $c->getAllItem();

});

//Affichage d'une liste via son no

$app->get('/liste/:id', function ($id) {

    $c = new ListeControler();
    $liste = $c->getListe($id);

});

//Affichage d'un item via son id

$app->get('/item/:id', function ($id) {
    
    $c = new ListeControler();
    $liste = $c->getItem($id);

});

$app->get('/', function () {
    $c = new HomeControler();
    $c->getHome();
});

$app->run();