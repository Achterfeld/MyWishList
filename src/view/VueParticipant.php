
<?php 

namespaces \mywishlist\view;

class VueParticipant 
{
	private $liste;

    function __construct($l)
	{
		$this->liste = $l;
	}

	private function htmlListeListes()
	{
		$html = "<section>";
		foreach ($item as $this->liste) {
			$html .= $item."<br>"
		}
		return $html."</section>";
	}

}
?>
