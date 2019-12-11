<?php

namespace wishlist\view;

class VueParticipant
{

    const ALL_ITEM_VIEW = 1;
    const ALL_LIST_VIEW = 2;
    const ITEM_VIEW = 3;
    const LIST_VIEW = 4;
    const LIST_VIEW_TOKEN = 5;

    private $liste;

    function __construct($l)
    {
        $this->liste = $l;
    }

    private function afficheListeListe()
    {
        $affiche = "<section>";
        foreach ($this->liste as $UneListe) {
            $affiche .= $UneListe . "<br>";
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

    private function afficheListe($token = false)
    {

        if (!is_null($this->liste)) {

            $affiche = "<section>$this->liste";

            if ($token) {
//TODO
//                var_dump($_POST);
                $affiche .= "<div id='token' > Token à conserver :<br><br>" . $this->liste->token . "</div>";
            }

            $affiche .= "</section>";
        }else{
            $affiche='<section>Aucune liste correspondante
            <br>
            <a class="fBlanc" href="/myWishList">Retour à l\'accueil</a></section>';
        }
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
            case VueParticipant::LIST_VIEW_TOKEN:
                $content = $this->afficheListe(true);
                break;
        }

        VueGenerale::renderPage($content);
    }
}
