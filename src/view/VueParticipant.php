
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

END;
	}

}
?>
