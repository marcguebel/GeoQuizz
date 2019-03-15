<?php
namespace api\backend\api\controller;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \api\backend\api\model\Serie as Serie;
use \api\backend\api\model\Photo as Photo;
use \api\backend\api\model\Serie_photo as Serie_photo;
use \api\backend\api\model\User as User;
use \api\backend\api\utils\TokenJWT as TokenJWT;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

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
			$tokenJWT = TokenJWT::decode(explode(" ", $request->getHeader("Authorization")[0])[1]);
			$photo->idUser = $tokenJWT->id;
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
			foreach ($data["series"] as $serie){
				$serie->points = [
					"D" => explode(";", $serie->points)[0],
					"2D" => explode(";", $serie->points)[1],
					"3D" => explode(";", $serie->points)[2]
				];
			}
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
			$data["serie"]["points"] = [
				"D" => explode(";", $serie->points)[0],
				"2D" => explode(";", $serie->points)[1],
				"3D" => explode(";", $serie->points)[2]
			];
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
			$serie->latitude = $body->latitude;
			$serie->longitude = $body->longitude;
			$serie->zoom = $body->zoom;
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
			$test_doublon = Serie_photo::where("idSerie", "=", $args["serie"])->where("idPhoto", "=", $args["photo"])->first();
			if($test_doublon == null){
				$serie_photo = new Serie_photo();
				$serie_photo->idSerie = $args["serie"];
				$serie_photo->idPhoto = $args["photo"];
				$serie_photo->save();
				$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(204);
			}
			else{
				$data = [
					"type" => "Error",
					"error" => "400",
					"message" => "Doublon"
				];
				$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(400);
				$response->getBody()->write(json_encode($data));
			}
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

	public function register(Request $request, Response $response, array $args){
		try{
			$body = json_decode($request->getBody());
			$user = new User();
			$user->id = Uuid::uuid4();
			$user->login = $body->login;
			$user->password = password_hash($body->password, PASSWORD_DEFAULT);
			$user->save();
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(204);
			return $response;
		}
		catch(\Exception $e){
			$data = [
				"type" => "Error",
				"error" => "400",
				"message" => "Erreur lors de l'inscription"
			];
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(400);
			$response->getBody()->write(json_encode($data));
			return $response;	
		}
	}

	public function checkLogin(Request $request, Response $response, array $args){
		$data["count"] = User::where("login", "=", $args["login"])->count();
		$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(200);
		$response->getBody()->write(json_encode($data));
		return $response;
	}

	public function login(Request $request, Response $response, array $args){
		$body = json_decode($request->getBody());
		$user = User::where("login", "=", $body->login)->first();
		if($user != null && password_verify($body->password, $user->password)){
			$tokenJWT = TokenJWT::new($user->id);
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')
				->withHeader('Authorization', 'Bearer '.$tokenJWT)
				->withStatus(200);
			$data = [
				"type" => "Resource",
				"user" => $user
			];
		}
		else{
			$data = [
				"type" => "Error",
				"error" => "401",
				"message" => "Login ou mot de passe erroné"
			];
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(401);			
		}
		$response->getBody()->write(json_encode($data));
		return $response;
	}
}