<?php

namespace App\Controllers;

use App\DAO\UserDAO;
use App\Models\LocationModel;
use App\Models\UserModel;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

final class UserController
{
    private Container $container;
    private UserDAO $userDAO;

    public function __construct(Container $container)
    {
        $this->container = $container;
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

    public function insertUser(Request $request, Response $response, array $args): Response
    {
        $mandatoryUserFields = ['name' => 'nome', 'email' => 'email', 'password' => 'senha'];
        $mandatoryLocationFields = ['country' => 'país', 'state' => 'estado', 'city' => 'cidade', 'streetAvenue' => 'logradouro', 'houseNumber' => 'numero da casa', 'complement' => 'complemento', 'zipCode' => 'cep'];

        $data = $request->getParsedBody();
        $user = new UserModel();
        $location = new LocationModel();

        try {
            foreach ($mandatoryUserFields as $field => $description) {
                if (empty($data[$field])) {
                    throw new \Exception("O campo {$description} é obrigatório.");
                }
                $user->{'set' . ucfirst($field)}($data[$field]);
            }
            foreach ($mandatoryLocationFields as $field => $description) {
                if (empty($data[$field])) {
                    throw new \Exception("O campo {$description} é obrigatório.");
                }
                $location->{'set' . ucfirst($field)}($data[$field]);
            }
            $response = $response->withStatus(201)->withJson($this->userDAO->insertUser($user, $location));

        } catch (\Throwable $e) {
            $response = $response->withJson([
                'error' => $e->getMessage()
            ]);
        }
        return $response;
    }
}