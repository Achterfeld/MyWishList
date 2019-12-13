<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\Liste;
use wishlist\model\Item;
use wishlist\controler\ListeControler;
use wishlist\controler\HomeControler;
use wishlist\controler\IdentifiantControler;
use wishlist\controler\notFoundControler;
use wishlist\view\VueGenerale;

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
    $c->insertListe($token);
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


//Affichage d'un item (via son no) 
$app->get('/item/reservation/:idItem', function ($idItem) {
    $c = new ListeControler();
    $c->getItemListe($idItem);
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
    $c->getConnexion();
});

$app->get('/inscription', function () {
	$c = new IdentifiantControler();
	$c->getConnexion();
});

$app->post('/reservation/:id', function($id) {
    $c = new ListeControler();
    $c->addRes($id);
    $c->getAllListe();
});

$app->notFound(function () use ($app) {
    //TODO 
    //Vue 404

    $c = new notFoundControler();
    $c->get404();
    
});

$app->run();