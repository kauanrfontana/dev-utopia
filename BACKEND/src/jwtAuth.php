<?php

namespace src;

use Tuupola\Middleware\JwtAuthentication;

function jwtAuth(): JwtAuthentication
{
    return new JwtAuthentication([
        "header" => "X-Auth-Token",
        "regexp" => "/(.*)/",
        "secret" => getenv("JWT_SECRET_KEY"),
        "attribute" => "jwt"
    ]);
}