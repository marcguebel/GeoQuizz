<?php
$app->get('/photos', "Controller:photos");
$app->post('/photos', "Controller:newPhoto");
$app->get('/series', "Controller:series");
$app->post('/series', "Controller:newSerie");
$app->get('/series/{id}', "Controller:serie");
$app->put('/series/{id}', "Controller:updateSerie");
$app->get('/series/{serie}/photos/add', "Controller:photosAdd");
$app->post('/series/{serie}/add/{photo}', "Controller:addPhotoSerie");
$app->delete('/series/{serie}/remove/{photo}', "Controller:removePhotoSerie");
$app->post('/register', "Controller:register");
$app->get('/checkLogin/{login}', "Controller:checkLogin");
$app->post('/login', "Controller:login");
$app->get('/doc', "Controller:doc");