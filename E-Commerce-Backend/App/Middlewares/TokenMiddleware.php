<?php
namespace App\Middlewares;

use Slim\Http\{Request, Response};
use App\Services\AuthService;

class TokenMiddleware
{
    public function __invoke(Request $request, Response $response, $next)
    {
        $oldRefreshToken = $request->getHeader("X-Refresh-Token")[0];
        $newTokens = AuthService::refreshToken($oldRefreshToken);
        if (empty($newTokens)) {
            return $response->withStatus(401);
        }

        $response = $response->withHeader("X-Refresh-Token", $newTokens["refresh_token"]);
        $response = $response->withHeader("X-Auth-Token", $newTokens["token"]);
        $response = $next($request, $response);

        return $response;

    }
}