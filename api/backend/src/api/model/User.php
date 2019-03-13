<?php
namespace api\backend\api\model;

class User extends \Illuminate\Database\Eloquent\Model{
	protected $table = "user";
	protected $primaryKey = "id";
	public $incrementing = false;
	public $timestamps = false;
}