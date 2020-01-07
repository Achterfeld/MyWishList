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
        $this->ajoutImg($i);


        $i->save();

        $this->getItem($i->id);
    }

    public function getItem($id)
    {
        $i = Item::where('id', '=', $id)->first();
        $v = new VueParticipant($i);
        $v->render(VueParticipant::ITEM_VIEW);
    }

    public function validationModifierItem($id)
    {

        $app = \Slim\Slim::getInstance();
        $i = Item::where('id', '=', $id)->first();

        $datas = $app->request();

        $i->nom = filter_var($datas->post("nomItem"), FILTER_SANITIZE_SPECIAL_CHARS);
        $i->descr = substr(filter_var($datas->post("descriptionItem"), FILTER_SANITIZE_SPECIAL_CHARS), 0, 256);
        $i->img = filter_var($datas->post("URLImage"), FILTER_SANITIZE_SPECIAL_CHARS);
        $i->url = filter_var($datas->post("URL"), FILTER_SANITIZE_SPECIAL_CHARS);
        $i->tarif = filter_var($datas->post("prixItem"), FILTER_SANITIZE_SPECIAL_CHARS);
        $this->ajoutImg($i);    

        $i->save();
    }

    public function modifierItem($id)
    {

        //        $app = new \Slim\Slim;
        $i = Item::where('id', '=', $id)->first();

        $v = new VueModification();
        $v->render(VueModification::ITEM, $i);
    }

    public function confirmerSupprItem($id)
    {
        $v = new VueCreation();
        $v->render(VueCreation::SUPPR_ITEM, $id);
    }

    public function supprimer($id)
    {
        $i = Item::where('id', '=', $id);
        $i->delete();

        $app = \Slim\Slim::getInstance();

        if (isset($_SESSION['session']['user_id'])) {

            $v = new VuePagePerso();
            $u = User::where('user_id', '=', $_SESSION['session']['user_id'])->first();
            $v->render($u, "Item supprimée");
        } else {

            $itemUrl = $app->urlFor('route_home');
            $app->response->redirect($itemUrl, 303);
        }
    }

    public static function ajoutImg($i) {
        if (!empty($_FILES["image"])) {
            $target_dir =  "./img/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // verifie si l'image est bien une image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if($check !== false) {
                    $uploadOk = 1;
                } else {
                    $uploadOk = 0;
                }
            }
            //vérifie que la taille de l'image soit inférieur à 1mo
            if ($_FILES["image"]["size"] > 1000000) {
                $uploadOk = 0;
            }
            // vérifie si le fichier existe déjà
            if (file_exists($target_file)) {
                $uploadOk = 0;
            }
            // vérifie le format
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                $uploadOk = 0;
            }
            //si pas de probleme durant les vérification upload
            if ($uploadOk != 0) {
                move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
            }
            $i->img = $_FILES["image"]["name"];
        }
    }
}