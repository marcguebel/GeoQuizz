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

	public function doc(Request $request, Response $response, array $args){
		$response->getBody()->write(file_get_contents("docAPI.txt"));
		return $response;
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

	public function photos(Request $request, Response $response, array $args){
		try{
			$photos = Photo::all();
			$data["photos"] = $photos;
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(200);
			$response->getBody()->write(json_encode($data));
			return $response;
		}
		catch(\Exception $e){
			$data = [
				"type" => "Error",
				"error" => "404",
				"message" => "Ressource introuvable"
			];
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(404);
			$response->getBody()->write(json_encode($data));
			return $response;	
		}
	}

	public function photo(Request $request, Response $response, array $args){
		try{
			$photo = Photo::find($args["id"]);
			$data["photo"] = $photo;
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(200);
			$response->getBody()->write(json_encode($data));
			return $response;
		}
		catch(\Exception $e){
			$data = [
				"type" => "Error",
				"error" => "404",
				"message" => "Ressource introuvable"
			];
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(404);
			$response->getBody()->write(json_encode($data));
			return $response;	
		}
	}

	public function updatePhoto(Request $request, Response $response, array $args){
		try{
			$body = json_decode($request->getBody());
			$photo = Photo::find($args["id"]);
			$photo->longitude = $body->longitude;
			$photo->latitude = $body->latitude;
			$photo->url = $body->url;
			$photo->save();
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(204);
			return $response;
		}
		catch(\Exception $e){
			$data = [
				"type" => "Error",
				"error" => "404",
				"message" => "Ressource introuvable"
			];
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(404);
			$response->getBody()->write(json_encode($data));
			return $response;	
		}
	}

	public function series(Request $request, Response $response, array $args){
		try{
			$series = Serie::all();
			$data["series"] = $series;
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(200);
			$response->getBody()->write(json_encode($data));
			return $response;
		}
		catch(\Exception $e){
			$data = [
				"type" => "Error",
				"error" => "404",
				"message" => "Ressource introuvable"
			];
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(404);
			$response->getBody()->write(json_encode($data));
			return $response;	
		}
	}

	public function serie(Request $request, Response $response, array $args){
		try{
			$serie = Serie::find($args["id"]);
			$data["serie"] = $serie;
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(200);
			$response->getBody()->write(json_encode($data));
			return $response;
		}
		catch(\Exception $e){
			$data = [
				"type" => "Error",
				"error" => "404",
				"message" => "Ressource introuvable"
			];
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(404);
			$response->getBody()->write(json_encode($data));
			return $response;	
		}
	}

	public function updateSerie(Request $request, Response $response, array $args){
		try{
			$body = json_decode($request->getBody());
			$serie = Serie::find($args["id"]);
			$serie->ville = $body->ville;
			$serie->libelle = $body->libelle;
			$serie->distance = $body->distance;
			$serie->points = $body->points;
			$serie->save();
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(204);
			return $response;
		}
		catch(\Exception $e){
			$data = [
				"type" => "Error",
				"error" => "404",
				"message" => "Ressource introuvable"
			];
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(404);
			$response->getBody()->write(json_encode($data));
			return $response;	
		}
	}

	public function addPhotoSerie(Request $request, Response $response, array $args){
		try{
			$serie_photo = new Serie_photo();
			$serie_photo->idSerie = $args["serie"];
			$serie_photo->idPhoto = $args["photo"];
			$serie_photo->save();
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(204);
			return $response;
		}
		catch(\Exception $e){
			$data = [
				"type" => "Error",
				"error" => "404",
				"message" => "Ressource introuvable"
			];
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(404);
			$response->getBody()->write(json_encode($data));
			return $response;	
		}
	}

	public function removePhotoSerie(Request $request, Response $response, array $args){
		try{
			$serie_photo = Serie_photo::where("idSerie", "=", $args["serie"])->where("idPhoto", "=", $args["photo"])->first();
			$serie_photo->delete();
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(204);
			return $response;
		}
		catch(\Exception $e){
			$data = [
				"type" => "Error",
				"error" => "404",
				"message" => "Ressource introuvable"
			];
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(404);
			$response->getBody()->write(json_encode($data));
			return $response;	
		}
	}
}