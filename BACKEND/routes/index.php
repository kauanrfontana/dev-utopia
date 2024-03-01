<?php
use App\Controllers\AuthController;
use App\Controllers\LocationController;
use App\Controllers\UserController;
use function src\jwtAuth;
use function src\slimConfiguration;

$app = new \Slim\App(slimConfiguration());



// ROUTES 
// ================================

$app->get("/teste", AuthController::class . ":login");

$app->group('', function () use ($app) {
    // LOCATION ROUTES [
    $app->get("/locations", LocationController::class . ":getAllLocationsByType");

    $app->post("/countries", LocationController::class . ":insertCountries");

    $app->post("/states", LocationController::class . ":insertState");

    $app->post("/cities", LocationController::class . ":insertCity");

    $app->post("/neighborhoods", LocationController::class . ":insertNeighborhood");

    $app->post("/streetsAvenues", LocationController::class . ":insertStreetAvenue");
    // ]

    $app->get("/users", UserController::class . ":getAllUsers");
})->add(jwtAuth());


$app->post("/users", UserController::class . ":insertUser");

// ================================


$app->run();