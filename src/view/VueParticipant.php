
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

	private function htmlListesItems()
	{
		$html = "<section>";
		foreach ($obj as $this->liste) {
			$html .= $obj."<br>"
			foreach ($item as $obj) {
				$html .= $item."<br>"
			}
		}
		return $html."</section>";
	}

	private function htmlItem()
	{
		
		return "<section>$this->liste</section>";
	}

}
?>
