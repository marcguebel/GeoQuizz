<?php
$app->post('/game/new', "Controller:newGame");
$app->put('/game/status/{id}', "Controller:status");
$app->put('/game/score/{id}', "Controller:score");
$app->get('/game/leaderboard/{serie}', "Controller:leaderboard");
$app->get('/series', "Controller:series");
$app->get('/doc', "Controller:doc");