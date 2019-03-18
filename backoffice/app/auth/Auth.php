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
		$response = json_decode($curlResponse->response);
		if(!$curlResponse->error){
			if($response != null){
				$_SESSION["user"] = $response->user;
				return true;
			}
			return 503;
		}
		return false;
	}

	public function check(){
		return isset($_SESSION["user"]);
	}

	public function user(){
		return $_SESSION["user"];
	}

	public function logout(){
		unset($_SESSION["user"]);
	}
}