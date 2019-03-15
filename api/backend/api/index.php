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

$app->get('/photos[/]', function (Request $request, Response $response, array $args) {
    $controller = new Controller($this);
    return $controller->photos($request, $response, $args);
});

$app->get('/photos/{id}[/]', function (Request $request, Response $response, array $args) {
    $controller = new Controller($this);
    return $controller->photo($request, $response, $args);
});

$app->post('/photos[/]', function (Request $request, Response $response, array $args) {
    $controller = new Controller($this);
    return $controller->newPhoto($request, $response, $args);
});

$app->put('/photos/{id}[/]', function (Request $request, Response $response, array $args) {
    $controller = new Controller($this);
    return $controller->updatePhoto($request, $response, $args);
});

$app->get('/series[/]', function (Request $request, Response $response, array $args) {
    $controller = new Controller($this);
    return $controller->series($request, $response, $args);
});

$app->get('/series/{id}[/]', function (Request $request, Response $response, array $args) {
    $controller = new Controller($this);
    return $controller->serie($request, $response, $args);
});

$app->put('/series/{id}[/]', function (Request $request, Response $response, array $args) {
    $controller = new Controller($this);
    return $controller->updateSerie($request, $response, $args);
});

$app->post('/series/{serie}/add/{photo}[/]', function (Request $request, Response $response, array $args) {
    $controller = new Controller($this);
    return $controller->addPhotoSerie($request, $response, $args);
});

$app->delete('/series/{serie}/remove/{photo}[/]', function (Request $request, Response $response, array $args) {
    $controller = new Controller($this);
    return $controller->removePhotoSerie($request, $response, $args);
});

$app->post('/register[/]', function (Request $request, Response $response, array $args) {
    $controller = new Controller($this);
    return $controller->register($request, $response, $args);
});

$app->get('/checkLogin/{login}[/]', function (Request $request, Response $response, array $args) {
    $controller = new Controller($this);
    return $controller->checkLogin($request, $response, $args);
});

$app->post('/login[/]', function (Request $request, Response $response, array $args) {
    $controller = new Controller($this);
    return $controller->login($request, $response, $args);
});

$app->get('/doc[/]', function (Request $request, Response $response, array $args) {
    $controller = new Controller($this);
    return $controller->doc($request, $response, $args);
});

$app->run();