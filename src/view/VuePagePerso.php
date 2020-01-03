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

            $urlDetailListe = $app->urlFor('route_liste', ['no' => $value->no, 'token_visu' => $value->token_visu]);
            $urlValiderListe = $app->urlFor('route_listeValider', ['no' => $value->no, 'token' => $value->token]);
            $urlModifListe = $app->urlFor('route_get_modifListe', ['no' => $value->no, 'token' => $value->token]);
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



        $urlHome = $app->urlFor('route_home');
        $urlPPersoModif = $app->urlFor('route_pagePersoModifier');
        $urlPPersoSupprimer = $app->urlFor('route_pagePersoPresuppression');

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
                    <h1>$u->prenom <a href="$urlPPersoModif"> 🖉</a></h1>
                </li>
                <li>Mail : <span>$u->mail<a href="$urlPPersoModif"> 🖉</a></span></li>
                <li>Nombre de listes : <span>$nbListes<a href="$urlPPersoModif"></a></span></li>
                <li>Mot de passe : <span>******* <a href="$urlPPersoModif"> 🖉</a></span></li>
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
    <a href="$urlPPersoSupprimer" class="boutton redBG">Supprimer le compte</a>

    </section>
</body>

END;

        // OK validé pour echo
        echo $html;
    }

    public function compteSupprimer()
    {
        $header = VueGenerale::renderHeader();

        $app = \Slim\Slim::getInstance();

        $urlHome = $app->urlFor('route_home');

        $html = <<<END
        $header
<body id="connexion">

    <a href="$urlHome"><img style="height:200px;width:200px" src="$urlHome/img/logo.png"></a>


        <div>

        <p>Votre compte a été supprimé.</p>
        <br>
        <br>
        <a href="$urlHome" class="boutton">Retour à l'accueil</a>

        </div>
<body>
END;
        //OK validé  pour echo
        echo $html;
    }

    public function modification()
    {


        if (isset($_SESSION['session']['user_id'])) {

            $app = \Slim\Slim::getInstance();
            $urlPPersoConfirmerModif = $app->urlFor('route_pagePersoConfirmerModifier');

            $prenom = $_SESSION['session']['prenom'];

            $html = <<<END

    <body>
        <form class="formulaire" method="post" action="$urlPPersoConfirmerModif">
                <h1>Modifier ses informations :</h1><h3> Laissez la valeur par défaut pour conserver la valeur actuelle</h3>

                <input type="text" placeholder="Prenom" name="Prenom" value='$prenom' ><br>
                <input type="password" placeholder="Mot de passe" name="Passe1" ><br>
                <input type="password" placeholder="Confirmation mot de passe" name="Passe2" ><br>
                <input class="boutton" type="submit" value="Valider" required ></input>
        </form>
    </body>
END;
        }


        VueGenerale::renderPage($html);
    }

    const RECONNEXION = 1;
    const PAGE_PERSO = 2;


    public function confirmation($txt = self::PAGE_PERSO)
    {

        $app = \Slim\Slim::getInstance();

        $urlHome = $app->urlFor('route_home');

        switch ($txt) {
            case self::RECONNEXION:
                $url = $app->urlFor('route_connexion');
                $info = "Se reconnecter";
                break;

            case self::PAGE_PERSO:
                $url = $app->urlFor('route_get_pagePerso');
                $info = "Retour vers la page personnelle";
                break;
        }

        $html = <<<END

    <a href="$urlHome"><img style="height:200px;width:200px" src="$urlHome/img/logo.png"></a>


        <div>
            <p>Votre compte a été modifié.</p>
            <br>
            <br>
            <a href="$url" class="boutton">$info</a>

        </div>
<body>
END;

        VueGenerale::renderPage($html, VueGenerale::DarkPage);
    }
}
