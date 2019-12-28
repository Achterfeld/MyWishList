<?php

namespace wishlist\view;

class VueModification
{
    const LIST = 1;
    const ITEM = 2;

    function afficheModificationListe($modif)
    {
        $no = $modif->no;
        $token = $modif->token;
        $titre = $modif->titre;
        $desc = $modif->description;
        $exp = $modif->expiration;

        $visibilite = $this->genererVisibilite($modif);

        $html = <<<END
        <form action="$token" method="post" class="formulaire">

            <h1>Modification liste</h1>
            <input type="text" value="$titre" placeholder="Titre" name="titreNouvelleListe"><br>
            <input type="text" value="$desc" placeholder="Description" name="descriptionNouvelleListe"><br>
            Limite de validité : <input type="date" value="$exp" name="dateLimiteNouvelleListe"><br>
            
            $visibilite

            <input type="submit" value="Modifier la liste"></input>

        </form>

        <br>

        <form class='formulaire'>
            <a href="/myWishList/item/ajout/$no/$token"> <h1>+</h1>Ajouter un item dans la liste</a>
        </form>

        <br>

        <form class='formulaire redBG' action="/myWishList/liste/preSuppression/$no/$token" method="post">
            <input type="submit" value="❌Supprimer la liste">
        </form>


END;
        return $html;
    }

    function genererVisibilite($liste)
    {

        $public = $liste->public ? "" : "checked";
        $prive = $liste->public ? "checked" : "";

        $txt = <<<END
        <label>Visibilité de la liste :</label>

        <div>
            <input type="radio" value="0" name="visib" $public>
            <label for="privé">Privée</label>
        </div>
        <div>
            <input type="radio" value="1" name="visib" $prive>
            <label for="public">Publique</label>
        </div>
END;

        //TODO Ajout de la visibilité dans le controleur

        return $txt;
    }

    function afficheModificationItem($modif)
    {

        $html = <<<END
        <form action="./" method="post" class="formulaire">

            <h1>Création liste</h1>
            <input type="text" placeholder="Titre" name="titreNouvelleListe"><br>
            <input type="text" placeholder="Description" name="descriptionNouvelleListe"><br>
            <input type="text" placeholder="Titre" name="titreNouvelleListe"><br> Limite de validité : <input type="date" name="dateLimiteNouvelleListe"><br>
            <input type="submit" value="Ajouter une liste"></input>

        </form>

END;
        return $html;
    }



    function render($selecter, $modif)
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
