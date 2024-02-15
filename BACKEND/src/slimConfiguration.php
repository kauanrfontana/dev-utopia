<?php

namespace src;

use App\DAO\UserDAO;


function slimConfiguration(): \Slim\Container
{
    $configuration = [
        'settings' => [
            'displayErrorDetails' => getenv('DISPLAY_ERRORS_DETAILS'),
        ],
    ];
    $container = new \Slim\Container($configuration);

    //dependences

    $container->offsetSet(UserDAO::class, new UserDAO());

    return $container;
}