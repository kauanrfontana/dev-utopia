<?php

namespace src;

use App\DAO\{
    ProductDAO,
    UserDAO,
    TokenDAO,
    RoleDAO,
    ShoppingCartDAO,
    ReviewDAO,
    PurchasedItemDAO
};


function slimConfiguration(): \Slim\Container
{
    $configuration = [
        "settings" => [
            "displayErrorDetails" => DISPLAY_ERRORS_DETAILS,
        ],
    ];
    $container = new \Slim\Container($configuration);



    //dependences

    $container->offsetSet(UserDAO::class, new UserDAO());
    $container->offsetSet(TokenDAO::class, new TokenDAO());
    $container->offsetSet(RoleDAO::class, new RoleDAO());
    $container->offsetSet(ProductDAO::class, new ProductDAO());
    $container->offsetSet(ShoppingCartDAO::class, new ShoppingCartDAO());
    $container->offsetSet(ReviewDAO::class, new ReviewDAO());
    $container->offsetSet(PurchasedItemDAO::class, new PurchasedItemDAO());


    return $container;
}