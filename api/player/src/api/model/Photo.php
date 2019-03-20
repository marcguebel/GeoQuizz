<?php
namespace player\api\model;

class Photo extends \Illuminate\Database\Eloquent\Model{
	protected $table = "photo";
	protected $primaryKey = "id";
	public $timestamps = false;
}