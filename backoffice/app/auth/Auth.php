<?php
namespace Backoffice\auth;

class Auth{
	public function attempt($login, $password){
		$curl = new \Curl\Curl();
		$body = [
			"login" => $login,
			"password" => $password		
		];
		$curlResponse = $curl->post('backend-lmaillard.pagekite.me/login', json_encode($body));
		if(json_decode($curlResponse->response)->type == "Error"){
			return false;
		}
		if(json_decode($curlResponse->response)->type == "Resource"){
			$_SESSION["user"] = json_decode($curlResponse->response)->user->id;	
			return true;
		}
		return false;
	}

	public function check(){
		return isset($_SESSION["user"]);
	}

	public function user(){
		
	}
}