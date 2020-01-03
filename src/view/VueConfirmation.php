<?php

namespace wishlist\view;

class VueConfirmation
{

    public function render()
    {

        $header = VueGenerale::renderHeader();

        $app = \Slim\Slim::getInstance();
        $urlHome = $app->urlFor('route_home');
        $urlPPerso = $app->urlFor('route_post_pagePerso');

        $urlSuppression = $app->urlFor('route_pagePersoSupprimer');

        $html = <<<END
        $header
<body id="connexion">

    <a href="$urlHome"><img style="height:200px;width:200px" src="$urlHome/img/logo.png"></a>


        <div>
        
        <form action="$urlSuppression" method="post" class="formulaire ">

        <h1>Voulez-vous vraiment supprimer votre compte ?</h1>

            <input type="submit" value="Oui"  class='redBG' required>
            <a href="$urlPPerso">Retour au compte</a>

        </form>

        </div>
<body>
END;
        echo $html;
    }
}
