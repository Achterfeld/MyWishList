<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;
use wishlist\authentification\Authentification;
use wishlist\model\Liste;
use wishlist\model\Item;
use wishlist\controler\ListeControler;
use wishlist\controler\ItemControler;
use wishlist\controler\HomeControler;
use wishlist\controler\IdentifiantControler;
use wishlist\controler\notFoundControler;
use wishlist\controler\pagePersoControler;
use wishlist\controler\MessagesControler;
use wishlist\view\VueGenerale;
use wishlist\view\VueConfirmation;
use wishlist\view\VuePagePerso;

$db = new DB();
$db->addConnection(parse_ini_file("src/conf/conf.ini"));

$db->setAsGlobal();
$db->bootEloquent();

$app = new \Slim\Slim;

session_start();

//Affichage de toutes les listes

$app->get('/liste', function () {

    $c = new ListeControler();
    $c->getAllListe();
})->name('route_listePublique');

$app->get('/pagePerso', function () {

    $c = new pagePersoControler();
    $c->getPPerso();
})->name('route_get_pagePerso');

//Supprimer son compte
$app->get('/pagePerso/presuppression', function () {

    $c = new pagePersoControler();
    $c->confirmerSuppr();

})->name('route_pagePersoPresuppression');

//Confirmation de suppression
$app->post('/pagePerso/confirmation', function () {

    $c = new pagePersoControler();
    $c->supprimerCompte();
})->name('route_pagePersoSupprimer');

//Formulaire pour modifier le profile
$app->get('/pagePerso/modification', function () {

    $v = new VuePagePerso();
    $v->modification();
})->name('route_pagePersoModifier');

//Page pour traiter le formulaire de modif
$app->post('/pagePerso/validationModif', function () {

    $c = new pagePersoControler();
    $c->modifProfile();
})->name('route_pagePersoConfirmerModifier');

$app->post('/pagePerso', function () {
    $c = new pagePersoControler();
    $c->connexion();
})->name('route_post_pagePerso');

//Pour les invités
$app->get('/liste/creer', function () {
    $c = new ListeControler();
    $c->getCreation();
})->name('route_listeCreer');

$app->post('/ajout/message/:no/:token_visu', function ($no, $token_visu) use ($app) {
    $c = new MessagesControler();
    $c->ajoutMessage($no);

    $urlDetailListe = $app->urlFor('route_liste', ['no' => $no, 'token_visu' => $token_visu]);

    $app->response->redirect($urlDetailListe, 303);
})->name('route_ajoutMessage');

$app->get('/item/ajout/:no/:token', function ($no, $token) {
    $c = new ItemControler();
    $c->getCreation($no, $token);
})->name('route_itemAjout');

$app->get('/ajoutParToken', function () {
    $c = new ListeControler();
    $c->getAjout();
})->name('route_listeAjoutParToken');

$app->post('/ajoutParToken/validation', function () {
    $c = new ListeControler();
    $c->getAjoutParToken();
})->name('route_listeAjoutParTokenValidation');

$app->post('/validation/item', function () {
    $c = new ItemControler();
    $c->validerItem();
})->name('route_post_validationItem');

$app->get('/validation/item', function () {

    //TODO
    echo ("Voir les listes");
})->name('route_get_validationItem');

$app->post('/liste/validation/:token', function ($token) {

    $c = new ListeControler();
    $c->insertListe($token);
    $c->getResumeListe($token);
})->name('route_post_listeValidation');

$app->get('/liste/validation/:token', function ($token) {

    $c = new ListeControler();
    $c->getResumeListe($token);
})->name('route_get_listeValidation');

//Affichage de tous les items

$app->get('/item', function () {
    $c = new ListeControler();
    $c->getAllItem();
})->name('route_item');

//Affichage d'une liste via son token + id

$app->get('/liste/:no/:token/valider', function ($no, $token) use ($app) {

    $c = new ListeControler();
    $c->confirmerListe($no, $token);

    $urlPagePerso = $app->urlFor('route_get_pagePerso');

    $app->response->redirect($urlPagePerso, 303);
})->name('route_listeValider');

$app->get('/liste/:no/:token_visu', function ($no, $token_visu) {

    $c = new ListeControler();
    $c->getListe($no, $token_visu);
})->name('route_liste');
//->setName('afficheListe')

//Affichage d'un item (via son no) 
$app->get('/item/reservation/:idItem', function ($idItem) {
    $c = new ListeControler();
    $c->getItemListe($idItem);
})->name('route_get_itemReservation');

//Affichage d'un item via son id

$app->get('/item/:id', function ($id) {

    $c = new ListeControler();
    $c->getItem($id);
})->name('route_itemID');

$app->get('/', function () {
    $c = new HomeControler();
    $c->getHome();
})->name('route_home');

$app->post('/inscription', function () {
    $c = new IdentifiantControler();
    $c->insertUser();
})->name('route_inscription');

$app->get('/connexion', function () {
    $c = new IdentifiantControler();
    $c->getConnexion();
})->name('route_connexion');

$app->get('/deconnexion', function () {
    $c = new IdentifiantControler();
    $c->pageDeconnexion();
})->name('route_deconnexion');

$app->get('/modification/liste/:no/:token', function ($no, $token) {
    $c = new ListeControler();
    $c->modifierListe($no, $token);
})->name('route_get_modifListe');

$app->get('/modification/item/:id', function ($id) {
    $c = new ItemControler();
    $c->modifierItem($id);
})->name('route_modifItem');

$app->post('/modification/liste/:no/:token', function ($no, $token) {
    $c = new ListeControler();
    $c->validerListe($no, $token);
    $c->getResumeListe($token);
})->name('route_post_modifListe');

$app->post('/modification/item/:id', function ($id) {
    $c = new ItemControler();
    $c->validationModifierItem($id);
    $c->getItem($id);
})->name('route_post_modifItem');

$app->post('/liste/suppression/:no/:token', function ($no, $token) {
    $c = new ListeControler();
    $c->supprimer($no, $token);
})->name('route_suppressionListe');

$app->post('/item/suppression/:id', function ($id) {
    $c = new ItemControler();
    $c->supprimer($id);
})->name('route_suppressionItem');

$app->post('/liste/preSuppression/:no/:token', function ($no, $token) {
    $c = new ListeControler();
    $c->confirmerSupprListe($no, $token);
})->name('route_presuppressionListe');

$app->post('/item/preSuppression/:id', function ($id) {
    $c = new ItemControler();
    $c->confirmerSupprItem($id);
})->name('route_presuppressionItem');

$app->post('/reservation/:id', function ($id) {
    $c = new ListeControler();
    $c->addRes($id);
    $c->getAllListe();
})->name('route_post_itemReservation');

$app->notFound(function () use ($app) {
    $c = new notFoundControler();
    $c->get404();
});

$app->run();
