<?php 
use Firebase\JWT\JWT;
namespace backend\api\utils;
class TokenJWT{
	public static function new($id){
		$token = \Firebase\JWT\JWT::encode([
			'iss' => 'http://backend-lmaillard.pagekite.me/',
			'aud' => 'http://backend-lmaillard.pagekite.me/',
			'iat' => time(),
			'exp' => time()+3600, 
			'id' => $id 
		], getenv("secretJWT")); 
		return $token; 
	} 

	public static function decode($jwt){
		try{ 
			return \Firebase\JWT\JWT::decode($jwt, getenv("secretJWT"), array('HS256')); 
		} 
		catch(\Exception $e){ 
			return false; 
		} 
	} 
}