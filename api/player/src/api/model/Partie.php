<?php
namespace api\player\api\model;

class Partie extends \Illuminate\Database\Eloquent\Model{
	protected $table = "partie";
	protected $primaryKey = "id";
	public $timestamps = false;
	public $incrementing = false;
	public static $created = 0;
	public static $finished = 1;

	public function serie(){
		return $this->hasOne("api\player\api\model\Serie", "id", "idSerie");
	}
}