<?php

namespace App\Controllers;

use App\DAO\UserDAO;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

final class UserController
{
    private UserDAO $userDAO;

    public function __construct(Container $container)
    {
        $this->userDAO = $container->offsetGet(UserDAO::class);
    }
    public function getUsers(Request $request, Response $response, array $args): Response
    {
        try {
            $users = $this->userDAO->getAllUsers();
            $response = $response->withJson($users);
        } catch (\Throwable $e) {
            $response = $response->withStatus(500, 'Erro interno do servidor');
            $response = $response->withJson([
                'error' => $e->getMessage()
            ]);

        }
        return $response;
    }
}