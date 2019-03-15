<?php
$app->get('/photos', "Controller:photos");
$app->get('/photos/{id}', "Controller:photo");
$app->post('/photos', "Controller:newPhoto");
$app->put('/photos/{id}', "Controller:updatePhoto");
$app->get('/series', "Controller:series");
$app->get('/series/{id}', "Controller:serie");
$app->put('/series/{id}', "Controller:updatePhoto");
$app->post('/series/{serie}/add/{photo}', "Controller:addPhotoSerie");
$app->delete('/series/{serie}/remove/{photo}', "Controller:removePhotoSerie");
$app->post('/register', "Controller:register");
$app->get('/checkLogin/{login}', "Controller:checkLogin");
$app->post('/login', "Controller:login");
$app->get('/doc', "Controller:doc");