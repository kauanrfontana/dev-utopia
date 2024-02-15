<?php
use App\Controllers\AuthController;
use App\Controllers\UserController;
use function src\slimConfiguration;

$app = new \Slim\App(slimConfiguration());



// ROUTES 
// ================================

$app->get('/teste', AuthController::class . ':login');
$app->get('/users', UserController::class . ':getUsers');


// ================================


$app->run();