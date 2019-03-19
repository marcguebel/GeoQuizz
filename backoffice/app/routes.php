<?php
use Backoffice\Middleware\AuthMiddleware;
use Backoffice\Middleware\GuestMiddleware;

$app->group("", function(){
	$this->get("/auth/signup", "AuthController:getSignUp")->setName("auth.signup");
	$this->post("/auth/signup", "AuthController:postSignUp");
	$this->get("/auth/signin", "AuthController:getSignIn")->setName("auth.signin");
	$this->post("/auth/signin", "AuthController:postSignIn");
})->add(new GuestMiddleware($container));

$app->group("", function(){
	$this->get("/", "HomeController:index")->setName("home");
	$this->get("/photos", "PhotoController:getPhotos")->setName("photo.all");
	$this->get("/photo", "PhotoController:getNewPhoto")->setName("photo.new");
	$this->post("/photo", "PhotoController:newPhoto")->setName("photo.postPhoto");
	$this->get("/series", "SerieController:getSeries")->setName("serie.all");
	$this->get("/serie", "SerieController:getNewSerie")->setName("serie.new");
	$this->post("/serie", "SerieController:newSerie")->setName("serie.postSerie");
	$this->get("/series/{id}", "SerieController:getSerie")->setName("serie.details");
	$this->get("/series/{id}/edit", "SerieController:getSerieEdit")->setName("serie.edit");
	$this->post("/series/{id}/update", "SerieController:updateSerie")->setName("serie.update");
	$this->get("/series/{serie}/remove/{photo}", "SerieController:removePhotoSerie")->setName("serie.removePhoto");
	$this->get("/series/{serie}/add", "PhotoController:getAddPhoto")->setName("serie.photo");
	$this->get("/series/{serie}/add/{photo}", "SerieController:addPhotoSerie")->setName("serie.addPhoto");
	$this->get("/auth/signout", "AuthController:getSignOut")->setName("auth.signout");
})->add(new AuthMiddleware($container));
