<?php

namespace wishlist\model;

class Liste extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'liste';
    protected $primaryKey = 'no';
    public $timestamps = false;

    public function item()
    {
        return $this->hasMany('wishlist\model\Item', 'liste_id');
    }

    public function messages()
    {
        return $this->hasMany('wishlist\model\MessagesListes', 'liste_id');
    }

    public function possede()
    {
        return $this->belongsTo('wishlist\model\User', 'user_id');
    }


    public function __toString()
    {

        $public = $this->public ? "<span class='public'>🌎 publique" : "<span class='priv'>🔒 privée";

        $possede = $this->possede()->first()->prenom;

        $str = <<<END

        <div class='list'>
        <div class='num num_liste'>$this->no</div>
        <h3>$this->titre : $this->description </h3><br>
        <div>Créateur de la liste : $possede</div><br>
        <div>⌛ Expire le $this->expiration</div><br><br>
        <div>Visibilité : $public</div></span><br><br>

END;
        /*|token $this->token " ;*/

        $itDedans = $this->item()->get();
        $str .= "<ul>";
        foreach ($itDedans as $key => $value) {

            $reserv = !is_null($value->reservation) ? "✔️" : "❌";

            $str .= "<li><a class='lienSCouleur' href='/myWishList/item/reservation/$value->id'>$value->nom $reserv</a></li> ";
        }
        $str .= "</ul></div>";





        $auteur = isset($_SESSION['session']) ? $_SESSION['session']['prenom'] : "''";


        $str .= <<<END

        <div style="margin: 1em;">
            <form class="formulaire" method="post" action="/myWishList/ajout/message/$this->no/$this->token">
                <div>Ajouter un message :</div>
                <input type="text" name="auteur" placeholder="Votre nom" value=$auteur><br>
                <input type="text" name="message" placeholder="Votre message pour l'organisateur" ><br>
                <input type="submit" value="Ajoutez votre message" ></input><br>
            </form>
        </div>


END;

        $mess = $this->messages()->get();

        foreach ($mess as $key => $value) {
            $str .= <<<END
            <div class="messageListe">
                <p><h1>$value->auteur : </h1><br>“ $value->message ”</p>
            </div>
END;
        }



        return $str;
    }
}
