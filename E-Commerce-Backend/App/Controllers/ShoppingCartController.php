<?php

namespace App\Controllers;

use App\DAO\ShoppingCartDAO;
use App\Models\ShoppingCartModel;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

final class ShoppingCartController
{
    private ShoppingCartDAO $shoppingCartDAO;
    public function __construct(Container $container)
    {
        $this->shoppingCartDAO = $container->offsetGet(ShoppingCartDAO::class);
    }

    public function getShoppingCartByUserId(Request $request, Response $response, array $args): Response
    {
        $userId = 0;
        $tokenData = $request->getAttribute("jwt");
        try {

            $userId = $tokenData["sub"];

            $shoppingCart = $this->shoppingCartDAO->getShoppingCartByUserId($userId);

            $response = $response->withStatus(200)->withJson([
                "data" => $shoppingCart
            ], null, JSON_NUMERIC_CHECK);

        } catch (\InvalidArgumentException $e) {
            $response = $response->withStatus(400)->withJson([
                "message" => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            $response = $response->withStatus(500)->withJson([
                "message" => $e->getMessage()
            ]);
        }

        return $response;
    }

    public function addProductToShoppingCart(Request $request, Response $response, array $args): Response
    {
        $userId = 0;
        $productId = 0;
        $data = $request->getParsedBody();

        try {
            $userData = $request->getAttribute("jwt");
            $userId = $userData["sub"];


            if (!isset($data["productId"]) || empty($data["productId"])) {
                throw new \InvalidArgumentException("O campo id do produto é obrigatório.");
            }
            $productId = (int) $data["productId"];


            $response = $response->withStatus(201)->withJson($this->shoppingCartDAO->addProductToShoppingCart($userId, $productId));

        } catch (\InvalidArgumentException $e) {
            $response = $response->withStatus(400)->withJson([
                "message" => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            $response = $response->withStatus(500)->withJson([
                "message" => $e->getMessage()
            ]);
        }

        return $response;
    }

    public function removeProductFromShoppingCart(Request $request, Response $response, array $args): Response
    {
        $userId = 0;
        $productId = 0;

        try {
            $userData = $request->getAttribute("jwt");

            $userId = $userData["sub"];
            
            if (!isset($args["id"]) || empty($args["id"])){
                throw new \InvalidArgumentException("O campo id do produto é obrigatório.");
            }
            $productId = (int) $args["id"];
            $response = $response->withStatus(200)->withJson($this->shoppingCartDAO->removeProductFromShoppingCart($userId, $productId));
        } catch (\InvalidArgumentException $e) {
            $response = $response->withStatus(400)->withJson([
                "message" => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            $response = $response->withStatus(500)->withJson([
                "message" => $e->getMessage()
            ]);
        }
        return $response;
    }


}