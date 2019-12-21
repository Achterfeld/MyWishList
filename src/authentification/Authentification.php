<?php
namespace wishlist\authentification;

use wishlist\model\User;

class Authentification {

	public static function createUser($prenom, $password, $password2, $mail) {
		
		$prenom = filter_var($prenom,FILTER_SANITIZE_SPECIAL_CHARS);
		$password = filter_var($password,FILTER_SANITIZE_SPECIAL_CHARS);
		$password2 = filter_var($password2,FILTER_SANITIZE_SPECIAL_CHARS);
		$mail = filter_var($mail,FILTER_SANITIZE_SPECIAL_CHARS);

		$u = new User();
		$hash1 = password_hash($password, PASSWORD_DEFAULT, ['cost'=> 12]);
    
        if (password_verify($password2,$hash1)) {
			$u->prenom=$prenom;
			$u->mail=$mail;
        	$u->hash = $hash1;
        	$u->droit = 2;
            $u->save();
        }
        else 
        	throw new AuthException;
        	
	}

	public static function loadProfile($user_id) {
		$u = User::where('user_id','=',$user_id)->first();

		if (isset($_SESSION['session']))
			unset($_SESSION['session']);
		if (!is_null($u)) {

			$_SESSION['session']['eMail'] = $u->mail;
			$_SESSION['session']['prenom'] = $u->prenom;
			$_SESSION['session']['user_id'] = $u->user_id;
			$_SESSION['session']['niveauDeDroit'] = $u->droit;
		}
	}

	public static function authenticate($mail, $password) {

		$mail = filter_var($mail,FILTER_SANITIZE_SPECIAL_CHARS);
		$password = filter_var($password,FILTER_SANITIZE_SPECIAL_CHARS);

		$u = User::where('mail','=',$mail)->first();
		if (password_verify($password,$u->hash)) {
			Authentification::loadProfile($u->user_id);
        }
        else 
        	throw new AuthException;
	}

	public static  function checkAccesRights ($r) {
		if ($_SESSION['session']['niveauDeDroit'] < $r) {
			throw new AuthException;
		}
	}
}
?>