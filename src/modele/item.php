<?php
namespace modele;
class Item extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'item';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function liste() {
    	return $this->belongsTo('\modele\Liste', 'liste_id');
    }
}
