<?php

namespace App\Controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;


final class LocationController
{
    public function getLocations(Request $request, Response $response, array $args): Response
    {
        $response->getBody()->write('Locations');
        return $response;
    }
}