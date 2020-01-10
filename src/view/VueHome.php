<?php

namespace wishlist\view;

class VueHome
{

    const PB_MAIL = 1;
    const PB_MDP = 2;
    public function render($option = "")
    {

        $app = \Slim\Slim::getInstance();

        $txt = "";
        if ($option == self::PB_MAIL) {
            $txt = "<br><p class='error'>L'email est déjà connu</p><br>";
        }
        if ($option == self::PB_MDP) {
            $txt = "<br><p class='error'>Le mot de passe de confirmation n'est pas bon</p><br>";
        }


        if (isset($_SESSION['session'])) {
            $co = '<a class="boutton small" href="'.$app->urlFor('route_get_pagePerso').'">' . $_SESSION['session']['prenom'] . '</a>
            <a  class="boutton small disconnect" href="'.$app->urlFor('route_deconnexion').'">Se déconnecter</a>';
        } else {
            $co = '<a class="boutton small" href="'.$app->urlFor('route_connexion').'">Se connecter</a>';
        }

        $urlImg = $app->urlFor('route_home');
        $urlInscription = $app->urlFor('route_inscription');
        $urlConnexion = $app->urlFor('route_connexion');
        $urlListeCreer = $app->urlFor('route_listeCreer');
        $urlItems = $app->urlFor('route_item');
        $urlListePublique = $app->urlFor('route_listePublique');
        $urlCreateurs = $app->urlFor('route_createurs');

        $header = VueGenerale::renderHeader();
        $html = <<<END
        $header
<body id="home">
        <div id="topBarre">

$co 

        </div>


    <img style="height:200px;width:200px" src="$urlImg/img/logo.png">


    <div class="deuxColonnes">
        <div>
            <form method="post" action="$urlInscription">
                <h1>S'inscrire</h1>

                $txt

                <input type="text" placeholder="Prenom" name="Prenom" required ><br>
                <input type="email" placeholder="Mail" name="Mail" required ><br>
                <input type="password" placeholder="Mot de passe" name="Passe1" required ><br>
                <input type="password" placeholder="Confirmation mot de passe" name="Passe2" required ><br>
                <input class="boutton" type="submit" value="S'inscrire" required ></input>
                <br>
                <a href="$urlConnexion">Déjà inscrit ?</a>
            </form>

        </div>
        <div>
            <h1>Pas besoin de compte ?</h1>
            <br>
            <br>
            <a href="$urlListeCreer" class="bouttonHome">Mode invité</a>
            <br>
            <br>
            <br>
            <a href="$urlListePublique" class="bouttonHome"> Toutes nos listes publiques</a>
            <br>
            <a href="$urlItems" class="bouttonHome"> Tous nos items</a>
            <br>
            <a href="$urlCreateurs" class="bouttonHome"> Les créateurs de listes publiques</a>
        </div>
    </div>
<br>
<body>
END;

        echo $html;
    }
}
