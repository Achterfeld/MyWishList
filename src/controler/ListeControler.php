<?php

namespace wishlist\controler;

use \Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\Liste;
use wishlist\model\Item;
use wishlist\view\VueParticipant;
use wishlist\view\VueCreation;
use wishlist\view\VueModification;

class ListeControler
{




    public function getItem($id)
    {
        $i = Item::where('id', '=', $id)->first();
        $v = new VueParticipant($i);
        $v->render(VueParticipant::ITEM_VIEW);
    }

    public function getItemListe($idItem) {
        $i = Item::where('id', '=',$idItem)->first();
        if (is_null($i->reservation))
            $r = true;
        else
            $r = false;
        $v = new VueParticipant($i);
        $v->afficheItemListe($idItem, $r);
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
        $l->expiration = filter_var($datas->post("dateLimiteNouvelleListe"),FILTER_SANITIZE_SPECIAL_CHARS);
        $l->titre = substr(filter_var($datas->post("titreNouvelleListe"),FILTER_SANITIZE_SPECIAL_CHARS),0,256);
        $l->description = filter_var($datas->post("descriptionNouvelleListe"),FILTER_SANITIZE_SPECIAL_CHARS);
        $l->token = $token;

        $l->save();
    }

    public function addRes($id) {
        $app = new \Slim\Slim;
        $i = Item::where('id', '=', $id)->first();

        $i->reservation = $app->request()->post("participant");
        $i->save();
    }


    public function modifierListe($no,$token){

        $app = new \Slim\Slim;
        $l = Liste::where([['no', '=', $no],['token','=',$token]])->first();

        $v = new VueModification();
        $v->render(VueModification::LIST,$l);

    }

	public function validerListe($no,$token){
        
        $app = new \Slim\Slim;
        $l = Liste::where([['no', '=', $no],['token','=',$token]])->first();

        $datas = $app->request();

        $l->expiration = filter_var($datas->post("dateLimiteNouvelleListe"),FILTER_SANITIZE_SPECIAL_CHARS);
        $l->titre = substr(filter_var($datas->post("titreNouvelleListe"),FILTER_SANITIZE_SPECIAL_CHARS),0,256);
        $l->description = filter_var($datas->post("descriptionNouvelleListe"),FILTER_SANITIZE_SPECIAL_CHARS);
        
        $l->save();

    }

}
