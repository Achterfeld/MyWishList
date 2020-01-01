<?php

namespace wishlist\view;

class VueConfirmation
{

    public function render()
    {
        $html = <<<END
        <head>
        <meta charset="utf-8">
        <meta name="robots" content="noindex,nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="./img/favicon.ico" type="image/x-icon"><link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="/myWishList//style/style.css">
        <title>My Wish List</title>
        </head>
<body id="connexion">

    <a href="/myWishList/"><img style="height:200px;width:200px" src="/myWishList//img/logo.png"></a>


        <div>

        <p>Voulez-vous vraiment supprimer votre compte définitivement ?</p>
        <br>
        <br>

        <a href="/myWishList/pagePerso/supprimer" class="boutton">Suprimer le compte</a>
        <a href="/myWishList/" class="boutton">Non</a>

        </div>
<body>
END;
        echo $html;

    }
}
