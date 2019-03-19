<?php
namespace backend\api\controller;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \backend\api\model\Serie as Serie;
use \backend\api\model\Photo as Photo;
use \backend\api\model\Serie_photo as Serie_photo;
use \backend\api\model\User as User;
use \backend\api\utils\TokenJWT as TokenJWT;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class Controller{
	private $container;

	public function __construct(\Slim\Container $container){
		$this->container = $container;
	}

	public function doc(Request $request, Response $response, array $args){
		return $response->getBody()->write(file_get_contents("docAPI.txt"));		
	}

	public function newPhoto(Request $request, Response $response, array $args){
		try{
			$body = json_decode($request->getBody());
			$photo = new Photo();
			$photo->longitude = $body->longitude;
			$photo->latitude = $body->latitude;
			$photo->url = $body->url;			
			$photo->idUser = $body->idUser;
			$photo->save();
			return $this->container->created;
		}
		catch(\Exception $e){
			return $this->container->forbidden;
		}
	}

	public function photos(Request $request, Response $response, array $args){
		try{
			$data["photos"] = Photo::all();
			$response = $this->container->ok;
			$response->getBody()->write(json_encode($data));
			return $response;
		}
		catch(\Exception $e){
			return $this->container->notFound;
		}
	}

	public function photosAdd(Request $request, Response $response, array $args){
		try{
			$serie_photo = Serie_photo::select("idPhoto")->where("idSerie", "=", $args["serie"])->get();
			$idNotIn = [];
			foreach ($serie_photo as $element) {
				array_push($idNotIn, $element->idPhoto);
			}
			$data["photos"] = Photo::whereNotIn("id", $idNotIn)->where("idUser", "=", $args["user"])->get();
			$response = $this->container->ok;
			$response->getBody()->write(json_encode($data));
			return $response;
		}
		catch(\Exception $e){
			return $this->container->notFound;
		}
	}

	public function photo(Request $request, Response $response, array $args){
		try{
			$data["photo"] = Photo::findOrFail($args["id"]);
			$response = $this->container->ok;
			$response->getBody()->write(json_encode($data));
			return $response;
		}
		catch(\Exception $e){
			return $this->container->notFound;	
		}
	}

	public function updatePhoto(Request $request, Response $response, array $args){
		try{
			$body = json_decode($request->getBody());
			$photo = Photo::findOrFail($args["id"]);
			$photo->longitude = $body->longitude;
			$photo->latitude = $body->latitude;
			$photo->url = $body->url;
			$photo->save();
			return $this->container->noContent;
		}
		catch(\Exception $e){
			return $this->container->notFound;
		}
	}

	public function series(Request $request, Response $response, array $args){
		try{
			$data["series"]= Serie::all();
			foreach ($data["series"] as $serie){
				$points = explode(";", $serie->points);
				$serie->points = [$points[0], $points[1], $points[2]];
			}
			$response = $this->container->ok;
			$response->getBody()->write(json_encode($data));
			return $response;
		}
		catch(\Exception $e){
			return $this->container->notFound;
		}
	}

	public function serie(Request $request, Response $response, array $args){
		try{
			$data["serie"] = Serie::findOrFail($args["id"]);			
			$points = explode(";", $data["serie"]->points);
			$data["serie"]->points = ["pts1" => $points[0], "pts2" => $points[1], "pts3" => $points[2]];
			$data["photos"] = $data["serie"]->photos()->get();
			foreach($data["photos"] as $photo){
				unset($photo->idUser);
				unset($photo->pivot);
			}
			$response = $this->container->ok;
			$response->getBody()->write(json_encode($data));
			return $response;
		}
		catch(\Exception $e){
			return $this->container->notFound;
		}
	}

	public function newSerie(Request $request, Response $response, array $args){
		try{
			$body = json_decode($request->getBody());
			$serie = new Serie();
			$serie->ville = $body->ville;
			$serie->libelle = $body->libelle;
			$serie->distance = $body->distance;
			$serie->points = $body->points;
			$serie->latitude = $body->latitude;
			$serie->longitude = $body->longitude;
			$serie->zoom = $body->zoom;
			$serie->save();
			$response = $this->container->created;
			$data["serie"] = $serie->id;
			$response->getBody()->write(json_encode($data));
			return $response;
		}
		catch(\Exception $e){
			return $this->container->forbidden;
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
			return $this->container->noContent;
		}
		catch(\Exception $e){
			return $this->container->notFound;
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
				return $this->container->noContent;
			}
			return $this->container->forbidden;
		}
		catch(\Exception $e){
			return $this->container->notFound;	
		}
	}

	public function removePhotoSerie(Request $request, Response $response, array $args){
		try{
			Serie_photo::where("idSerie", "=", $args["serie"])->where("idPhoto", "=", $args["photo"])->first()->delete();
			return $this->container->noContent;
		}
		catch(\Exception $e){
			return $this->container->notFound;	
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
			return $this->container->created;
		}
		catch(\Exception $e){
			return $this->container->forbidden;
		}
	}

	public function checkLogin(Request $request, Response $response, array $args){
		$data["count"] = User::where("login", "=", $args["login"])->count();
		$response = $this->container->ok;
		$response->getBody()->write(json_encode($data));
		return $response;
	}

	public function login(Request $request, Response $response, array $args){
		$body = json_decode($request->getBody());
		$user = User::where("login", "=", $body->login)->first();
		if($user != null && password_verify($body->password, $user->password)){
			unset($user->password);			
			$data = ["user" => $user];
			$response = $this->container->ok;
			$response->getBody()->write(json_encode($data));
			return $response;
		}
		return $this->container->unauthorized;
	}
}