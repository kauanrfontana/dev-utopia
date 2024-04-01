<?php
namespace App\Middlewares;

use Slim\Http\{Request, Response};
use App\Services\AuthService;

class TokenMiddleware
{
    public function __invoke(Request $request, Response $response, $next)
    {
        $oldRefreshToken = $request->getHeaderLine("X-Refresh-Token");
        $oldToken = $request->getHeaderLine("X-Auth-Token");
        $newTokens = AuthService::refreshToken($oldRefreshToken);
        if (!empty($newTokens)) {
            $response = $response->withHeader("X-Refresh-Token", $newTokens["refresh_token"]);
            $response = $response->withHeader("X-Auth-Token", $newTokens["token"]);
        } else {
            $response = $response->withHeader("X-Refresh-Token", $oldRefreshToken);
            $response = $response->withHeader("X-Auth-Token", $oldToken);
        }


        $response = $next($request, $response);

        return $response;

    }
}