<?php
namespace player\api\utils;
class Token{

	//création token
	public static function new(){
		$bin = random_bytes(32);
		$token = bin2hex($bin);
		return $token;
	}
}