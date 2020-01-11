<?php

namespace wishlist\controler;

use \Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\Liste;
use wishlist\model\Item;
use wishlist\model\User;
use wishlist\view\VueParticipant;
use wishlist\view\VueCreation;
use wishlist\view\VueModification;
use wishlist\view\VuePagePerso;

class ListeControler
{
    /**
     * Fonction permettant de rendre la vue d'un item de la liste. 
     *
     * @param int $id Id de l'item de la liste souhaité.
     */
    public function getItem($id)
    {
        $i = Item::where('id', '=', $id)->first();
        $v = new VueParticipant($i);
        $v->render(VueParticipant::ITEM_VIEW);
    }

    /**
     * Fonction permettant de rendre la vue d'un item de la liste pour la reservation. 
     *
     * @param int $id Id de l'item de la liste souhaité.
     */
    public function getItemListe($idItem)
    {
        $i = Item::where('id', '=', $idItem)->first();
        $v = new VueParticipant($i);
        $v->afficheItemListe($i);
    }

    /**
     * Fonction permettant de rendre la vue de toute les listes. 
     *
     */
    public function getAllListe()
    {
        $liste = Liste::where([['public', '=', '1'],['token_visu','!=',""]])->OrderBy('expiration')->get();
        $v = new VueParticipant($liste);
        $v->render(VueParticipant::ALL_LIST_VIEW);
    }

    /**
     * Fonction permettant de rendre la vue de toute les items. 
     *
     */
    public function getAllItem()
    {
        $liste = Item::get();
        $v = new VueParticipant($liste);
        $v->render(VueParticipant::ALL_ITEM_VIEW);
    }

    /**
     * Fonction permettant de rendre la vue de la liste demandée. 
     * 
     * @param int $no Numéro de la liste.
     * @param string $token_visu Token de la liste.
     * 
     */
    public function getListe($no, $token_visu)
    {
        $l = Liste::where([['no', '=', $no], ['token_visu', '=', $token_visu]])->first();
        $v = new VueParticipant($l);
        $v->render(VueParticipant::LIST_VIEW);
    }

    /**
     * Fonction permettant de rendre la vue de création de liste. 
     *
     */
    public function getCreation()
    {
        $v = new VueCreation();
        $v->render(VueCreation::LIST);
    }

    /**
     * Fonction permettant de rendre un résumé de ce que contient la liste. 
     *
     * @param string $token Token de la liste.
     */
    public function getResumeListe($token)
    {
        $l = Liste::where('token', '=', $token)->first();
        $v = new VueParticipant($l);
        $v->render(VueParticipant::LIST_VIEW_TOKEN);
    }

    /**
     * Fonction permettant de rendre la vue d'ajout d'item dans une liste. 
     *
     */
    public function getAjout()
    {

        $v = new VueCreation();
        $v->render(VueCreation::AJOUT_ITEM);
    }

    /**
     * Fonction permettant d'inserérer une nouvelle liste. 
     *
     * @param string $token Token de la liste.
     */
    public function insertListe($token)
    {

        $app = new \Slim\Slim;
        $l = new Liste();

        $datas = $app->request();

        if (isset($_SESSION['session'])) {
            $l->user_id = $_SESSION['session']['user_id'];
        } else {
            $l->user_id = -1;
            $l->public = 1;

            $token_visu = substr(base64_encode(random_bytes(64)), 0, 10);
            $token_visu = strtr($token_visu, '+/', '-_');
            $l->token_visu = $token_visu;
        }

        $l->expiration = filter_var($datas->post("dateLimiteNouvelleListe"), FILTER_SANITIZE_SPECIAL_CHARS);
        $l->titre = substr(filter_var($datas->post("titreNouvelleListe"), FILTER_SANITIZE_SPECIAL_CHARS), 0, 256);
        $l->description = filter_var($datas->post("descriptionNouvelleListe"), FILTER_SANITIZE_SPECIAL_CHARS);
        $l->token = $token;

        $l->save();
    }

    /**
     * Fonction permettant d'ajouter une réservation à un item. 
     * 
     * La fonction filtre les deux données de réservation du post, et de les ajouter à la base de données dans le tuple de l'item en question. 
     *
     * @param int $id Id de l'item en question.
     */
    public function addRes($id)
    {
        $app = \Slim\Slim::getInstance();
        $i = Item::where('id', '=', $id)->first();

        $i->reservation = filter_var($app->request()->post("participant"), FILTER_SANITIZE_SPECIAL_CHARS);
        $i->message = substr(filter_var($app->request()->post("message"), FILTER_SANITIZE_SPECIAL_CHARS), 0, 256);

        if (isset($_SESSION['session']['user_id'])) {
            $i->user_id = $_SESSION['session']['user_id'];
        }


        $i->save();
    }

    /**
     * Fonction permettant de rendre la vue de modification de liste. 
     *
     *
     * @param int $no Numéro de la liste.
     * @param string $token Token de la liste.
     */
    public function modifierListe($no, $token)
    {

        $l = Liste::where([['no', '=', $no], ['token', '=', $token]])->first();

        $v = new VueModification();
        $v->render(VueModification::LIST, $l);
    }


    /**
     * Fonction permettant de mettre à jour une liste. 
     *
     * La fonction permet de mettre à jour une liste choisie, avec les données filtrés récupérées dans le post.
     *
     * @param int $no Numéro de la liste.
     * @param string $token Token de la liste.
     */
    public function validerListe($no, $token)
    {

        $app = new \Slim\Slim;
        $l = Liste::where([['no', '=', $no], ['token', '=', $token]])->first();

        $datas = $app->request();

        $l->expiration = filter_var($datas->post("dateLimiteNouvelleListe"), FILTER_SANITIZE_SPECIAL_CHARS);
        $l->titre = substr(filter_var($datas->post("titreNouvelleListe"), FILTER_SANITIZE_SPECIAL_CHARS), 0, 256);
        $l->description = filter_var($datas->post("descriptionNouvelleListe"), FILTER_SANITIZE_SPECIAL_CHARS);
        $l->public = $datas->post("visib");
        $l->save();
    }

    /**
     * Fonction permettant de valider une liste. 
     *
     * La fonction permet de valider une liste choisie.
     *
     * @param int $no Numéro de la liste.
     * @param string $token Token de la liste.
     */
    public function confirmerListe($no, $token)
    {
        $l = Liste::where([['no', '=', $no], ['token', '=', $token]])->first();

        $token = substr(base64_encode(random_bytes(64)), 0, 10);
        $token = strtr($token, '+/', '-_');

        $l->token_visu = $token;

        $l->save();
    }

    /**
     * Fonction permettant de rendre la vue de confirmation de suppression de la liste. 
     *
     * @param int $no Numéro de la liste.
     * @param string $token Token de la liste.
     */
    public function confirmerSupprListe($no, $token)
    {
        $v = new VueCreation();
        $v->render(VueCreation::SUPPR_LIST, $token, $no);
    }

    /**
     * Fonction permettant de supprimer une liste liste. 
     *
     * @param int $no Numéro de la liste.
     * @param string $token Token de la liste.
     */
    public function supprimer($no, $token)
    {
        $l = Liste::where([['no', '=', $no], ['token', '=', $token]]);
        $l->delete();

        $app = \Slim\Slim::getInstance();

        if (isset($_SESSION['session']['user_id'])) {

            $v = new VuePagePerso();
            $u = User::where('user_id', '=', $_SESSION['session']['user_id'])->first();
            $v->render($u, "Liste supprimée");
        } else {

            $itemUrl = $app->urlFor('route_home');
            $app->response->redirect($itemUrl, 303);
        }
    }

    /**
     * Fonction permettant d'ajouter une liste grâce à son token. 
     *
     * La fonction permet d'ajouter une liste à un utilisateur grâce à son token (celui de la liste).
     *
     */
    public function getAjoutParToken()
    {

        $app = \Slim\Slim::getInstance();
        $token = $app->request->post('TokenListe');
        $l = Liste::where("token", "=", $token)->first();

        if (isset($_SESSION['session']['user_id']) && $l->user_id == -1) {
            $l->user_id = $_SESSION['session']['user_id'];
            $l->save();
            $urlPPerso = $app->urlFor('route_get_pagePerso');
            $app->response->redirect($urlPPerso,303);
        }
    }
}
