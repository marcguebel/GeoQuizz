<?php
namespace Backoffice\Auth;

class Auth{
	public function attempt($login, $password){
		$curl = new \Curl\Curl();
		$body = [
			"login" => $login,
			"password" => $password		
		];
		$curl->setOpt(CURLOPT_NOPROXY, "api.backend.local");
		$curlResponse = $curl->post('api.backend.local/login', json_encode($body));
		$response = json_decode($curlResponse->response);
		if(!$curlResponse->error){
			$_SESSION["user"] = $response->user;
			foreach($curlResponse->response_headers as $key => $value){
				$header = explode(": ", $value);
				if($header[0] == "Authorization"){
					$_SESSION["token"] = explode(" ", $header[1])[1];
				}
			}
			return true;
		}
		return false;
	}

	public function check(){
		if(isset($_SESSION["user"]) && isset($_SESSION["token"])){
			return true;
		}
		return false;
	}

	public function user(){
		return $_SESSION["user"];
	}

	public function logout(){
		unset($_SESSION["user"]);
	}
}