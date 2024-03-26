<?php

namespace App\Controllers;

use App\DAO\RoleDAO;
use Slim\Container;
use Slim\Http\{
    Request,
    Response
};

class RoleController
{
    private Container $container;
    private RoleDAO $roleDAO;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->roleDAO = $container->offsetGet(RoleDAO::class);
    }

    public function getAllRoles(Request $request, Response $response, array $args): Response
    {
        try {
            $roles = $this->roleDAO->getAllRoles();
            $response = $response->withJson($roles, null, JSON_NUMERIC_CHECK);
        } catch (\Throwable $e) {
            $response = $response->withStatus(500)->withJson([

                "message" => $e->getMessage()
            ]);
        }
        return $response;
    }

}