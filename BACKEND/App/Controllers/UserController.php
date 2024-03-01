<?php

namespace App\Controllers;

use App\DAO\UserDAO;
use App\Models\UserModel;
use Slim\Container;
use Slim\Http\{
    Request,
    Response
};

final class UserController
{
    private Container $container;
    private UserDAO $userDAO;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->userDAO = $container->offsetGet(UserDAO::class);
    }
    public function getAllUsers(Request $request, Response $response, array $args): Response
    {
        try {
            $users = $this->userDAO->getAllUsers();
            $response = $response->withJson($users);
        } catch (\Throwable $e) {
            $response = $response->withStatus(500, "Erro interno do servidor");
            $response = $response->withJson([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }

        return $response;
    }

    public function insertUser(Request $request, Response $response, array $args): Response
    {
        $mandatoryFields = ["name" => "nome", "email" => "email", "password" => "senha", "houseNumber" => "numero da casa", "zipCode" => "cep", "streetAvenueId" => "logradouro"];

        $data = $request->getParsedBody();
        $user = new UserModel();

        try {

            foreach ($mandatoryFields as $field => $description) {
                if (empty($data[$field])) {
                    throw new \Exception("O campo {$description} é obrigatório.");
                }
                $user->{"set" . ucfirst($field)}($data[$field]);
            }

            if ($user->getPassword() < 6) {
                throw new \Exception("O campo senha deve conter no mínimo 6 caracteres!");
            }


            $response = $response->withStatus(201)->withJson($this->userDAO->insertUser($user));

        } catch (\Throwable $e) {
            $response = $response->withJson([
                "error" => $e->getMessage()
            ]);
        }
        return $response;
    }
}