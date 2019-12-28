<?php

namespace wishlist\view;

use wishlist\model\Liste;

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

        date_default_timezone_set('Europe/Paris');
        $date = date('m/d/Y h:i:s a', time());

        if (isset($_SESSION['session'])) {

            foreach ($this->liste as $UneListe) {
                if (strtotime($UneListe->expiration) > strtotime($date)) {
                    $affiche .= $UneListe . "<br>";
                }
            }
        } else {

            foreach ($this->liste as $UneListe) {
                if (strtotime($UneListe->expiration) > strtotime($date)) {
                    $affiche .= <<<END
                    <div class='list'>
                    
                    <div class='num num_liste'>$UneListe->no</div>
        <h3><a href="/myWishList/liste/$UneListe->no/$UneListe->token_visu">$UneListe->titre</a></h3><br>
        <div>⌛ Expire le $UneListe->expiration</div><br><br>
                    
                    </div><br>
END;
                }
            }
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
                $token_visu = $this->liste->token_visu;
                $token = $this->liste->token;

                $modif = "";
                if ($this->liste->token_visu != "") {
                    $modif = "Lien pour modifier la liste<br><br><a href='/myWishList/modification/liste/$no/$token'>/myWishList/modification/liste/$no/$token</a>";
                }

                $affiche .= <<<END

                 <div id='token' > $modif </div>
                 <div id='token' > Token à conserver :<br><br> $token_visu </div>
                 <div id='token'>Lien pour visualiser la liste :<br><br><a href="/myWishList/liste/$no/$token_visu">/myWishList/liste/$no/$token_visu</a></div>
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


        $content = "<section>$this->liste";

        $l = Liste::where('no', '=', $this->liste->liste_id)->first();
        $uID = $l->user_id;
        //$uID=2;
        //        var_dump($uID);

        $state = !is_null($reserv) ? "disabled" : "required";
        $class = !is_null($reserv) ? "bouttonDisabled" : "boutton";
        $txt = !is_null($reserv) ? " 🔒 Cet item est déjà réservé" : "🔓 Réserver";

        $reserv = !is_null($reserv) ? $reserv : "''";

        $reserv = isset($_SESSION['session']) ? $_SESSION['session']['prenom'] : "''";




        $txtAutre = <<<END
<br>
<form method="post" action="/myWishList/reservation/$idItem">
<div>Réserver : </div>
<input type="checkbox" name="reservation" $state ><br>
<input type="text" name="message" placeholder="Votre message pour l'organisateur" $state ><br>
<input type="text" placeholder="Nom participant" name="participant" value=$reserv $state ><br>
<input class="$class" type="submit" value="$txt" $state ></input><br>
</form>
</section>
END;


        $txtProprietaire = <<<END
</section>
END;

        if (isset($_COOKIE['user_id'])) {
            if ($_COOKIE['user_id'] != $uID) {
                $content .= $txtAutre;
            } else {

                date_default_timezone_set('Europe/Paris');
                $date = date('m/d/Y h:i:s a', time());

                if (strtotime($l->expiration) - strtotime($date) < 0) {
                    $content .= $txtAutre;
                } else {
                    $content .= $txtProprietaire;
                }
            }
        } else {
            $content .= $txtAutre;
        }

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
