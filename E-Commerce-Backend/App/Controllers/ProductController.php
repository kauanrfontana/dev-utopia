<?php

namespace App\Controllers;

use App\DAO\ProductDAO;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

final class ProductController
{
    private ProductDAO $productDAO;
    public function __construct(Container $container)
    {
        $this->productDAO = $container->offsetGet(ProductDAO::class);
    }

    public function getAllProducts(Request $request, Response $response, array $args): Response
    {
        $mandatoryPaginationParams = ["currentPage", "itemsPerPage"];
        $data = $request->getParams();
        try {
            foreach ($mandatoryPaginationParams as $param) {
                if (empty ($data[$param])) {
                    throw new \InvalidArgumentException("Parâmetro de paginação obrigatório não encontrado!");
                }
            }
            $products = $this->productDAO->getAllProducts($data);
            $response = $response->withJson($products, null, JSON_NUMERIC_CHECK);
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