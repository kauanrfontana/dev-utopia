<?php
use App\Controllers\AuthController;
use App\Controllers\LocationController;
use App\Controllers\UserController;
use function src\slimConfiguration;

$app = new \Slim\App(slimConfiguration());



// ROUTES 
// ================================

$app->get('/teste', AuthController::class . ':login');
$app->get('/users', UserController::class . ':getUsers');

$app->get('/countries', LocationController::class . ':getCountries');
$app->post('/countries', LocationController::class . ':insertCountries');

$app->get('/states', LocationController::class . ':getStates');
$app->post('/states', LocationController::class . ':insertState');

$app->get('/cities', LocationController::class . ':getCities');
$app->post('/cities', LocationController::class . ':insertCity');


// ================================


$app->run();