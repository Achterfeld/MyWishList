<?php

namespace wishlist\view;

class VueModification
{
    const LIST = 1;
    const ITEM = 2;


    

    function afficheModificationListe($modif)
    {
        $no = $modif->no;
        $token = $modif->token ;
        $titre = $modif->titre;
        $desc = $modif->description;
        $exp = $modif->expiration;
        

        $html = <<<END
        <form action="$token" method="post">

            <h1>Modification liste</h1>
            <input type="text" value="$titre" placeholder="Titre" name="titreNouvelleListe"><br>
            <input type="text" value="$desc" placeholder="Description" name="descriptionNouvelleListe"><br>
            Limite de validité : <input type="date" value="$exp" name="dateLimiteNouvelleListe"><br>
            <input type="submit" value="Modifier la liste"></input>

        </form>

END;
        return $html;
    }

    function afficheModificationItem($modif)
    {

        $html = <<<END
        <form action="./" method="post">

            <h1>Création liste</h1>
            <input type="text" placeholder="Titre" name="titreNouvelleListe"><br>
            <input type="text" placeholder="Description" name="descriptionNouvelleListe"><br>
            <input type="text" placeholder="Titre" name="titreNouvelleListe"><br> Limite de validité : <input type="date" name="dateLimiteNouvelleListe"><br>
            <input type="submit" value="Ajouter une liste"></input>

        </form>

END;
        return $html;
    }



    function render($selecter,$modif)
    {
        switch ($selecter) {

            case self::LIST:
                $content = $this->afficheModificationListe($modif);
                break;
            case self::ITEM:
                $content = $this->afficheModificationItem($modif);
                break;
        }

        VueGenerale::renderPage($content);
    }
}
