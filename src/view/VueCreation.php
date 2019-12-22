<?php

namespace wishlist\view;

class VueCreation
{
    const LIST = 1;
    const ITEM = 2;

    function afficheCreationListe()
    {

        $token = substr(base64_encode(random_bytes(64)),0,10);
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

    function afficheCreationItem()
    {

        $html = <<<END
        <form action="validation" method="post" class="formulaire">

            <h1>Création liste</h1>
            <input type="text" placeholder="Titre" name="titreNouvelleListe"><br>
            <input type="text" placeholder="Description" name="descriptionNouvelleListe"><br>
            <input type="text" placeholder="Titre" name="titreNouvelleListe"><br> Limite de validité : <input type="date" name="dateLimiteNouvelleListe"><br>
            <input type="submit" value="Ajouter une liste"></input>

        </form>

END;
        return $html;
    }



    function render($selecter)
    {
        switch ($selecter) {

            case self::LIST:
                $content = $this->afficheCreationListe();
                break;
            case self::ITEM:
                $content = $this->afficheCreationItem();
                break;
        }

        VueGenerale::renderPage($content);
    }
}
