<?php

namespace wishlist\view;

use wishList\model\User;

class VuePagePerso
{

    public function render($u, $message = "")
    {

        $app = \Slim\Slim::getInstance();
        $urlHome = $app->urlFor('route_home');
        $urlListeCreer = $app->urlFor('route_listeCreer');

        $header = VueGenerale::renderHeader();


        $listes = $u->listes()->get();

        $listesTxt = "";


        foreach ($listes as $key => $value) {

            //            echo ($key);
            $items = $value->item()->get();

            $compteur = count($items);
            $reserve = 0;

            foreach ($items as $key1 => $value1) {

                //                $compteur++;

                // var_dump($value->reservation);

                // var_dump($value->reservation);
                // echo($value);

                if (!is_null($value1->reservation)) {
                    $reserve++;
                }
            }
            
        $urlDetailListe = $app->urlFor('route_liste',['no'=>$value->no,'token_visu'=>$value->token_visu]);
        $urlValiderListe = $app->urlFor('route_listeValider',['no'=>$value->no,'token'=>$value->token]);
        $urlModifListe = $app->urlFor('route_get_modifListe',['no'=>$value->no,'token'=>$value->token]);
        $urlHome = $app->urlFor('route_home');
        $urlListeCreer = $app->urlFor('route_listeCreer');

            if ($value->token_visu != "") {
                $visuListe = "<a  href='$urlDetailListe'>Liste 🔗</a>";
            } else {
                $visuListe = "<a  href='$urlValiderListe'>Valider la liste ✅</a>";
            }



            $listesTxt .= " <div class='info'>
                                <span >Liste n°$value->no</span>
                                <a  href='$urlModifListe'>Modification 🖉</a>
             
                                $visuListe
             
                                <label>Item(s) réservé(s) ($reserve / $compteur)<br><progress  name='prog' max='$compteur' value='$reserve'></progress></label>
                                
                             </div>";
        }

        $navBarre = VueGenerale::renderNavBarre();
        //TODO
        //Permettre les modifs de nom d'utilisateur, de mail, de mdp

        if ($message != "") {
            $message =
                "<section id='message'>$message</section>";
        }

        $nbListes = count($listes);
        $html = <<<END

        $header
<body id="accueil">
$navBarre

<section id="mainContent">

$message
<div class="section" id="infoCompte">
        <img id="profilPic" src="$urlHome/img/profil.png">
        <div id="infos">
            <ul>
                <li>
                    <h1>$u->prenom <a href="./"> 🖉</a></h1>
                </li>
                <li>Mail : <span>$u->mail<a href="./"> 🖉</a></span></li>
                <li>Nombre de listes : <span>$nbListes<a href="./"></a></span></li>
                <li>Mot de passe : <span>******* <a href="./"> 🖉</a></span></li>
            </ul>
        </div>
    </div>
    <br>
    <br>
    <div class="section" id="infoListe">

        <h1>Propriétaire des listes :</h1>
            $listesTxt

    </div>
    <br>
    <br>
    <a href="$urlListeCreer" class="boutton">Créer une liste</a>
    <a href="/myWishList/pagePerso/supprimer" class="boutton">Suprimer le compte</a>

    </section>
</body>

END;

        echo $html;
    }

    public function compteSupprimer() {
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

        <p>Votre compte a été supprimé.</p>
        <br>
        <br>
        <a href="/myWishList/" class="boutton">Retour à l'accueil</a>

        </div>
<body>
END;
        echo $html;
    }
}
