<?php

namespace src;

use App\DAO\{
    ProductDAO,
    UserDAO,
    TokenDAO,
    RoleDAO,
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


    return $container;
}