<?php

namespace src;

use App\DAO\LocationDAO;
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
    $container->offsetSet(LocationDAO::class, new LocationDAO());


    return $container;
}