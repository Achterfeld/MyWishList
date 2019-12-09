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
    $c->getAllListe();

});

$app->get('/liste/creer', function () {
    
    $c = new ListeControler();
    $c->getCreation();

});

$app->post('/liste/validation/:token', function ($token) {
    
    $c = new ListeControler();
    $c->insertListe();
    $c->getResumeListe($token);

});


$app->get('/liste/validation/:token', function ($token) {
    
    $c = new ListeControler();
    $c->getResumeListe($token);

});

//Affichage de tous les items

$app->get('/item', function () {


    $c = new ListeControler();
    $c->getAllItem();

});

//Affichage d'une liste via son no

$app->get('/liste/:id', function ($id) {

    $c = new ListeControler();
    $c->getListe($id);

});


//Affichage d'un item (via son no) dans une liste (via son no)
$app->get('/list/:id/idItem', function ($id) {
    $c = new ListeControler();
    $c->getItemListe($id, $idItem);
});

//Affichage d'un item via son id

$app->get('/item/:id', function ($id) {
    
    $c = new ListeControler();
    $c->getItem($id);

});

$app->get('/', function () {
    $c = new HomeControler();
    $c->getHome();
});

$app->post('/inscription', function () {

	$c = new IdentifiantControler();
	$c->insertUser();

});
$app->run();