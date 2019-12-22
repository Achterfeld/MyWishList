<?php

namespace wishlist\view;

class VueParticipant
{

    const ALL_ITEM_VIEW = 1;
    const ALL_LIST_VIEW = 2;
    const ITEM_VIEW = 3;
    const LIST_VIEW = 4;
    const LIST_VIEW_TOKEN = 5;
    const LIST_ITEM_VIEW = 6;

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

    private function afficheListeItems()
    {
        $affiche = "<section>";
        foreach ($this->liste as $UneListe) {
            $affiche .= "$UneListe<br>";
        }
        $affiche .= "</section>";

        return $affiche;
    }

    private function afficheListe($affToken = false)
    {

        if (!is_null($this->liste)) {

            $affiche = "<section>$this->liste";

            if ($affToken) {

                $no = $this->liste->no;
                $token = $this->liste->token;

                $affiche .= <<<END
                 <div id='token' > Token à conserver :<br><br> $token </div>
                 <div id='token'>Lien à copier :<br><a href="/myWishList/liste/$no/$token">/myWishList/liste/$no/$token</a></div>
END;
            }

            $affiche .= "</section>";
        } else {
            $affiche = '<section>Aucune liste correspondante
            <br>
            <a class="fBlanc" href="/myWishList">Retour à l\'accueil</a></section>';
        }
        return $affiche;
    }

    private function afficheItem()
    {
        return "<section>$this->liste</section>";
    }

    function afficheItemListe($i)
    {

        $reserv = $i->reservation;
        $idItem = $i->id;



        $state = !is_null($reserv) ? "disabled" : "required";
        $class = !is_null($reserv) ? "bouttonDisabled" : "boutton";
        $txt = !is_null($reserv) ? " 🔒 Cet item est déjà réservé" : "🔓 Réserver";

        $reserv = !is_null($reserv) ? $reserv : "''";

        if ($reserv == "''") {
            $reserv = isset($_SESSION['session']) ? $_SESSION['session']['prenom'] : "''";
        }


        $content = <<<END
        <section>$this->liste<br>
            <form method="post" action="/myWishList/reservation/$idItem">
                <div>Réserver : </div>
                <input type="checkbox" name="reservation" $state ><br>
                <input type="text" name="message" placeholder="Votre message pour l'organisateur" $state ><br>
                <input type="text" placeholder="Nom participant" name="participant" value=$reserv $state ><br>
                <input class="$class" type="submit" value="$txt" $state ></input><br>
            </form>
        </section>
END;
        VueGenerale::renderPage($content);
    }

    public function render($selecter)
    {

        switch ($selecter) {

            case VueParticipant::ALL_LIST_VIEW:
                $content = "<h1>Listes publiques</h1><br>";
                $content .= $this->afficheListeListe();
                break;
            case VueParticipant::ITEM_VIEW:
                $content = $this->afficheItem();
                break;
            case VueParticipant::LIST_VIEW:
                $content = $this->afficheListe();
                break;
            case VueParticipant::ALL_ITEM_VIEW:
                $content = $this->afficheListeItems();
                break;
            case VueParticipant::LIST_VIEW_TOKEN:
                $content = $this->afficheListe(true);
                break;/*
            case VueParticipant::LIST_ITEM_VIEW:
                $content = $this->afficheItemListe();
                break;*/
        }

        VueGenerale::renderPage($content);
    }
}
