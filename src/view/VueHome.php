<?php

namespace wishlist\view;

class VueHome
{
    public function render()
    {


        $html = <<<END
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex,nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./img/favicon.ico" type="image/x-icon"><link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="/myWishList/style/style.css">
    <title>My Wish List</title>
</head>

<div id="navBarre"> 
    <div>Bonjour, bienvenue dans MyWishList</div>
    <div style="flex:1"></div>
    <div><a href="./" >Se connecter</a></div>
    <div><a href="./" >S'inscrire</a></div>
</div>

<div>
    <a href="./liste" > La liste de toutes les listes </a>
</div>

<div>
    <a href="./item" > La liste de tout les items </a>
</div>

<br>
END;

        echo $html;
    }
}
