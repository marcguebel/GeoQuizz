<?php
namespace player\api\model;

class Partie extends \Illuminate\Database\Eloquent\Model{
	protected $table = "partie";
	protected $primaryKey = "id";
	public $timestamps = false;
	public $incrementing = false;
	public static $status = [
		"created" => 0,
		"ingame" => 1,
		"finished" => 2,
		"leaderboard" => 3
	];

	public function serie(){
		return $this->hasOne("api\player\api\model\Serie", "id", "idSerie");
	}
}