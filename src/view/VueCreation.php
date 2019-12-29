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

        $html = <<<END
        <form action="validation/$token" class="formulaire" method="post">

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

    function afficheSuppressionListe($token, $no)
    {

        $app = \Slim\slim::getInstance();
        $urlSuppressionListe = $app->urlFor('route_suppressionListe', ['no' => $no, 'token' => $token]);
        $urlModificationListe = $app->urlFor('route_post_modifListe', ['no' => $no, 'token' => $token]);

        $html = <<<END
        <form action="$urlSuppressionListe" method="post" class="formulaire bgRed">

        <h1>Voulez-vous vraiment supprimer la liste ?</h1>

            <input type="submit" value="Oui" required>
            <a href="$urlModificationListe">Retour à l'accueil</a>

        </form>

END;
        return $html;
    }

    function afficheSuppressionItem($id)
    {

        $app = \Slim\slim::getInstance();
        $urlSuppressionItem = $app->urlFor('route_suppressionItem', ['id' => $id]);
        $urlModificationItem = $app->urlFor('route_post_modifItem', ['id' => $id]);

        $html = <<<END
        <form action="$urlSuppressionItem" method="post" class="formulaire bgRed">

        <h1>Voulez-vous vraiment supprimer l'item ?</h1>

            <input type="submit" value="Oui" required>
            <a href="$urlModificationItem">Retour à la modification</a>

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
                $content = $this->afficheSuppressionListe($token, $no);
                break;
            case self::SUPPR_ITEM:
                $content = $this->afficheSuppressionItem($token, "");
                break;
            case self::ITEM:
                $content = $this->afficheCreationItem($token, $no);
                break;
        }

        VueGenerale::renderPage($content);
    }
}
