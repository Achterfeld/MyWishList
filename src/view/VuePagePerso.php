<?php

namespace wishlist\view;

use wishList\model\User;

class VuePagePerso
{

    /**
     * Fonction permettant de rendre la vue de page personnelle.
     *
     * @param $u Utilisateur Utilisateur connecté.
     * @param $message String Message de la liste. 
     *
     */
    public function render($u, $message = "")
    {

        $app = \Slim\Slim::getInstance();
        $urlHome = $app->urlFor('route_home');
        $urlListeCreer = $app->urlFor('route_listeCreer');

        $header = VueGenerale::renderHeader();


        $listes = $u->listes()->get();

        $listesTxt = "";


        foreach ($listes as $key => $value) {

            $items = $value->item()->get();

            $compteur = count($items);
            $reserve = 0;

            foreach ($items as $key1 => $value1) {

                if (!is_null($value1->reservation)) {
                    $reserve++;
                }
            }

            $urlDetailListe = $app->urlFor('route_liste', ['no' => $value->no, 'token_visu' => $value->token_visu]);
            $urlValiderListe = $app->urlFor('route_listeValider', ['no' => $value->no, 'token' => $value->token]);
            $urlModifListe = $app->urlFor('route_get_modifListe', ['no' => $value->no, 'token' => $value->token]);
            $urlHome = $app->urlFor('route_home');
            $urlListeCreer = $app->urlFor('route_listeCreer');
            $urlProfilModification = $app->urlFor('route_pagePersoConfirmerModifier');

            if ($value->token_visu != "") {
                $visuListe = "<a  href='$urlDetailListe'>Liste 🔗</a>";
            } else {
                $visuListe = "<a  href='$urlValiderListe'>Valider la liste ✅</a>";
            }

            if ($compteur == 0) {
                $description = "<a href='$urlModifListe'>Aucun item dans cette liste, ajoutez en ici</a>";
                $label = 
                "<label>
                    $description
                </label>";
            } else {
                $itReserv = $reserve > 1 ? "Items réservés" : "Item réservé";
                $label =
                    "<label>$itReserv ($reserve / $compteur)<br>
                    <progress  name='prog' max='$compteur' value='$reserve'></progress>
                </label>";
            }

            $listesTxt .= " <div class='info'>
                                <span >Liste n°$value->no</span>
                                <a  href='$urlModifListe'>Modification 🖊️</a>

                                $visuListe

                                $label

                             </div>";
        }

        if (isset($_SESSION['session']['user_id'])) {
            $u = User::where('user_id', '=', $_SESSION['session']['user_id'])->first();
            $participe = $u->aParticipe()->get();
            $participations = "";
            foreach ($participe as $value) {

                $urlItem = $app->urlFor('route_itemID', ['id' => $value->id]);
                $participations .= "<div class='itemReserve'><a href='$urlItem'>$value->nom</a></div>";
            }
        }

        $navBarre = VueGenerale::renderNavBarre();
        //TODO
        //Permettre les modifs de nom d'utilisateur, de mail, de mdp

        if ($message != "") {
            $message =
                "<section id='message'>$message</section>";
        }

        $nbListes = count($listes);

        $u = User::where('user_id', '=', $_SESSION['session']['user_id'])->first();
        if (empty($u->img))
            $img = "profil.png";
        else
            $img = $u->img;

        $urlHome = $app->urlFor('route_home');
        $urlPPersoModif = $app->urlFor('route_pagePersoModifier');
        $urlPPersoSupprimer = $app->urlFor('route_pagePersoPresuppression');
        $urlListePublique = $app->urlFor('route_listePublique');
        $urlCreateurs = $app->urlFor('route_createurs');
        $urlItems = $app->urlFor('route_item');

        $urlListeAjoutParToken = $app->urlFor('route_listeAjoutParToken');

        $html = <<<END

        $header
<body id="accueil">
$navBarre

<section id="mainContent">

$message

<div class="section" id="infoCompte">
        <img id="profilPic" src="$urlHome/img/$img">
         <div id="pp">🖊️</div> 
        <div id="infos">
            <ul>
                <li>
                    <h1>$u->prenom <a href="$urlPPersoModif"> 🖊️</a></h1>
                </li>
                <li>Mail : <span>$u->mail<a href="$urlPPersoModif"> 🖊️</a></span></li>
                <li>Nombre de listes : <span>$nbListes<a href="$urlPPersoModif"></a></span></li>
                <li>Mot de passe : <span>******* <a href="$urlPPersoModif"> 🖊️</a></span></li>
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
    <div id= 'listeBoutonContainer'>
        <div class='listeBouton'>
            <a href="$urlListeCreer" class="bouttonPPerso">Créer une liste</a>
        </div>
        <div class='listeBouton'>
            <a href="$urlListeAjoutParToken" class="bouttonPPerso">Ajouter une liste par token</a>
        </div>
        <div class='listeBouton'>
            <a href="$urlItems" class="bouttonPPerso">Voir tous les items</a>
        </div>
        <div class='listeBouton'>
            <a href="$urlListePublique" class="bouttonPPerso">Listes de souhaits publiques</a>
        </div>
        <div class='listeBouton'>
            <a href="$urlCreateurs" class="bouttonPPerso">Liste des créateurs</a>
        </div>
        <div class='listeBouton'>
            <a href="$urlPPersoSupprimer" class="bouttonPPerso redBG">Supprimer le compte</a>
        </div>
    </div>

    <br>
    <br>
    <br>

    <div class= "section">
        <h1>A participé à :</h1>
        $participations
    </div>
    </section>
</body>
<script>
document.getElementById("pp").addEventListener('click', function(e) {
	let div = document.querySelector('#infoCompte');
	
	let form = '<form enctype="multipart/form-data" action="$urlProfilModification" method="POST"><input name="fileToUpload"type="file"/><br/><input type="submit" value="Upload" /></form>';

	div.insertAdjacentHTML('afterend', form);
	console.log('test');
});

</script>
END;

        // OK validé pour echo
        echo $html;
    }


    /**
     * Fonction permettant de rendre la vue de suppression de compte. 
     *
     */
    public function compteSupprimer()
    {
        $header = VueGenerale::renderHeader();

        $app = \Slim\Slim::getInstance();

        $urlHome = $app->urlFor('route_home');

        $html = <<<END
        $header
<body id="connexion">

    <a href="$urlHome"><img style="height:200px;width:200px" src="$urlHome/img/logo.png"></a>


        <div>

        <p>Votre compte a été supprimé.</p>
        <br>
        <br>
        <a href="$urlHome" class="boutton">Retour à l'accueil</a>

        </div>
<body>
END;
        //OK validé  pour echo
        echo $html;
    }


    /**
     * Fonction permettant de rendre la vue de modification d'utilisateur.
     *
     */
    public function modification()
    {


        if (isset($_SESSION['session']['user_id'])) {

            $app = \Slim\Slim::getInstance();
            $urlPPersoConfirmerModif = $app->urlFor('route_pagePersoConfirmerModifier');

            $prenom = $_SESSION['session']['prenom'];

            $html = <<<END

    <body>
        <form class="formulaire" method="post" action="$urlPPersoConfirmerModif" enctype="multipart/form-data">
                <h1>Modifier ses informations :</h1><h3> Laissez la valeur par défaut pour conserver la valeur actuelle</h3>

                <input type="text" placeholder="Prenom" name="Prenom" value='$prenom' ><br>
                <input type="password" placeholder="Mot de passe" name="Passe1" ><br>
                <input type="password" placeholder="Confirmation mot de passe" name="Passe2" ><br>
                Choisir une photo de profil :<input type="file" name="image" id="image">
                <input class="boutton" type="submit" value="Valider" required ></input>
        </form>
    </body>
END;
        }


        VueGenerale::renderPage($html, VueGenerale::DarkPage);
    }

    const RECONNEXION = 1;
    const PAGE_PERSO = 2;


    /**
     * Fonction permettant de rendre la vue de confirmation de modification.
     *
     * @param $txt int Permet de choisir une option.
     *
     */
    public function confirmation($txt = self::PAGE_PERSO)
    {

        $app = \Slim\Slim::getInstance();

        $urlHome = $app->urlFor('route_home');

        switch ($txt) {
            case self::RECONNEXION:
                $url = $app->urlFor('route_connexion');
                $info = "Se reconnecter";
                break;

            case self::PAGE_PERSO:
                $url = $app->urlFor('route_get_pagePerso');
                $info = "Retour vers la page personnelle";
                break;
        }

        $html = <<<END

    <a href="$urlHome"><img style="height:200px;width:200px" src="$urlHome/img/logo.png"></a>


        <div>
            <p>Votre compte a été modifié.</p>
            <br>
            <br>
            <a href="$url" class="boutton">$info</a>

        </div>
<body>
END;

        VueGenerale::renderPage($html, VueGenerale::DarkPage);
    }

    /**
     * Fonction permettant de rendre la vue des créateurs.
     *
     * @param $lCreateur Utilisateur[] Liste des créateurs.
     *
     */
    public function afficherCreateur($lCreateur)
    {

        $html = "<div id='listeCreateur'>";
        foreach (array_unique($lCreateur) as $user) {
            $userName = $user->toString();

            $html .=
                "<div class = 'createur'>
                $userName
            </div>";
        }

        $html .= "</div>";

        VueGenerale::renderPage($html, VueGenerale::DarkPage);
    }
}
