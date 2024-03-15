<?php

namespace App\Controllers;

use App\DAO\UserDAO;
use App\Models\UserModel;
use App\services\AuthService;
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
            $response = $response->withStatus(500)->withJson([
                "message" => $e->getMessage()
            ]);
        }

        return $response;
    }

    public function getUser(Request $request, Response $response, array $args): Response
    {
        $userId = 0;
        $token = "";
        try {
            if (isset($args['id'])) {
                if (!filter_var($args['id'], FILTER_VALIDATE_INT)) {
                    throw new \InvalidArgumentException("Não foi possível consultar o usuário, parâmetro informado é inválido!");
                }
                $userId = (int) $args['id'];
            } else {
                $token = $request->getHeader("X-Auth-Token")[0];
                $userData = AuthService::decodeToken($token);
                $userId = $userData->sub;
            }
            $response = $response->withStatus(200)->withJson([
                "data" => $this->userDAO->getUser($userId)
            ]);
        } catch (\InvalidArgumentException $e) {
            $response = $response->withStatus(400)->withJson([
                "message" => $e->getMessage()
            ]);
        } catch (\Throwable $e) {
            $response = $response->withStatus(500)->withJson([
                "message" => $e->getMessage()
            ]);
        }
        return $response;
    }

    public function insertUser(Request $request, Response $response, array $args): Response
    {
        $mandatoryFields = ["name" => "nome", "email" => "email"];

        $data = $request->getParsedBody();
        $user = new UserModel();

        try {

            foreach ($mandatoryFields as $field => $description) {
                if (empty($data[$field])) {
                    throw new \InvalidArgumentException("O campo {$description} é obrigatório.");
                }
                $user->{"set" . ucfirst($field)}($data[$field]);
            }

            if (empty($data["password"]) || strlen($data["password"]) < 6) {
                throw new \InvalidArgumentException("O campo senha deve conter no mínimo 6 caracteres!");
            }

            $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);
            $user->setPassword($data["password"]);



            $response = $response->withStatus(201)->withJson($this->userDAO->insertUser($user));

        } catch (\InvalidArgumentException $e) {
            $response = $response->withStatus(400)->withJson([
                "message" => $e->getMessage()
            ]);
        } catch (\Throwable $e) {
            $response = $response->withStatus(500)->withJson([
                "message" => $e->getMessage()
            ]);
        }
        return $response;
    }
}