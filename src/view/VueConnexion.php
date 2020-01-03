<?php

namespace wishlist\view;

class VueConnexion
{
    public function render()
    {

        $app = \Slim\Slim::getInstance();
        $urlHome = $app->urlFor('route_home');
        $urlPPerso = $app->urlFor('route_post_pagePerso');
        $urlListeCreer = $app->urlFor('route_listeCreer');

        $header = VueGenerale::renderHeader();
        $html = <<<END
        $header
<body id="connexion">

    <a href="$urlHome"><img style="height:200px;width:200px" src="$urlHome/img/logo.png"></a>


        <div>
            <form method="post" action="$urlPPerso">
                <h1>Se connecter</h1>
                <input type="email" placeholder="👱 Mail" name="Mail" required autofocus><br>
                <input type="password" placeholder="🔒 Mot de passe" name="Passe" required ><br>
                <input class="boutton" type="submit" value="Se connecter" required ></input>


            </form>

        </div>
        <br>
        <br>
        <div>
            <h1>Pas besoin de compte ?</h1>
            <br>
            <br>
            <a href="$urlListeCreer" class="boutton">Mode invité</a>
        </div>


<br>


<div>
<br>
<br>
<br>

<a href="$urlHome" class="boutton">Retour à l'accueil</a>
<br>
</div>
<body>
END;

        // Page spéciale ok pour echo
        echo $html;
    }
}
