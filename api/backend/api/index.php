<?php
require_once "../src/vendor/autoload.php";
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \api\backend\api\controller\Controller as Controller;

$config = ['settings' => [
    'determineRouteBeforeAppMiddleware' => true,
    'displayErrorDetails' => true,
    'addContentLengthHeader' => false
]];

$app = new \Slim\App($config);

$c = $app->getContainer();

$container["notFoundHandler"] = function ($c) {
    return function ($request, $response) use ($c) {
        throw new Exception("Ressource Not Found", 404);
    };
};

$container["notAllowedHandler"] = function ($c) {
    return function ($request, $response) use ($c) {
        throw new Exception("Method Not Allowed", 405);
    };
};

$db = new Illuminate\Database\Capsule\Manager();
$db->addConnection(parse_ini_file("conf/conf.ini"));
$db->setAsGlobal();
$db->bootEloquent();

$app->post('/photos[/]', function (Request $request, Response $response, array $args) {
    $controller = new Controller($this);
    return $controller->newPhoto($request, $response, $args);
});

$app->run();