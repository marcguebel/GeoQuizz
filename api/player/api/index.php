<?php
require_once "../src/vendor/autoload.php";
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \api\player\api\controller\Controller as Controller;

$config = ['settings' => [
    'determineRouteBeforeAppMiddleware' => true,
    'displayErrorDetails' => true,
    'addContentLengthHeader' => false,
    /*'db' => [
        'driver' => 'mysql',
        'host' => 'db',
        'database' => 'geoquizz',
        'username' => 'geoquizz',
        'password' => 'geoquizz',
        'charset'   => 'utf8',
        'collation' => 'utf8_general_ci'
    ]*/
]];

$app = new \Slim\App($config);

$c = $app->getContainer();

$container["notFoundHandler"] = function ($c) {
    return function ($request, $response) use ($c) {
        throw new Exception("Api Not Found", 404);
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

$app->post('/game/new[/]', function (Request $request, Response $response, array $args) {
    $controller = new Controller($this);
    return $controller->newGame($request, $response, $args);
});

$app->put('/game/score[/]', function (Request $request, Response $response, array $args) {
    $controller = new Controller($this);
    return $controller->score($request, $response, $args);
});

$app->get('/game/leaderboard/{id}/{niveau}[/]', function (Request $request, Response $response, array $args) {
    $controller = new Controller($this);
    return $controller->leaderboard($request, $response, $args);
});

/*$app->get('/game/test[/]', function (Request $request, Response $response, array $args) {
    $controller = new Controller($this);
    return $controller->test($request, $response, $args);
});*/

$app->run();