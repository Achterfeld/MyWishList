<?php

namespace wishlist\controler;

use \Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\Liste;
use wishlist\model\Item;
use wishlist\view\VueParticipant;
use wishlist\view\VueCreation;
use wishlist\view\VueModification;

class ItemControler
{


    public function getCreation($no, $token)
    {
        $v = new VueCreation();
        $v->render(VueCreation::ITEM, $token, $no);
    }


    public function validerItem()
    {

        $app = \Slim\Slim::getInstance();

        $i = new Item();
        $datas = $app->request();

        $i->liste_id = $datas->post('noListe');
        $i->nom = filter_var($datas->post('nomItem'), FILTER_SANITIZE_SPECIAL_CHARS);
        $i->descr = filter_var($datas->post('descriptionItem'), FILTER_SANITIZE_SPECIAL_CHARS);

        $url = filter_var($datas->post('URL'), FILTER_SANITIZE_SPECIAL_CHARS);
        $i->url = $url;

        $i->tarif = $datas->post('prixItem');
        $i->save();

        $this->getItem($i->id);
    }
    public function getItem($id)
    {
        $i = Item::where('id', '=', $id)->first();
        $v = new VueParticipant($i);
        $v->render(VueParticipant::ITEM_VIEW);
    }
}
