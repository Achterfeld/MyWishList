<?php

namespace wishlist\view;

class VueParticipant
{

    const ALL_ITEM_VIEW = 1;
    const ALL_LIST_VIEW = 2;
    const ITEM_VIEW = 3;
    const LIST_VIEW = 4;

    private $liste;

    function __construct($l)
    {
        $this->liste = $l;
    }

    private function afficheListeListe()
    {
        $affiche = "<section>";
        foreach ($this->liste as $UneListe) {
            $affiche .= $UneListe."<br>";
        }
        $affiche .= "</section>";

        return $affiche;
    }

    private function afficheListeItem()
    {
        $affiche = "<section>";
        foreach ($this->liste as $UneListe) {
            $affiche .= "$UneListe<br>";
        }
        $affiche .= "</section>";

        return $affiche;
    }

    private function afficheListe()
    {
        $affiche = "<section>$this->liste</section>";

        return $affiche;
    }

    private function afficheItem()
    {
        return "<section>$this->liste</section>";
    }

    public function render($selecter)
    {

        switch ($selecter) {

            case VueParticipant::ALL_LIST_VIEW:
                $content = $this->afficheListeListe();
                break;
            case VueParticipant::ITEM_VIEW:
                $content = $this->afficheItem();
                break;
            case VueParticipant::LIST_VIEW:
                $content = $this->afficheListe();
                break;
            case VueParticipant::ALL_ITEM_VIEW:
                $content = $this->afficheListeItem();
                break;
        }

        $html = <<<END
    <head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex,nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./img/favicon.ico" type="image/x-icon"><link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="/MyWishList/style/style.css">
    <title>My Wish List</title>
    </head>

    <div id="navBarre"> 
    <div>Bonjour, bienvenue dans MyWishList</div>
    <div style="flex:1"></div>
    <div><a href="./" >Se connecter</a></div>
    <div><a href="./" >S'inscrire</a></div>
    </div><br>

    $content

END;

        echo $html;
    }
}
