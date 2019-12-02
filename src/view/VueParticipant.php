
<?php

namespaces \mywishlist\view;
define(ALL_LIST, 1);
define(ALL_LIST_ITEMS, 2);
define(ITEM, 3);

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

	public function htmlAll($selecter)
	{
		switch ($selecter) {
			case 1:
				$content = $this->htmlListeListes;
				break;
			case 2:
				$content = $this->htmlListesItems;
				break;
			case 3:
				$content = $this->htmlItem;
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
