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




    public function getItem($id)
    {
        $i = Item::where('id', '=', $id)->first();
        $v = new VueParticipant($i);
        $v->render(VueParticipant::ITEM_VIEW);
    }

    public function getItemListe($idItem)
    {
        $i = Item::where('id', '=', $idItem)->first();
        $v = new VueParticipant($i);
        $v->afficheItemListe($i);
    }

    public function getAllListe()
    {
        $liste = Liste::where('public', '=', '1')->OrderBy('expiration')->get();
        $v = new VueParticipant($liste);
        $v->render(VueParticipant::ALL_LIST_VIEW);
    }

    public function getAllItem()
    {
        $liste = Item::get();
        $v = new VueParticipant($liste);
        $v->render(VueParticipant::ALL_ITEM_VIEW);
    }

    public function getListe($no, $token)
    {
        $l = Liste::where([['no', '=', $no], ['token', '=', $token]])->first();
        $v = new VueParticipant($l);
        $v->render(VueParticipant::LIST_VIEW);
    }

    public function getCreation()
    {
        $v = new VueCreation();
        $v->render(VueCreation::LIST);
    }

    public function getResumeListe($token)
    {
        $l = Liste::where('token', '=', $token)->first();
        $v = new VueParticipant($l);
        $v->render(VueParticipant::LIST_VIEW_TOKEN);
    }

    public function insertListe($token)
    {

        $app = new \Slim\Slim;
        $l = new Liste();

        $datas = $app->request();

        if (isset($_SESSION['session'])) {
            $l->user_id = $_SESSION['session']['user_id'];
        } else {
            $l->user_id = -1;
        }

        $l->expiration = filter_var($datas->post("dateLimiteNouvelleListe"), FILTER_SANITIZE_SPECIAL_CHARS);
        $l->titre = substr(filter_var($datas->post("titreNouvelleListe"), FILTER_SANITIZE_SPECIAL_CHARS), 0, 256);
        $l->description = filter_var($datas->post("descriptionNouvelleListe"), FILTER_SANITIZE_SPECIAL_CHARS);
        $l->token = $token;

        $l->save();
    }

    public function addRes($id)
    {
        $app = new \Slim\Slim;
        $i = Item::where('id', '=', $id)->first();

        $i->reservation = filter_var($app->request()->post("participant"), FILTER_SANITIZE_SPECIAL_CHARS);
        $i->reservation = substr(filter_var($app->request()->post("message"), FILTER_SANITIZE_SPECIAL_CHARS), 0, 256);

        $i->save();
    }


    public function modifierListe($no, $token)
    {

        //        $app = new \Slim\Slim;
        $l = Liste::where([['no', '=', $no], ['token', '=', $token]])->first();

        $v = new VueModification();
        $v->render(VueModification::LIST, $l);
    }

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

    public function confirmerSupprListe($no, $token)
    {
        $v = new VueCreation();
        $v->render(VueCreation::SUPPR_LIST, $token, $no);
    }

    public function supprimer($no, $token)
    {
        $l = Liste::where([['no', '=', $no], ['token', '=', $token]]);
        $l->delete();


        if (isset($_SESSION['session']['user_id'])) {

            $v = new VuePagePerso();
            $u = User::where('user_id', '=', $_SESSION['session']['user_id'])->first();
            $v->render($u, "Liste supprimée");
        } else {
            $app = new \Slim\Slim;

            $app->response->redirect("/myWishList", 303);
        }
    }
}
