<?php
namespace api\player\api\controller;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \api\player\api\model\Partie as Partie;
use \api\player\api\model\Serie as Serie;
use \api\player\api\model\Photo as Photo;
use \api\player\api\model\Niveau as Niveau;
use \api\player\api\middleware\Token as Token;

class Controller{
	private $container;
	public function __construct(\Slim\Container $container){
		$this->container = $container;
	}

	public function newGame(Request $request, Response $response, array $args){
		try{
			$body = json_decode($request->getBody());
			$partie = new Partie();
			$partie->id = Token::new();
			$partie->status = Partie::$created;
			$partie->idSerie = $body->serie;
			$partie->joueur = $body->joueur;
			$partie->save();
			$data["partie"] = $partie;			

			$niveau = Niveau::find($body->niveau)->first();
			$data["niveau"] = ["libelle" => $niveau->libelle, "distance" => $niveau->distance];

			$serie = $partie->serie()->first();
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

			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(200);	
			$response->getBody()->write(json_encode($data));
			return $response;
		}
		catch(\Exception $e){
			$data = [
				"type" => "Error",
				"error" => "404",
				"message" => "Problème dans la création de la partie"
			];
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(404);
			$response->getBody()->write(json_encode($data));
			return $response;	
		}
	}

	public function score(Request $request, Response $response, array $args){
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
	}

	public function leaderboard(Request $request, Response $response, array $args){
		try{
			$parties = Partie::select(["joueur", "score"])
				->where("status", "=", Partie::$finished)
				->where("idSerie", "=", $args["id"])
				->where("idNiveau", "=", $args["niveau"])
				->orderBy("score", "desc")
				->get();
			$data["score"] = $parties;	
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(200);
			$response->getBody()->write(json_encode($data));
			return $response;
		}
		catch(\Exception $e){
			$data = [
				"type" => "Error",
				"error" => "404",
				"message" => "Ressource introuvable /game/leaderboard/".$args["id"]
			];
			$response = $response->withHeader('Content-type', 'application/json; charset=utf-8')->withStatus(404);
			$response->getBody()->write(json_encode($data));
			return $response;
		}	
	}

	/*public function test(Request $request, Response $response, array $args){
		$partie = Partie::find($request->getHeader("X-geoquizz")[0])->first();
		//var_dump($partie);
		$serie = $partie->serie()->first();
		//var_dump($serie);
		$photos = $serie->photos()->get();
		//var_dump($photos);
		foreach ($photos as $photo){
			//var_dump($photo);
		}
	}*/
}