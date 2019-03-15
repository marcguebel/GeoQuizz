<?php
require_once "../src/vendor/autoload.php";
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \player\api\controller\Controller as Controller;

$config = ['settings' => [
    'determineRouteBeforeAppMiddleware' => true,
    'displayErrorDetails' => true,
    'addContentLengthHeader' => false
]];

$app = new \Slim\App($config);

$c = $app->getContainer();

$c['ok'] = function ($c) {
    $response = $c->response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(200);  
    return $response;
};

$c['created'] = function ($c) {
    $response = $c->response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(201);  
    return $response;
};

$c['noContent'] = function ($c) {
    $response = $c->response->withStatus(204);
    return $response;
};

$c['notFound'] = function ($c) {
    $response = $c->response->withHeader('Content-type', "text/html")->withStatus(404);
    $response->getBody()->write("Page not found");
    return $response;
};

$c["Controller"] = function($c){
    return new Controller($c);
};

$db = new Illuminate\Database\Capsule\Manager();
$db->addConnection(parse_ini_file("conf/conf.ini"));
$db->setAsGlobal();
$db->bootEloquent();

require __DIR__."/routes.php";

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT');
});

$app->run();