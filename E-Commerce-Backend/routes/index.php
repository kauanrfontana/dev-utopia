<?php
use App\Controllers\AuthController;
use App\Controllers\LocationController;
use App\Controllers\UserController;
use App\Middlewares\TokenMiddleware;
use function src\{slimConfiguration, jwtAuth};

$app = new \Slim\App(slimConfiguration());

$app->add(function ($request, $response, $next) {
    $response = $response->withHeader('Access-Control-Allow-Origin', '*');
    $response = $response->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    $response = $response->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Auth-Token, X-Refresh-Token');
    $response = $response->withHeader('Access-Control-Expose-Headers', 'Content-Type, Authorization, X-Auth-Token, X-Refresh-Token');

    if ($request->getMethod() === 'OPTIONS') {
        return $response->withStatus(200);
    }

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
})->add(TokenMiddleware::class)->add(jwtAuth());



// ================================


$app->run();