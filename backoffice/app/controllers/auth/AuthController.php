<?php
namespace Backoffice\controllers\auth;
use Backoffice\controllers\Controller;
use Respect\Validation\Validator as v;

class AuthController extends Controller{
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
		$curlResponse = $curl->post('backend-lmaillard.pagekite.me/register', json_encode($body));
		return $response->withRedirect($this->router->pathFor("home"));	
	}

	public function getSignIn($request, $response){
		return $this->view->render($response, "auth/signin.twig");
	}

	public function postSignIn($request, $response){
		$auth = $this->auth->attempt($request->getParam("login"), $request->getParam("password"));
		if(!$auth){
			return $response->withRedirect($this->router->pathFor("auth.signin"));
		}
		return $response->withRedirect($this->router->pathFor("home"));
	}
}