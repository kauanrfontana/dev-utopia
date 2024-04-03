<?php

namespace App\Controllers;

use App\DAO\PurchasedItemDAO;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

final class PurchasedItemController
{
    private PurchasedItemDAO $purchasedItemDAO;
    public function __construct(Container $container)
    {
        $this->purchasedItemDAO = $container->offsetGet(PurchasedItemDAO::class);
    }

    public function insertPurchase(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $tokenData = $request->getAttribute("jwt");
        try {
            if (!isset($data["products"]) || empty($data["products"])) {
                throw new \InvalidArgumentException("O campo produtos é obrigatório.");
            }


            $userId = $tokenData["sub"];
            $products = $data["products"];

            $response = $response->withStatus(201)->withJson($this->purchasedItemDAO->insertPurchase($userId, $products));
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