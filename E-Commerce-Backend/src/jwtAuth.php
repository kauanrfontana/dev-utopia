<?php

namespace src;

use Tuupola\Middleware\JwtAuthentication;

function jwtAuth(): JwtAuthentication
{
    return new JwtAuthentication([
        "header" => "X-Auth-Token",
        "regexp" => "/(.*)/",
        "secret" => JWT_SECRET_KEY,
        "attribute" => "jwt",
        "error" => function ($response, $args) {
            $response = $response->withHeader("Access-Control-Allow-Origin", "*")
                ->withHeader("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS")
                ->withHeader("Access-Control-Allow-Headers", "Content-Type, Authorization, X-Auth-Token, X-Refresh-Token")
                ->withHeader("Access-Control-Expose-Headers", "Content-Type, Authorization, X-Auth-Token, X-Refresh-Token");

            return $response;
        },
    ]);
}
