<?php

namespace wishlist\view;

class VueCreation
{
    const LIST = 1;
    const ITEM = 2;
    const SUPPR_LIST = 3;
    const SUPPR_ITEM = 4;

    function afficheCreationListe()
    {

        $token = substr(base64_encode(random_bytes(64)), 0, 10);
        $token = strtr($token, '+/', '-_');

        $app = \Slim\slim::getInstance();
        $urlpostListeValid = $app->urlFor('route_post_listeValidation',['token'=>$token]);
        
        $html = <<<END
        <form action="$urlpostListeValid" class="formulaire" method="post">

            <h1>Création liste</h1>
            <input type="text" placeholder="Titre" name="titreNouvelleListe"><br>
            <input type="text" placeholder="Description" name="descriptionNouvelleListe"><br>
            Limite de validité : <input type="date" name="dateLimiteNouvelleListe"><br>
            <input type="submit" value="Ajouter une liste"></input>

        </form>

END;
        return $html;
    }

    function afficheCreationItem($token, $no)
    {

        $app = \Slim\slim::getInstance();
        $urlpostValidItem = $app->urlFor('route_post_validationItem');

        $html = <<<END
        <form action="$urlpostValidItem" method="post" class="formulaire">

            <h1>Ajout d'un item</h1>
            <input type="text" name="tokenListe" value=$token required readonly><br>
            <input type="text" name="noListe" value=$no required readonly><br>
            <input type="text" name="nomItem" placeholder="Nom" required><br>
            <input type="text" name="descriptionItem" placeholder="Description" required><br>
            <input type="number" name="prixItem" min="0.01" max="99999.99" step="any" placeholder="Prix" required><br>
            <input type="url" name="URL" placeholder="Lien vers une page de description ? (optionnel)"><br>
            <input type="submit" value="Ajouter l'objet dans la liste" required></input>

        </form>

END;
        return $html;
    }

    function afficheSuppression($arg1, $arg2)
    {

        $app = \Slim\slim::getInstance();

        // Si le deuxième argument est vide, on utilise un item
        if ($arg2 == "") {
            $urlSuppression = $app->urlFor('route_suppressionItem', ['id' => $arg1]);
            $urlModification = $app->urlFor('route_post_modifItem', ['id' => $arg1]);
        } else {
            $urlSuppression = $app->urlFor('route_suppressionListe', ['token' => $arg1, 'no' => $arg2]);
            $urlModification = $app->urlFor('route_post_modifListe', ['token' => $arg1, 'no' => $arg2]);
        }

        $txt = $app == "" ? "l'item" : "la liste";

        $html = <<<END
        <form action="$urlSuppression" method="post" class="formulaire bgRed">

        <h1>Voulez-vous vraiment supprimer $txt ?</h1>

            <input type="submit" value="Oui" required>
            <a href="$urlModification">Retour à la modification</a>

        </form>

END;
        return $html;
    }

    function render($selecter, $token = "", $no = "")
    {
        switch ($selecter) {

            case self::LIST:
                $content = $this->afficheCreationListe();
                break;
            case self::SUPPR_LIST:
                $content = $this->afficheSuppression($token, $no);
                break;
            case self::SUPPR_ITEM:
                $content = $this->afficheSuppression($token, "");
                break;
            case self::ITEM:
                $content = $this->afficheCreationItem($token, $no);
                break;
        }

        VueGenerale::renderPage($content);
    }
}
