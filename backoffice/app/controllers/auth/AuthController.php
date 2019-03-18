<?php
namespace Backoffice\controllers\auth;
use Backoffice\controllers\Controller;
use Respect\Validation\Validator as v;

class AuthController extends Controller{
	public function getSignOut($request, $response){
		$this->auth->logout();
		return $response->withRedirect($this->router->pathFor("auth.signin"));	
	}

	public function getSignUp($request, $response){
		return $this->view->render($response, "auth/signup.twig");
	}

	public function postSignUp($request, $response){
		$validation = $this->validator->validate($request, [
			"login" => v::noWhitespace()->notEmpty()->loginAvailable(),
			"password" => v::noWhitespace()->notEmpty()
		]);
		if($validation->failed()){
			return $response->withRedirect($this->router->pathFor("auth.signup"));
		}
		$curl = new \Curl\Curl();
		$post = $request->getParams();
		$body = [
			"login" => $post["login"],
			"password" => $post["password"]		
		];
		$curlResponse = $curl->post($this->baseUrl."/register", json_encode($body));
		$this->flash->addMessage("info", "Inscription réussie");
		$this->auth->attempt($post["login"], $post["password"]);
		return $response->withRedirect($this->router->pathFor("home"));	
	}

	public function getSignIn($request, $response){
		return $this->view->render($response, "auth/signin.twig");
	}

	public function postSignIn($request, $response){
		$auth = $this->auth->attempt($request->getParam("login"), $request->getParam("password"));
		if(!$auth){
			$this->flash->addMessage("error", "Login ou mot de passe erroné");
			return $response->withRedirect($this->router->pathFor("auth.signin"));
		}
		if($auth == 503){
			$this->flash->addMessage("error", "Service indisponible");
			return $response->withRedirect($this->router->pathFor("auth.signin"));
		}
		return $response->withRedirect($this->router->pathFor("home"));
	}
}