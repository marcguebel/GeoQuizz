<?php
namespace player\api\model;

class Serie extends \Illuminate\Database\Eloquent\Model{
	protected $table = "serie";
	protected $primaryKey = "id";
	public $timestamps = false;

	public function photos(){
		return $this->belongsToMany("player\api\model\Photo", "serie_photo", "idSerie", "idPhoto");
	}
}