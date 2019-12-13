<?php

namespace wishlist\view;

class VueHome
{
    public function render()
    {
        $header = VueGenerale::renderHeader();
        $html=<<<END
        $header
<body id="accueil">
        <div id="topBarre">
        <a class="boutton small" href="/myWishList/inscription">Se connecter</a>
    </div>


    <img style="height:200px;width:200px" src="img/logo.png">


    <div class="deuxColonnes">
        <div>
            <form method="post" action="/myWishList/inscription">
                <h1>S'inscrire</h1>
                <input type="text" placeholder="Prenom" name="Prenom" required ><br>
                <input type="email" placeholder="Mail" name="Mail" required ><br>
                <input type="password" placeholder="Mot de passe" name="Passe1" required ><br>
                <input type="password" placeholder="Confirmation mot de passe" name="Passe2" required ><br>
                <input class="boutton" type="submit" value="S'inscrire" required ></input>
                <br>
                <a href="/myWishList/inscription">Déjà inscrit ?</a>
            </form>

        </div>
        <div>
            <h1>Pas besoin de compte ?</h1>
            <br>
            <br>
            <a href="/myWishList/liste/creer" class="boutton">Mode invité</a>
        </div>
    </div>
        <div>
    <a href="./liste" > Toutes nos listes </a> 
</div>

<div>
    <a href="./item" > Tous nos items </a>
</div>

<br>
<body>
END;

echo $html;

    }
}