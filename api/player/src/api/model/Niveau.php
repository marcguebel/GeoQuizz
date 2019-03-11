<?php
namespace api\player\api\model;

class Niveau extends \Illuminate\Database\Eloquent\Model{
	protected $table = "niveau";
	protected $primaryKey = "id";
	public $timestamps = false;
}