<?php

namespace wishlist\authentification;

use wishlist\model\User;
use wishlist\exception\AuthException;

class Authentification
{

	const Insertion_OK = 0;
	const Pb_MDP = 1;
	const Pb_Mail = 2;

	/**
	 * Fonction permettant de créer un utilisateur.
	 *
	 * La fonction est en static car elle est utilisé dans plusieurs classes.
	 * Cette fonction permet de créer un nouvel utilisateur. Les paramètres sont filtrer par php pour éviter tous les problèmes.
	 * @param string $prenom Le prenom de l'utilisateur.
	 * @param string $password Le password de l'utilisateur.
	 * @param string $password2 Une nouvelle fois le password de l'utilisateur pour pouvoir vérifier qu'il n'y a pas d'erreur. 
	 * @param string $mail L'email de l'utilisateur.
	 * @return int Retourne un code permettant d'identifier si il y a un problème ou non.
	 */

	public static function createUser($prenom, $password, $password2, $mail)
	{

		$prenom = filter_var($prenom, FILTER_SANITIZE_SPECIAL_CHARS);
		$password = filter_var($password, FILTER_SANITIZE_SPECIAL_CHARS);
		$password2 = filter_var($password2, FILTER_SANITIZE_SPECIAL_CHARS);
		$mail = filter_var($mail, FILTER_SANITIZE_SPECIAL_CHARS);

		$u = User::where("mail", "=", $mail)->first();

		if (!$u) {

			$u = new User();
			$hash1 = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);

			if (password_verify($password2, $hash1)) {
				$u->prenom = $prenom;
				$u->mail = $mail;
				$u->hash = $hash1;
				$u->droit = 2;
				$u->save();
				return self::Insertion_OK;
			} else {
				//				echo "La confirmation du mot de passe n'est pas bonne (erreur 1)";
				return self::Pb_MDP;
				//			throw new AuthException;
			}
		} else {
			return self::Pb_Mail;
		}
	}


	/**
	 * La fonction permet de charger un profil.
	 *
	 * La fonction est en static car elle est utilisé dans plusieurs classes.
	 * @param int $user_id L'identifiant de l'utilisateur.
	 */
	public static function loadProfile($user_id)
	{
		$u = User::where('user_id', '=', $user_id)->first();

		if (isset($_SESSION['session']))
			unset($_SESSION['session']);

		if (!is_null($u)) {

			$_SESSION['session']['eMail'] = $u->mail;
			$_SESSION['session']['prenom'] = $u->prenom;
			$_SESSION['session']['user_id'] = $u->user_id;
			$_SESSION['session']['niveauDeDroit'] = $u->droit;
		}

		setcookie("user_id", $u->user_id, time() + 60 * 60 * 24 * 2, "/");
	}

	/**
	 * La fonction permet de s'authentifier.
	 * 
	 * La fonction est en static car elle est utlisié dans plusieurs classes. 
	 * @param string $mail Email de l'utilisateur.
	 * @param string $password Mot de passe de l'utilisateur.
	 */
	public static function authenticate($mail, $password)
	{

		$mail = filter_var($mail, FILTER_SANITIZE_SPECIAL_CHARS);
		$password = filter_var($password, FILTER_SANITIZE_SPECIAL_CHARS);

		$u = User::where('mail', '=', $mail)->first();
		if (!is_null($u)) {

			if (password_verify($password, $u->hash)) {
				Authentification::loadProfile($u->user_id);
			} else {
				echo "<p class='error'>Le mot de passe n'est pas bon</p>";
				//				throw new AuthException;
			}
		}
	}


	/**
	 * La fonction permet de verifier les droits.
	 * 
	 * La fonction est en static car elle est utlisié dans plusieurs classes. 
	 * @param int $r Droit à vérifier.
	 */
	public static  function checkAccesRights($r)
	{
		if ($_SESSION['session']['niveauDeDroit'] < $r) {
			echo "<p class='error'>Problème de droits</p>";
			//			throw new AuthException;
		}
	}

	/**
	 * La fonction permet de se déconnecter.
	 * 
	 * La fonction est en static car elle est utlisié dans plusieurs classes. 
	 */
	public static function disconnect()
	{
		if (isset($_SESSION['session'])) {
			unset($_SESSION['session']);
		}
	}
}
