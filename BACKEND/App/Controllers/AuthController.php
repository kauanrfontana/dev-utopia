<?php

namespace App\Controllers;

use App\DAO\TokenDAO;
use App\DAO\UserDAO;
use App\Services\AuthService;
use Slim\Container;
use Slim\Http\{
    Request,
    Response
};

final class AuthController
{
    private UserDAO $userDAO;
    private TokenDAO $tokenDAO;

    public function __construct(Container $container)
    {
        $this->userDAO = $container->offsetGet(UserDAO::class);
        $this->tokenDAO = $container->offsetGet(TokenDAO::class);
    }

    public function login(Request $request, Response $response, array $args)
    {
        $data = $request->getParsedBody();

        $email = $data["email"];
        $password = $data["password"];

        $user = $this->userDAO->getUserByEmail($email);

        if (is_null($user)) {
            return $response->withStatus(401)->withJson([
                "message" => "Nenhum usuário encontrado com o email e senha informados!"
            ]);
        }

        if (!password_verify($password, $user->getPassword())) {
            return $response->withStatus(401)->withJson([
                "message" => "Nenhum usuário encontrado com o email e senha informados!"
            ]);
        }

        $response = $response->withJson(AuthService::setTokens($user));
        return $response;

    }
}