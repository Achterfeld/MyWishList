<?php

namespace wishlist\view;

class VueDeconnexion
{
    public function render()
    {
        $header = VueGenerale::renderHeader();

        $app = \Slim\Slim::getInstance();
        $urlHome = $app->urlFor('route_home');

        $html = <<<END
    $header
    <body id="connexion">

        <a href="$urlHome"><img style="height:200px;width:200px" src="$urlHome/img/logo.png"></a>


            <div>

                <p>Vous êtes bien déconnecté</p>
                <br>
                <br>
                <a href="$urlHome" class="boutton">Retour à l'accueil</a>

            </div>
    <body>
END;

        echo $html;
    }
}
