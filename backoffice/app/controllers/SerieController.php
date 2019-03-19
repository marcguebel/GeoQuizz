<?php
namespace Backoffice\Controllers;
use \Slim\Views\Twig as View;
use Respect\Validation\Validator as v;

class SerieController extends Controller{
	public function getSeries($request, $response){
		$curl = new \Curl\Curl();
		$curlResponse = $curl->get($this->baseUrl."/series");
		$series = json_decode($curlResponse->response)->series;
		return $this->view->render($response, "series/series.twig", ["series" => $series]);
	}

	public function getSerie($request, $response, $args){
		$curl = new \Curl\Curl();
		$curlResponse = $curl->get($this->baseUrl."/series/".$args["id"]);
		$curlBody = json_decode($curlResponse->response);
		return $this->view->render($response, "series/serie.twig", ["serie" => $curlBody->serie, "photos" => $curlBody->photos]);
	}

	public function getNewSerie($request, $response){
		return $this->view->render($response, "series/newSerie.twig");
	}

	public function newSerie($request, $response){
		$curl = new \Curl\Curl();
		$post = $request->getParams();
		$body = [
			"ville" => $post["ville"],
			"libelle" => $post["libelle"],
			"distance" => $post["distance"],
			"points" => $post["pts1"].";".$post["pts2"].";".$post["pts3"],
			"latitude" => $post["latitude"],
			"longitude" => $post["longitude"],
			"zoom" => $post["zoom"],
		];
		$curlResponse = $curl->post($this->baseUrl."/series", json_encode($body));
		return $response->withRedirect($this->router->pathFor("serie.details", ["id" => json_decode($curlResponse->response)->serie]));
	}

	public function removePhotoSerie($request, $response, $args){
		$curl = new \Curl\Curl();
		$curl->delete($this->baseUrl."/series/".$args["serie"]."/remove/".$args["photo"]);
		return $response->withRedirect($this->router->pathFor("serie.details", ["id" => $args["serie"]]));
	}

	public function addPhotoSerie($request, $response, $args){
		$curl = new \Curl\Curl();
		$curl->post($this->baseUrl."/series/".$args["serie"]."/add/".$args["photo"]);
		return $response->withRedirect($this->router->pathFor("serie.details", ["id" => $args["serie"]]));
	}

	public function getSerieEdit($request, $response, $args){
		$curl = new \Curl\Curl();
		$curlResponse = $curl->get($this->baseUrl."/series/".$args["id"]);
		$serie = json_decode($curlResponse->response)->serie;
		return $this->view->render($response, "series/editSerie.twig", ["serie" => $serie, "points" => $serie->points]);
	}

	public function updateSerie($request, $response, $args){
		$curl = new \Curl\Curl();
		$post = $request->getParams();
		$body = [
			"ville" => $post["ville"],
			"libelle" => $post["libelle"],
			"distance" => $post["distance"],
			"points" => $post["pts1"].";".$post["pts2"].";".$post["pts3"],
			"latitude" => $post["latitude"],
			"longitude" => $post["longitude"],
			"zoom" => $post["zoom"]
		];
		$curlResponse = $curl->put($this->baseUrl."/series/".$args["id"], json_encode($body), true);
		return $response->withRedirect($this->router->pathFor("serie.details", ["id" => $args["id"]]));
	}
}