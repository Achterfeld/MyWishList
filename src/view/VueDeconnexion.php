<?php

namespace wishlist\view;

class VueDeconnexion
{
    public function render()
    {
        $header = VueGenerale::renderHeader();
        $html=<<<END
        $header
<body id="connexion">

    <a href="/myWishList"><img style="height:200px;width:200px" src="img/logo.png"></a>


        <div>

        <p>Vous êtes bien déconnecté</p>
        <br>
        <br>
        <a href="/myWishList" class="boutton">Retour à l'accueil</a>

        </div>
<body>
END;

echo $html;

    }
}