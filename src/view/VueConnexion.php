<?php

namespace wishlist\view;

class VueConnexion
{
    public function render()
    {
        $header = VueGenerale::renderHeader();
        $html=<<<END
        $header
<body id="connexion">

    <a href="/myWishList"><img style="height:200px;width:200px" src="img/logo.png"></a>


        <div>
            <form method="post" action="/myWishList/inscription">
                <h1>Se connecter</h1>
                <input type="email" placeholder="Mail" name="Mail" required ><br>
                <input type="password" placeholder="Mot de passe" name="Passe" required ><br>
            </form>

        </div>
        <br>
        <a href="/myWishList/liste" class="boutton">Se connecter</a>
        <br>
        <br>
        <br>
        <br>
        <div>
            <h1>Pas besoin de compte ?</h1>
            <br>
            <br>
            <a href="/myWishList/liste/creer" class="boutton">Mode invité</a>
        </div>

        
<br>


<div>
<br>
<br>
<br>

<a href="/myWishList class="boutton">Retour à l'accueil</a>
<br>
</div>
<body>
END;

echo $html;

    }
}