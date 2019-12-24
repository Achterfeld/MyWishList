<?php

namespace wishlist\view;

use wishList\model\User;

class VuePagePerso
{

    public function render($u, $message="")
    {

        $header = VueGenerale::renderHeader();


        $listes = $u->listes()->get();

        $listesTxt = "";

        foreach ($listes as $key => $value) {

            //            echo ($key);
            $items = $value->item()->get();

            $compteur = count ($items);
            $reserve = 0;

            foreach ($items as $key1 => $value1) {

//                $compteur++;

                // var_dump($value->reservation);

                // var_dump($value->reservation);
                // echo($value);

                if (!is_null($value1->reservation)) {
                    $reserve++;
                }
            }

            if ($value->token_visu != ""){
                $visuListe = "<a href=\"/myWishList/liste/$value->no/$value->token_visu\">Liste 🔗</a>";
            }else{
                $visuListe = "<a href=\"/myWishList/liste/$value->no/$value->token/valider\">Valider la liste</a>";
            }
             


            $listesTxt .= " <li>
                                <span>Liste n°$value->no</span>
                                <a href=\"/myWishList/modification/liste/$value->no/$value->token\">Modification 🖉</a>
             
                                $visuListe
             
                                <span>Item(s) réservé(s) : ($reserve / $compteur) </span>
                                <progress max='$compteur' value='$reserve'></progress>
                             </li>";
        }

        $navBarre = VueGenerale::renderNavBarre();
        //TODO
        //Permettre les modifs de nom d'utilisateur, de mail, de mdp

        if ($message!="") {
            $message=
            "<section id='message'>$message</section>";
        }

        $nbListes= count($listes);
        $html = <<<END

        $header
<body id="accueil">
$navBarre
$message
<div class="section" id="infoCompte">
        <img id="profilPic" src="/myWishList/img/profil.png">
        <div id="infos">
            <ul>
                <li>
                    <h1>$u->prenom <a href="./"> 🖉</a></h1>
                </li>
                <li>Mail : <span>$u->mail<a href="./"> 🖉</a></span></li>
                <li>Nombre de listes : <span>$nbListes<a href="./"></a></span></li>
                <li>Mot de passe : <span>******* <a href="./"> 🖉</a></span></li>
            </ul>
        </div>
    </div>
    <br>
    <br>
    <div class="section" id="infoListe">

        <h1>Propriétaire des listes :</h1>
        <ul>
            $listesTxt
        </ul>

    </div>
    <br>
    <br>
    <a href="/myWishList/liste/creer" class="boutton">Créer une liste</a>

</body>

END;

        echo $html;
    }
}
