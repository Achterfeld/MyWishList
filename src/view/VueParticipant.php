
<?php

namespaces\mywishlist\view;

define("ALL_ITEM_VIEW", 1);
define("ITEM_VIEW", 2);
define("ALL_LIST_VIEW", 3);
define("LIST_VIEW", 4);

class VueParticipant
{


	private $liste;

	function __construct($l)
	{
		$this->liste = $l;
	}

	private function afficheListeListe()
	{
		$affiche = "<section>";
		foreach ($this->listes as $liste) {
			$affiche .= "$liste<br>";
		}
		$affiche .= "</section>";

		return $affiche;
	}

	private function afficheListe()
	{
		$affiche = "<section>";
		foreach ($this->listes as $liste) {
			$affiche .= $liste;
		}
		$affiche .= "</section>";

		return $affiche;
	}



	private function afficheItem()
	{
		return "<section>$this->liste[0]</section>";
	}

	public function render($code)
	{
		$Fragment = "";
		switch ($code) {

			case ALL_ITEM_VIEW:
				$Fragment = $this->afficheListeListe();
				break;
			case ITEM_VIEW:
				$Fragment = $this->afficheListe();
				break;
			case ALL_LIST_VIEW:
				$Fragment = $this->afficheItem();
				break;
				//LIST_VIEW
			default:
				# code...
				break;
		}
		$html = <<<END 
<head>
<meta charset="utf-8">
<meta name="robots" content="noindex,nofollow">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="./img/favicon.ico" type="image/x-icon"><link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="/MyWishList/style/style.css">
<title>My Wish List</title>
</head>

<div id="navBarre"> 
<div>Bonjour, bienvenue dans MyWishList</div>
<div style="flex:1"></div>
<div><a href="./" >Se connecter</a></div>
<div><a href="./" >S\'inscrire</a></div>
</div>
END;

echo $html;


	}
}
?>
