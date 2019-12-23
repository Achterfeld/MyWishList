<?php

namespace wishlist\model;

class MessagesListes extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'messagesListes';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function listes()
    {
        return $this->belongsTo('wishlist\model\Liste', 'liste_id');
    }
}
