<?php

namespace wishlist\model;

class Item extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'item';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function liste()
    {
        return $this->belongsTo('wishlist\model\Liste', 'liste_id');
    }

    public function __toString()
    {
        
        $app = \Slim\Slim::getInstance();
        $rootUri = $app->request->getRootUri();
        $itemUrl = "";
        $url = $rootUri . $itemUrl;

        $str = <<<END
        <div class='item'>
            <div class='itemBg'>
                <img src="$url/img/$this->img"></img>
            </div>
            <div class='itemContent'>
                <div class='num num_item'> $this->id </div>
                <div class='description'>
END;

        if (is_null($this->liste()->first())) {

            $str .= "Pas de liste pour l'item";
        } else {

            $str .= "<h2>" . $this->liste()->first()['titre'] . "</h2>";
        }

        $str .= "<br>
                    <h4>$this->nom : $this->descr </h4><br>";

        $str .= $this->url != "" ? "<a class='lienSCouleur' href='$this->url' >Infos supplémentaires</a>" : "";

        
        $str .= "
                    <div class='prix'>$this->tarif</div>
                </div>
                <div class='crop'>
                    <img src='$url/img/$this->img'></img> 
                </div>
            </div>
        </div>";

        return $str;
    }
}
