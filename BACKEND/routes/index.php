<?php
use App\Controllers\AuthController;
use App\Controllers\LocationController;
use App\Controllers\UserController;
use function src\{slimConfiguration, jwtAuth};

$app = new \Slim\App(slimConfiguration());

$app->add(function ($request, $response, $next) {
    $response = $response->withHeader('Access-Control-Allow-Origin', '*');
    $response = $response->withHeader('Access-Control-Allow-Methods', $request->getHeaderLine('Access-Control-Request-Method'));
    $response = $response->withHeader('Access-Control-Allow-Headers', $request->getHeaderLine('Access-Control-Request-Headers'));

    return $next($request, $response);
});

// ROUTES 
// ================================

$app->post("/login", AuthController::class . ":login");
$app->post("/users", UserController::class . ":insertUser");

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
    $app->get("/user[/{id}]", UserController::class . ":getUser");
})->add(jwtAuth());



// ================================


$app->run();