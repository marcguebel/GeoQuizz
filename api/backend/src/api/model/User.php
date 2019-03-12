<?php
namespace api\backend\api\model;

class User extends \Illuminate\Database\Eloquent\Model{
	protected $table = "user";
	protected $primaryKey = "id";
	public $timestamps = false;
}