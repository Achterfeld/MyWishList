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
        <form action="$token" method="post">

            <h1>Modification liste</h1>
            <input type="text" value="$titre" placeholder="Titre" name="titreNouvelleListe"><br>
            <input type="text" value="$desc" placeholder="Description" name="descriptionNouvelleListe"><br>
            Limite de validité : <input type="date" value="$exp" name="dateLimiteNouvelleListe"><br>
            
            $visibilite

            <input type="submit" value="Modifier la liste"></input>

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
            <input type="radio" value="privé" name="visibilité" $public>
            <label for="privé">Privée</label>
        </div>
        <div>
            <input type="radio" value="public" name="visibilité" $prive>
            <label for="public">Publique</label>
        </div>
END;

//TODO Ajout de la visibilité dans le controleur

return $txt;
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
