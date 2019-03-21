<?php 
use Firebase\JWT\JWT;
namespace backend\api\utils;
class TokenJWT{

	//création token JWT, valide 1h
	public static function new($data){
		$token = \Firebase\JWT\JWT::encode([
			'iss' => 'http://backend-lmaillard.pagekite.me/',
			'aud' => 'http://backend-lmaillard.pagekite.me/',
			'iat' => time(),
			'exp' => time()+3600, 
			'data' => $data 
		], getenv("secretJWT")); 
		return $token; 
	} 

	//décode le token JWT
	public static function decode($jwt){
		try{ 
			return \Firebase\JWT\JWT::decode($jwt, getenv("secretJWT"), array('HS256')); 
		} 
		catch(\Exception $e){ 
			return false; 
		}
	}

	//vérification présence du token et le renvoi décodé
	public static function check($request){
		try{ 
			$authorization = $request->getHeader("Authorization");
			$tokenJWT = explode(" ", $authorization[0])[1];
			return TokenJWT::decode($tokenJWT);
		} 
		catch(\Exception $e){ 
			return false; 
		}
	}
}