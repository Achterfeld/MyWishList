<?php

namespace wishlist\view;

class VueHome
{

    const PB_MAIL = 1;
    const PB_MDP = 2;
    public function render($option = "")
    {

        $txt = "";
        if ($option == self::PB_MAIL) {
            $txt = "<br><p class='error'>L'email est déjà connu</p><br>";
        }
        if ($option == self::PB_MDP) {
            $txt = "<br><p class='error'>Le mot de passe de confirmation n'est pas bon</p><br>";
        }


        if (isset($_SESSION['session'])) {
            $co = '<a class="boutton small" href="/myWishList/pagePerso">' . $_SESSION['session']['prenom'] . '</a>
            <a  class="boutton small disconnect" href="/myWishList/deconnexion">Se déconnecter</a>';
        } else {
            $co = '<a class="boutton small" href="/myWishList/connexion">Se connecter</a>';
        }




        $header = VueGenerale::renderHeader();
        $html = <<<END
        $header
<body id="accueil">
        <div id="topBarre">

$co 
    
        </div>


    <img style="height:200px;width:200px" src="img/logo.png">


    <div class="deuxColonnes">
        <div>
            <form method="post" action="/myWishList/inscription">
                <h1>S'inscrire</h1>

                $txt

                <input type="text" placeholder="Prenom" name="Prenom" required ><br>
                <input type="email" placeholder="Mail" name="Mail" required ><br>
                <input type="password" placeholder="Mot de passe" name="Passe1" required ><br>
                <input type="password" placeholder="Confirmation mot de passe" name="Passe2" required ><br>
                <input class="boutton" type="submit" value="S'inscrire" required ></input>
                <br>
                <a href="/myWishList/connexion">Déjà inscrit ?</a>
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
