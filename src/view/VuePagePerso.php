<?php

namespace wishlist\view;

use wishList\model\User;

class VuePagePerso
{

    public function render($u, $message = "")
    {

        $header = VueGenerale::renderHeader();


        $listes = $u->listes()->get();

        $listesTxt = "";

        foreach ($listes as $key => $value) {

            //            echo ($key);
            $items = $value->item()->get();

            $compteur = count($items);
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
            
        $app = \Slim\Slim::getInstance();
        $urlDetailListe = $app->urlFor('route_liste',['no'=>$value->no,'token_visu'=>$value->token_visu]);
        $urlValiderListe = $app->urlFor('route_listeValider',['no'=>$value->no,'token'=>$value->token]);
        $urlModifListe = $app->urlFor('route_get_modifListe',['no'=>$value->no,'token'=>$value->token]);
        $urlHome = $app->urlFor('route_home');
        $urlListeCreer = $app->urlFor('route_listeCreer');

            if ($value->token_visu != "") {
                $visuListe = "<a  href='$urlDetailListe'>Liste 🔗</a>";
            } else {
                $visuListe = "<a  href='$urlValiderListe'>Valider la liste ✅</a>";
            }



            $listesTxt .= " <div class='info'>
                                <span >Liste n°$value->no</span>
                                <a  href='$urlModifListe'>Modification 🖉</a>
             
                                $visuListe
             
                                <label>Item(s) réservé(s) ($reserve / $compteur)<br><progress  name='prog' max='$compteur' value='$reserve'></progress></label>
                                
                             </div>";
        }

        $navBarre = VueGenerale::renderNavBarre();
        //TODO
        //Permettre les modifs de nom d'utilisateur, de mail, de mdp

        if ($message != "") {
            $message =
                "<section id='message'>$message</section>";
        }

        $nbListes = count($listes);
        $html = <<<END

        $header
<body id="accueil">
$navBarre

<section id="mainContent">

$message
<div class="section" id="infoCompte">
        <img id="profilPic" src="$urlHome/img/profil.png">
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
            $listesTxt

    </div>
    <br>
    <br>
    <a href="$urlListeCreer" class="boutton">Créer une liste</a>

    </section>
</body>

END;

        echo $html;
    }
}
