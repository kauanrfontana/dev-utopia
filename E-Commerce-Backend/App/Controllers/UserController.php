<?php

namespace App\Controllers;

use App\DAO\UserDAO;
use App\Models\UserModel;
use App\Services\AuthService;
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
            $response = $response->withJson($users, null, JSON_NUMERIC_CHECK);
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
            if (isset ($args["id"])) {
                if (!filter_var($args["id"], FILTER_VALIDATE_INT)) {
                    throw new \InvalidArgumentException("Não foi possível consultar o usuário, parâmetro informado é inválido!");
                }
                $userId = (int) $args["id"];
            } else {
                $token = $request->getHeaderLine("X-Auth-Token");
                $userData = AuthService::decodeToken($token);
                $userId = $userData->sub;
            }
            $user = $this->userDAO->getUser($userId);

            $response = $response->withStatus(200)->withJson([
                "data" => $user
            ], null, JSON_NUMERIC_CHECK);



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
                if (empty ($data[$field])) {
                    throw new \InvalidArgumentException("O campo {$description} é obrigatório.");
                }
                $user->{"set" . ucfirst($field)}($data[$field]);
            }

            if (empty ($data["password"]) || strlen($data["password"]) < 6) {
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

    public function updateUser(Request $request, Response $response, array $args): Response
    {
        $mandatoryFields = [
            "name" => "nome",
            "email" => "email",
        ];
        $fields = [
            "name",
            "email",
            "address",
            "stateId",
            "cityId",
            "houseNumber",
            "complement",
            "zipCode",
        ];
        $tokenData = AuthService::decodeToken($request->getHeaderLine("X-Auth-Token"));

        $data = $request->getParsedBody();
        $user = new UserModel();

        try {

            foreach ($mandatoryFields as $field => $description) {
                if (empty ($data[$field])) {
                    throw new \InvalidArgumentException("O campo {$description} é obrigatório.");
                }
            }

            foreach ($fields as $field) {
                $user->{"set" . ucfirst($field)}($data[$field]);
            }
            $user->setId($tokenData->sub);


            $response = $response->withStatus(201)->withJson($this->userDAO->updateUser($user));

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

    public function updatePassword(Request $request, Response $response, array $args): Response
    {
        $mandatoryFields = ["currentPassword" => "senha atual", "newPassword" => "nova senha"];

        $data = $request->getParsedBody();

        $tokenData = AuthService::decodeToken($request->getHeaderLine("X-Auth-Token"));

        try {
            foreach ($mandatoryFields as $field => $description) {
                if (empty ($data[$field])) {
                    throw new \InvalidArgumentException("O campo {$description} é obrigatório.");
                }
            }

            $user = $this->userDAO->getUserByEmail($tokenData->email);

            $currentPassword = $data["currentPassword"];
            if (!password_verify($currentPassword, $user->getPassword())) {
                throw new \InvalidArgumentException("Senha atual informada, não corresponde com a cadastrada em nosso sistema!");
            }

            $newPassword = password_hash($data["newPassword"], PASSWORD_DEFAULT);

            $user = new UserModel();

            $user->setId($tokenData->sub)
                ->setPassword($newPassword);

            $response = $response->withStatus(200)->withJson($this->userDAO->updatePassword($user));

        } catch (\InvalidArgumentException $e) {
            $response = $response->withStatus(404)->withJson([
                "message" => $e->getMessage()
            ]);
        } catch (\Throwable $e) {
            $response = $response->withStatus(500)->withJson([
                "message" => $e->getMessage()
            ]);
        }

        return $response;

    }

    public function updateUserRole(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $userId = 0;
        $tokenData = AuthService::decodeToken($request->getHeaderLine("X-Auth_token"));
        try {
            $userId = $tokenData->sub;
            if (isset ($args["id"])) {
                $userId = (int) $args["id"];
            }

            if (empty ($data["newRoleCategory"])) {
                throw new \InvalidArgumentException("Não foi possível atalizar o perfil, categoria do novo perfil não informada!");
            }
            $category = $data["newRoleCategory"];
            $response = $response->withStatus(200)->withJson($this->userDAO->updateUserRole($userId, $category));

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