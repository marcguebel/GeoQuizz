<?php
require_once "../src/vendor/autoload.php";
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$config = ['settings' => [
    'determineRouteBeforeAppMiddleware' => true,
    'displayErrorDetails' => true,
    'addContentLengthHeader' => false
]];

$app = new \Slim\App($config);

$c = $app->getContainer();

//Préparation des réponses de l'api (codes + message)

//code 200, ok
$c['ok'] = function ($c) {
    $response = $c->response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(200); 
    return $response;
};

//code 201, ressource créée
$c['created'] = function ($c) {
    $response = $c->response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(201); 
    return $response;
};

//code 204, ok sans retour
$c['noContent'] = function ($c) {
    $response = $c->response->withStatus(204);
    return $response;
};

//code 401, problème avec l'authentification
$c['unauthorized'] = function ($c) {
    $response = $c->response->withHeader('Content-type', "text/html")->withStatus(401);
    $response->getBody()->write("Unauthorized");
    return $response;
};

//code 401, header Authorization absent ou faux
$c['noHeader'] = function ($c) {
    $response = $c->response->withHeader('Content-type', "text/html")->withStatus(401);
    $response->getBody()->write("Header authorization missing or wrong");
    return $response;
};

//code 404, ressource non trouvée
$c['notFound'] = function ($c) {
    $response = $c->response->withHeader('Content-type', "text/html")->withStatus(404);
    $response->getBody()->write("Page not found");
    return $response;
};

//controller dans le container pour les routes
$c["Controller"] = function($c){
    return new \backend\api\controller\Controller($c);
};

//eloquent
$db = new Illuminate\Database\Capsule\Manager();
$db->addConnection(parse_ini_file("conf/conf.ini"));
$db->setAsGlobal();
$db->bootEloquent();

//récupération des routes
require __DIR__."/routes.php";

$app->run();