<?php

namespace wishlist\controler;

use \Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\Liste;
use wishlist\model\Item;
use wishlist\view\VueParticipant;
use wishlist\view\VueCreation;

class ListeControler
{




    public function getItem($id)
    {
        $i = Item::where('id', '=', $id)->first();
        $v = new VueParticipant($i);
        $v->render(VueParticipant::ITEM_VIEW);
    }

    public function getItemListe($id, $idItem) {
        $i = Item::where('id', '=',$id)->where('liste_id', '=',$idItem)->first();
        $v = new VueParticipant($i);
        $v->render(VueParticipant::LIST_ITEM_VIEW);
    }

    public function getAllListe() {
        $liste = Liste::OrderBy('titre')->get();
        $v = new VueParticipant($liste);
        $v->render(VueParticipant::ALL_LIST_VIEW);
    }

    public function getAllItem()
    {
        $liste = Item::get();
        $v = new VueParticipant($liste);
        $v->render(VueParticipant::ALL_ITEM_VIEW);
    }

    public function getListe($no)
    {
        $l = Liste::where('no', '=', $no)->first();
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

        $l->user_id = -1;

        //TODO
        //A ajuster avec un user_id

        $l->expiration = $datas->post("dateLimiteNouvelleListe");
        $l->titre = $datas->post("titreNouvelleListe");
        $l->description = $datas->post("descriptionNouvelleListe");
        $l->token = $token;

        $l->save();
    }

    public function reserverItemListe($id, $particiapnt) {
        
    }
}
