<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;
use wishlist\modele\Liste;
use wishlist\modele\Item;


$db = new DB();
$db->addConnection(parse_ini_file("src/conf/conf.ini"));

$db->setAsGlobal();
$db->bootEloquent();

$args = $_GET;
if (isset($args['val'])){
    $it = Item::where('id','=',$args['val'])->get();
    echo $it;
}


//echo $args['val'];



echo "<br><br>";

$listes = Liste::get();

foreach ($listes as $liste) {
    echo $liste . "<br>";
}
echo "<br>";
echo "<br>";

$items = Item::get();

foreach ($items as $item) {
    echo $item . "<br>";
}
