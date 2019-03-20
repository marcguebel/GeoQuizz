<?php
namespace Backoffice\Controllers;
use \Slim\Views\Twig as View;
use Respect\Validation\Validator as v;

class PhotoController extends Controller{
	public function getPhotos($request, $response){
		$curl = new \Curl\Curl();
		$curl->setHeader("Authorization", "Bearer ".$_SESSION["token"]);
		$curlResponse = $curl->get($this->baseUrl."/photos");
		$photos = json_decode($curlResponse->response)->photos;
		return $this->view->render($response, "photos/photos.twig", ["photos" => $photos]);
	}

	public function getNewPhoto($request, $response){
		return $this->view->render($response, "photos/photo.twig");
	}

	public function newPhoto($request, $response){
		$post = $request->getParams();
		$curl = new \Curl\Curl();
		$curl->setHeader("Authorization", "Bearer ".$_SESSION["token"]);
		$body = [
			"latitude" => $post["latitude"],
			"longitude" => $post["longitude"],
			"url" => $post["url"]
		];
		$curl->setHeader("Authorization", "Bearer ".$_SESSION["token"]);
		$curlResponse = $curl->post($this->baseUrl."/photos", json_encode($body));
		return $response->withRedirect($this->router->pathFor("photo.all"));
	}

	public function getAddPhoto($request, $response, $args){
		$curl = new \Curl\Curl();
		$curl->setHeader("Authorization", "Bearer ".$_SESSION["token"]);
		$curlResponse = $curl->get($this->baseUrl."/series/".$args["serie"]."/photos/add/");
		$photos = json_decode($curlResponse->response)->photos;
		return $this->view->render($response, "photos/addPhoto.twig", ["serie" => $args["serie"], "photos" => $photos]);
	}
}