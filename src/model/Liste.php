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

        $app = \Slim\Slim::getInstance();
        $public = $this->public ? "<span class='public'>🌎 publique" : "<span class='priv'>🔒 privée";

        $possede = isset($this->possede()->first()->prenom) ? $this->possede()->first()->prenom : "Invité";

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

            $uID = $this->user_id;

            $reserv = "";





            if (isset($_COOKIE['user_id'])) {
                if ($_COOKIE['user_id'] != $uID) {
                    $reserv = !is_null($value->reservation) ? "✔️" : "❌";
                } else {
                    date_default_timezone_set('Europe/Paris');
                    $date = date('m/d/Y h:i:s a', time());

                    if (strtotime($this->expiration) - strtotime($date) < 0) {
                        $reserv .= !is_null($value->reservation) ? "✔️" : "❌";
                    } else {
                        $reserv .= "";
                    }
                }
            } else {
                $reserv = !is_null($value->reservation) ? "✔️" : "❌";
            }

            $urlItemReservation = $app->urlFor('route_get_itemReservation',['idItem'=>$value->id]);


            $str .= "<li><a class='lienSCouleur' href='$urlItemReservation'>$value->nom $reserv</a></li> ";
        }
        $str .= "</ul></div>";





        $auteur = isset($_SESSION['session']) ? $_SESSION['session']['prenom'] : "''";

        $urlAjoutMessage = $app->urlFor('route_ajoutMessage',['no'=>$this->no,'token_visu'=>$this->token_visu]);

        $str .= <<<END

        <div style="margin: 1em;">
            <form class="formulaire" method="post" action="$urlAjoutMessage">
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
