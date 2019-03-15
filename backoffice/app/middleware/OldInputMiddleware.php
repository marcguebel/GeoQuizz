<?php
namespace Backoffice\middleware;
error_reporting (E_ALL ^ E_NOTICE);

class OldInputMiddleware extends Middleware{
	public function __invoke($request, $response, $next){
		$this->container->view->getEnvironment()->addGlobal("old", $_SESSION["old"]);
		$_SESSION["old"] = $request->getParams();
		$response = $next($request, $response);
		return $response;
	}
}