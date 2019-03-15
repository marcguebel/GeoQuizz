<?php
use Respect\Validation\Validator as v;
session_start();
require __DIR__."/../vendor/autoload.php";

$app = new \Slim\App([
	"settings" => [
		"displayErrorDetails" => true
	]
]);

$container = $app->getContainer();

$container["auth"] = function($container){
	return new \Backoffice\Auth\Auth;
};

$container["view"] = function($container){
	$view = new \Slim\Views\Twig(__DIR__."/../resources/views/", [
		"cache" => false
	]);
	$view->addExtension(new \Slim\Views\TwigExtension(
		$container->router,
		$container->request->getUri()
	));
	$view->getEnvironment()->addGlobal("auth", $container->auth);
	return $view;
};

$container["validator"] = function($container){
	return new \Backoffice\validation\Validator;
};

$container["HomeController"] = function($container){
	return new \Backoffice\Controllers\HomeController($container);
};
$container["AuthController"] = function($container){
	return new \Backoffice\Controllers\Auth\AuthController($container);
};

$container["csrf"] = function($container){
	return new \Slim\Csrf\Guard;
};

$app->add(new \Backoffice\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \Backoffice\Middleware\OldInputMiddleware($container));
$app->add(new \Backoffice\Middleware\CsrfMiddleware($container));

$app->add($container->csrf);

v::with("\\Backoffice\\validation\\rules");

require __DIR__."/../app/routes.php";