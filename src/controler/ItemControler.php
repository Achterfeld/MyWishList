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

    /**
     * Fonction permettant de rendre la vue création d'un item grace au token de la liste et son numéro d'item.  
     * 
     * @param int $no Numéro de l'item.
     * @param string $token Token de la liste 
     */
    public function getCreation($no, $token)
    {
        $v = new VueCreation();
        $v->render(VueCreation::ITEM, $token, $no);
    }

    /**
     * Fonction permettant de valider un item. 
     *
     * La fonction récupère dans le tableau post les informations de l'item, les filtres et les insère dans un nouveau tuple.
     */
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

    /**
     * Fonction permettant de rendre un seul item.
     *
     * @param int $id Id de l'item à rendre.
     */
    public function getItem($id)
    {
        $i = Item::where('id', '=', $id)->first();
        $v = new VueParticipant($i);
        $v->render(VueParticipant::ITEM_VIEW);
    }

    /**
     * Fonction permettant de valider la modification d'item.
     * 
     * La fonction récupère les nouvelles donées et met à jour l'item en question. 
     * 
     * @param int $id Id de l'item à modifer. 
     */
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

    /**
     * Fonction permettant d'afficher la vue de modification d'item. 
     *
     * @param int $id Id de l'item à modifier. 
     */
    public function modifierItem($id)
    {

        //        $app = new \Slim\Slim;
        $i = Item::where('id', '=', $id)->first();

        $v = new VueModification();
        $v->render(VueModification::ITEM, $i);
    }

    /**
     * Fonction permettant d'afficher la vue de suppression d'item. 
     *
     * @param int $id Id de l'item à modifier. 
     */
    public function confirmerSupprItem($id)
    {
        $v = new VueCreation();
        $v->render(VueCreation::SUPPR_ITEM, $id);
    }

    /**
     * Fonction permettant de supprimer un item.
     * 
     * La fonction permet de supprimer un item de la base de données à partir de son id. 
     * @param int $id Id de l'item à supprimer.
     */
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

    /**
     * Fonction permettant l'ajout d'image. 
     *
     * La fonction upload une image dans le dossier img du site. Puis l'ajoute à l'objet en paramètre. 
     *
     * @param int $i objet auquel on veut ajouter une image.
     */
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

    /**
     * Fonction permettant de créer une cagnote sur un item puis d'afficher la vue. 
     *
     * @param int $id Id de l'item sur lequel on veut créer une cagnote participative. 
     *
     */
    public function creerCagnote($id) {
        
        $item = Item::where('id','=',$id)->first();
        
        if ($item->cagnote == -1) {
            $item->cagnote = 0;
        }

        $item->save();

        $v = new VueModification();
        $v->renderCagnote($item);
    }

    /**
     * Fonction permettant de créditer une cagnote.
     * 
     * @param int $id Id de l'item dont la cagnote doit être créditée.
     */
    public function crediterCagnote($id) {

        $app = \Slim\Slim::getInstance();
        $montant = $app->request()->post('contribution');


        $item = Item::where('id','=',$id)->first();
        if ($item->cagnote+$montant>=$item->cagnote) { 
            $item->cagnote += $montant;
        }
        $item->save();


        $v = new VueModification();
        $v->renderCagnote($item);   
    }
}