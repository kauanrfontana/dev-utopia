<?php

namespace src;

use Tuupola\Middleware\JwtAuthentication;

function jwtAuth(): JwtAuthentication
{
    return new JwtAuthentication([
        "header" => "X-Auth-Token",
        "regexp" => "/(.*)/",
        "secret" => getenv("JWT_SECRET_KEY"),
        "attribute" => "jwt",
        "error" => function ($response, $args) {
            $response = $response->withHeader('Access-Control-Allow-Origin', '*');

            return $response;
        }
    ]);
}
