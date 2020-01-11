<?php

namespace wishlist\model;

class MessagesListes extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'messagesListes';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * Fonction permettant de retourner la liste pour laquelle ce message a été posté.
     *
     * @return Liste Liste en question.
     */
    public function listes()
    {
        return $this->belongsTo('wishlist\model\Liste', 'liste_id');
    }
}
