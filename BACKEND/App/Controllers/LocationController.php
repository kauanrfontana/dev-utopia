<?php

namespace App\Controllers;

use App\DAO\LocationDAO;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;


final class LocationController
{
    private LocationDAO $locationDAO;

    public function __construct(Container $container)
    {
        $this->locationDAO = $container->offsetGet(LocationDAO::class);
    }
    public function getUserLocation(Request $request, Response $response, array $args): Response
    {
        $response->getBody()->write('Locations');
        return $response;
    }



}