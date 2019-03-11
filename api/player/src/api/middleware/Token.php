<?php
namespace api\player\api\middleware;
class Token{
	public static function new(){
		$bin = random_bytes(32);
		$token = bin2hex($bin);
		return $token;
	}
}