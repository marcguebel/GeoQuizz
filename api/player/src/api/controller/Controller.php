<?php
namespace player\api\controller;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \player\api\model\Partie as Partie;
use \player\api\model\Serie as Serie;
use \player\api\model\Photo as Photo;
use \player\api\utils\Token as Token;

class Controller{
	private $container;

	public function __construct($container){
		$this->container = $container;
	}

	public function doc(Request $request, Response $response, array $args){
		return $response->getBody()->write(file_get_contents("docAPI.txt"));
	}

	public function newGame(Request $request, Response $response, array $args){
		try{
			$body = json_decode($request->getBody());
			$partie = new Partie();
			$partie->id = Token::new();
			$partie->status = Partie::$status["created"];
			$partie->idSerie = $body->serie;
			$partie->joueur = $body->joueur;
			$partie->save();
			$data["partie"] = $partie;
			$serie = $partie->serie()->first();
			$data["serie"] = $serie;
			$points = explode(";", $serie->points);
			$data["serie"]->points = ["3D" => $points[0], "2D" => $points[1], "D" => $points[2]];
			$photos = $serie->photos()->get();
			$data["photos"] = [];		
			foreach ($photos as $photo){
				array_push($data["photos"], [
					"id" => $photo->id, 
					"longitude" => $photo->longitude, 
					"latitude" => $photo->latitude, 
					"url" => $photo->url
				]);
			}
			$response = $this->container->created;
			$response->getBody()->write(json_encode($data));
			return $response;
		}
		catch(\Exception $e){
			return $this->container->notFound;	
		}
	}

	public function status(Request $request, Response $response, array $args){
		try{
			$body = json_decode($request->getBody());
			$partie = Partie::findOrFail($args["id"]);
			$partie->status = Partie::$status[$body->status];			
			$partie->save();
			return $this->container->noContent;
		}
		catch(\Exception $e){
			return $this->container->notFound;
		}
	}

	public function score(Request $request, Response $response, array $args){
		try{
			$body = json_decode($request->getBody());
			$partie = Partie::findOrFail($args["id"]);
			$partie->status = Partie::$status["finished"];
			$partie->score = $body->score;			
			$partie->save();
			return $this->container->noContent;
		}
		catch(\Exception $e){
			return $this->container->notFound;
		}
	}

	public function leaderboard(Request $request, Response $response, array $args){
		try{
			$parties = Partie::select(["joueur", "score"])
				->where("status", "=", Partie::$status["leaderboard"])
				->where("idSerie", "=", $args["serie"])
				->orderBy("score", "desc")
				->take(10)
				->get();
			$data["score"] = $parties;	
			$response = $this->container->ok;
			$response->getBody()->write(json_encode($data));
			return $response;
		}
		catch(\Exception $e){
			return $this->container->notFound;
		}	
	}

	public function series(Request $request, Response $response, array $args){
		try{
			$series = Serie::select(["id", "ville", "libelle", "distance"])->get();
			$data["series"] = $series;
			$response = $this->container->ok;
			$response->getBody()->write(json_encode($data));
			return $response;
		}
		catch(\Exception $e){
			return $this->container->notFound;
		}
	}
}