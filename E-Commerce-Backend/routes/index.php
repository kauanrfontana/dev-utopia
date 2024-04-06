<?php
use App\Controllers\{
    AuthController,
    LocationController,
    UserController,
    ProductController,
    ShoppingCartController,
    ReviewController,
    PurchasedItemController
};
use App\Middlewares\TokenMiddleware;
use function src\{slimConfiguration, jwtAuth};

$app = new \Slim\App(slimConfiguration());

$app->options("/{routes:.+}", function ($request, $response, $args) {
    return $response;
});

$app->add(function ($request, $response, $next) {
    $response = $next($request, $response);
    return $response->withHeader("Access-Control-Allow-Origin", "*")
        ->withHeader("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS")
        ->withHeader("Access-Control-Allow-Headers", "Content-Type, Authorization, X-Auth-Token, X-Refresh-Token")
        ->withHeader("Access-Control-Expose-Headers", "Content-Type, Authorization, X-Auth-Token, X-Refresh-Token");

});




// ROUTES 
// ================================

$app->post("/login", AuthController::class . ":login");

$app->post("/user", UserController::class . ":insertUser");

$app->group("", function () use ($app) {
    $app->group("/locations", function () use ($app) {
        $app->get("/states", LocationController::class . ":getStates");

        $app->get("/cities", LocationController::class . ":getCitiesByState");

        $app->get("/cep/{cep}", LocationController::class . ":getLocationByCep");
    });

    $app->group("/users", function () use ($app) {
        $app->get("", UserController::class . ":getAllUsers");

        $app->put("", UserController::class . ":updateUser");

        $app->put("/password", UserController::class . ":updatePassword");

        $app->put("/userRole[/{id}]", UserController::class . ":updateUserRole");

        $app->delete("/{id}", UserController::class . ":deleteUserById");
    });

    $app->get("/user[/{id}]", UserController::class . ":getUserById");

    $app->group("/products", function () use ($app) {
        $app->get("", ProductController::class . ":getAllProducts");

        $app->get("/my", ProductController::class . ":getMyProducts");

        $app->get("/{id}", ProductController::class . ":getProductById");

        $app->get("/{id}/reviews", ReviewController::class . ":getReviewsByProduct");

        $app->post("/{id}/reviews", ReviewController::class . ":insertReview");

        $app->post("", ProductController::class . ":insertProduct");

        $app->put("", ProductController::class . ":updateProduct");

        $app->put("/{id}/reviews", ReviewController::class . ":updateReview");

        $app->delete("/{id}", ProductController::class . ":deleteProduct");
    });

    $app->group("/shoppingCart", function () use ($app) {
        $app->get("", ShoppingCartController::class . ":getShoppingCartByUserId");

        $app->post("", ShoppingCartController::class . ":addProductToShoppingCart");

        $app->delete("/{id}", ShoppingCartController::class . ":removeProductFromShoppingCart");

    });

    $app->post("/purchase", PurchasedItemController::class . ":insertPurchase");


})->add(TokenMiddleware::class)->add(jwtAuth());

// ================================

$app->map(["GET", "POST", "PUT", "DELETE", "PATCH"], "/{routes:.+}", function ($req, $res) {
    $handler = $this->notFoundHandler;
    return $handler($req, $res);
});

$app->run();