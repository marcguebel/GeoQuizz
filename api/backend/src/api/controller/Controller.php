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

	public function newPhoto(Request $request, Response $response, array $args){
		try{
			$body = json_decode($request->getBody());
			$photo = new Photo();
			$photo->longitude = $body->longitude;
			$photo->latitude = $body->latitude;
			$photo->url = $body->url;
			$photo->save();
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(204);
			$response->getBody()->write(json_encode($data));
			return $response;
		}
		catch(\Exception $e){
			$data = [
				"type" => "Error",
				"error" => "404",
				"message" => "Problème lors de la création de la photo"
			];
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(404);
			$response->getBody()->write(json_encode($data));
			return $response;	
		}
	}
}