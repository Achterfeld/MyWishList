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
        <img style="height:20px;width:20px" href="">
        <a class="boutton small" href="">S'inscrire</a>
        <a class="boutton small" href="">Se connecter</a>
    </div>


    <H1 class="titre">My Wish List</H1>


    <div class="deuxColonnes">
        <div>
            <form>
                <h1>S'inscrire</h1>
                <input type="text" placeholder="Nom" name="Nom"><br>
                <input type="text" placeholder="Prenom" name="Prenom"><br>
                <input type="date" placeholder="Date de naissance" name="DNaiss"><br>
                <input type="email" placeholder="Mail" name="Mail"><br>
                <input class="boutton" type="submit" value="S'inscrire"></input>

                <a href="./">Déjà inscrit ?</a>
            </form>

        </div>
        <div>
            <h1>Pas besoin de compte ?</h1>
            <br>
            <a href="./" class="boutton">Mode invité</a>
        </div>
    </div>
        <div>
    <a href="./liste" > La liste de toutes les listes </a>
</div>

<div>
    <a href="./item" > La liste de tout les items </a>
</div>

<br>
<body>
END;

echo $html;

    }
}
