<?php
namespace api\backend\api\controller;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \api\backend\api\model\Serie as Serie;
use \api\backend\api\model\Photo as Photo;
use \api\backend\api\model\Serie_photo as Serie_photo;
use \api\backend\api\model\User as User;
use \api\backend\api\model\Niveau as Niveau;
use \api\backend\api\middleware\Token as Token;

class Controller{
	private $container;
	public function __construct(\Slim\Container $container){
		$this->container = $container;
	}

	/*public function score(Request $request, Response $response, array $args){
		try{
			$body = json_decode($request->getBody());
			$partie = Partie::find($request->getHeader("X-geoquizz")[0])->first();
			$partie->status = Partie::$finished;
			$partie->score = $body->score;
			$partie->save();
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(204);	
			return $response;
		}
		catch(\Exception $e){
			$data = [
				"type" => "Error",
				"error" => "404",
				"message" => "Problème lors de l'envoi du score"
			];
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(404);
			$response->getBody()->write(json_encode($data));
			return $response;	
		}
	}*/
}