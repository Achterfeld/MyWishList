<?php

namespace wishlist\view;

use wishlist\model\Liste;

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

        $app = \Slim\Slim::getInstance();
        $urlItemAjout = $app->urlFor('route_itemAjout', ['no' => $no, 'token' => $token]);
        $urlListePresuppression = $app->urlFor('route_presuppressionListe', ['no' => $no, 'token' => $token]);

        $html = <<<END
        <form action="$token" method="post" class="formulaire">

            <h1>Modification liste</h1>
            <input type="text" value="$titre" placeholder="Titre" name="titreNouvelleListe" maxlength="256"><br>
            <input type="text" value="$desc" placeholder="Description" name="descriptionNouvelleListe" maxlength="256"><br>
            Limite de validité : <input type="date" value="$exp" name="dateLimiteNouvelleListe"><br>

            $visibilite

            <input type="submit" value="Modifier la liste"></input>

        </form>

        <br>

        <form class='formulaire'>
            <a href="$urlItemAjout"> <h1>+</h1>Ajouter un item dans la liste</a>
        </form>

        <br>

        <form class='formulaire ' action="$urlListePresuppression" method="post">
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
        $reservation = $modif->reservation;
        $id = $modif->id;

        $html = "";

        if (isset($_SESSION['session'])) {

            $liste = $modif->liste()->first();

            $userID = -1;

            if (!is_null($liste)) {
                $user = $liste->possede()->first();
                if (!is_null($user)) {
                    $userID = $user->user_id;
                }
            }

            if (is_null($reservation) && $userID == $_SESSION['session']['user_id']) {

                $nom = $modif->nom;
                $descr = $modif->descr;
                $img = $modif->img;
                $url = $modif->url;
                $tarif = $modif->tarif;

                $app = \Slim\Slim::getInstance();
                //$urlItemPresuppression = $app->urlFor('route_presuppressionItem', ['id' => $id]);
                $urlItemPresuppression = $app->urlFor('route_presuppressionItem', ['id' => $id]);

                //#############################

                $app = \Slim\slim::getInstance();
                $urlpostValidItem = $app->urlFor('route_post_validationItem');

                $html = <<<END
        <form action="$id" method="post" class="formulaire" enctype="multipart/form-data">

            <h1>Modification item</h1>
            <input type="text" name="nomItem" value='$nom' placeholder="Nom" required><br>
            <input type="text" name="descriptionItem" value='$descr' placeholder="Description" maxlength="256" required><br>
            <input type="text" name="URLImage" id="url" value='$img' placeholder="Url de l'image"><br>
            ou choisir une image a uploader :<input type="file" name="image" id="image" ><br>
            <input type="number" name="prixItem" value='$tarif' min="0.01" max="99999.99" step="any" placeholder="Prix" required><br>
            <input type="url" name="URL" value='$url' placeholder="Lien vers une page de description ? (optionnel)"><br>

            <input type="submit" value="Modifier l'item"></input>
            <input onClick="document.getElementById('url').value = '';" type="submit" value="🖼️ Supprimer l'image"></input>

        </form>

        <br>

        <form class='formulaire redBG' action="$urlItemPresuppression" method="post">
            <input type="submit" value="❌Supprimer l'item">
        </form>

END;
                //#############################

            } else {
                $app = \Slim\Slim::getInstance();
                $urlItem = $app->urlFor('route_itemID', ['id' => $id]);
                $app->response->redirect($urlItem, 303);
            }
        } else {
            $app = \Slim\Slim::getInstance();
            $urlItem = $app->urlFor('route_itemID', ['id' => $id]);
            $app->response->redirect($urlItem, 303);
        }
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

        VueGenerale::renderPage($content, VueGenerale::DarkPage);
    }
}
