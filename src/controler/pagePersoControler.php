<?php

namespace wishlist\controler;

use \Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\Liste;
use wishlist\model\Item;
use wishlist\model\User;
use wishlist\model\MessagesListes;
use wishlist\view\VuePagePerso;
use wishlist\authentification\Authentification;
use wishlist\exception\AuthException;
use wishlist\view\VueConfirmation;

class pagePersoControler
{

    /**
     * Fonction permettant de rendre la page de confirmation de suppression. 
     *
     */
	public function confirmerSuppr()
	{
		$v = new VueConfirmation();
		$v->render();
	}

    /**
     * Fonction permettant de rendre la page personnelle de l'utilisateur. 
     *
     */
	public function getPPerso()
	{

		if (isset($_SESSION['session'])) {

			$u = User::where('user_id', '=', $_SESSION['session']['user_id'])->first();
			$v = new vuePagePerso();
			$v->render($u);
		} else {
			$c = new IdentifiantControler();
			$c->getConnexion();
		}
	}

    /**
     * Fonction permettant de rendre la page personnelle de l'utilisateur si l'authentification est ok. 
     *
     */
	public function connexion()
	{
		try {
			$app = new \Slim\Slim;
			$datas = $app->request();

			$mail = filter_var($datas->post("Mail"),FILTER_SANITIZE_SPECIAL_CHARS);
			$pass = filter_var($datas->post("Passe"),FILTER_SANITIZE_SPECIAL_CHARS);


			Authentification::authenticate($mail, $pass);

			$this->getPPerso();
		} catch (AuthException $ae) {

			echo "Email ou mot de passe invalide<br>";
		}
	}

    /**
     * Fonction permettant de supprimer un compte.
     * 
     * La fonction permet de supprimer un compte, ainsi que tout ce qui lui est relié. 
     * Les items sont supprimés.
     * Les message sont supprimés.
     * Les listes sont supprimées.
     * Pour finir l'utilisateur est supprimé.
     * On fini par rendre la page de confirmation de suppression de compte. 
     *
     */
	public function supprimerCompte()
	{

		if (isset($_SESSION['session'])) {

			//destruction dans la table user de la ligne de l'utilisateur
			$u = User::where('user_id', '=', $_SESSION['session']['user_id'])->first();

			$l = $u->listes()->get();

			foreach ($l as $value) {
				$i = $value->item()->get();
				$m = $value->messages()->get();
				foreach ($i as $item) {
					$item->delete();
				}
				foreach ($m as $message) {
					$message->delete();
				}
				$value->delete();
			}
			$u->delete();
		}
		Authentification::disconnect();
		$v = new VuePagePerso();
		$v->compteSupprimer();
	}

    /**
     * Fonction permettant de mettre à jour le profil de l'utilisateur. 
     *
     * La fonction commence par récupérer l'utilisateur connecté.
     * Si le nom d'utilisateur change alors le tuple est mis à jour.
     * Si le mot de passe change alors le tuple est mis à jour.
     * Si une photo est uploadé alors le tuple est mis à jour.
     * La page de confirmation de modification est rendue.
     *
     */
	public function modifProfile()
	{

		$app = new \Slim\Slim;
		$u = User::where('user_id', '=', $_SESSION['session']['user_id'])->first();

		$modif = VuePagePerso::PAGE_PERSO;

		$datas = $app->request();

		$target_dir = "img/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		if($datas->post("uploadedfile" !== null)) {
		    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		    if($check !== false) {
		        echo "File is an image - " . $check["mime"] . ".";
		        $uploadOk = 1;
		    } else {
		        echo "File is not an image.";
		        $uploadOk = 0;
		    }
		}
		// Check if file already exists
		if (file_exists($target_file)) {
		    echo "Sorry, file already exists.";
		    $uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
		    echo "Sorry, your file is too large.";
		    $uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		    } else {
		        echo "Sorry, there was an error uploading your file.";
		    }
		}

		$prenom = $datas->post("Prenom");
		if ($prenom != $u->prenom) {
			$prenom = filter_var($prenom, FILTER_SANITIZE_SPECIAL_CHARS);
			$u->prenom = $prenom;

			$_SESSION['session']['prenom'] = $prenom;

			$u->save();
		}

		$pass1 = $datas->post("Passe1");
		$pass2 = $datas->post("Passe2");
		if ($pass1 != "" && $pass2 != "") {
			$pass1 = filter_var($pass1, FILTER_SANITIZE_SPECIAL_CHARS);
			$pass2 = filter_var($pass2, FILTER_SANITIZE_SPECIAL_CHARS);
			if ($pass1 == $pass2) {
				$u->hash = password_hash($pass1, PASSWORD_DEFAULT, ['cost' => 12]);

				Authentification::disconnect();

				$modif = VuePagePerso::RECONNEXION;
			}
		}

		ItemControler::ajoutImg($u);
		$u->save();

		$v = new VuePagePerso();
		$v->confirmation($modif);
	}


    /**
     * Fonction permettant d'afficher tous les créateurs (ayant au moins 1 liste en publique). 
     *
     * La fonction commence par récupérer les utilisateurs ayant une liste en publique.
     * Elle créée une liste de tous ces utilisateurs.
     * Elle rend la liste des créateurs.
     *
     */
	public function allCreateur() {

		$lCreateur = array();

		$lListe = Liste::where('public', '=', 1)->distinct()->get();

		foreach ($lListe as $liste) {
			$user = User::where('user_id','=',$liste->user_id)->first();
			if (!is_null($user)) {
				$lCreateur[] = $user;
			}
		}

		$v = new VuePagePerso();
		$v->afficherCreateur($lCreateur);
	}
}