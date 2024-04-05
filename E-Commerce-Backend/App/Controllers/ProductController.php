<?php

namespace App\Controllers;

use App\DAO\ProductDAO;
use App\Models\ProductModel;
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
                if (empty($data[$param])) {
                    throw new \InvalidArgumentException("Parâmetro de paginação obrigatório não encontrado!");
                }
            }
            $products = $this->productDAO->getAllProducts($data);
            $response = $response->withJson($products, null, JSON_NUMERIC_CHECK);
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
    public function getMyProducts(Request $request, Response $response, array $args): Response
    {
        $mandatoryPaginationParams = ["currentPage", "itemsPerPage"];
        $data = $request->getParams();
        $tokenData = $request->getAttribute("jwt");
        try {
            foreach ($mandatoryPaginationParams as $param) {
                if (empty($data[$param])) {
                    throw new \InvalidArgumentException("Parâmetro de paginação obrigatório não encontrado!");
                }
            }
            $userId = $tokenData["sub"];

            $products = $this->productDAO->getMyProducts($data, $userId);
            $response = $response->withJson($products, null, JSON_NUMERIC_CHECK);
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

    public function getProductById(Request $request, Response $response, array $args): Response
    {
        $productId = 0;
        try {
            if (!isset($args["id"]) || !filter_var($args["id"], FILTER_VALIDATE_INT)) {
                throw new \InvalidArgumentException("Não foi possível consultar o produto, parâmetro informado é inválido!");
            }
            $productId = (int) $args["id"];
            $product = $this->productDAO->getProductById($productId);
            $response = $response->withStatus(200)->withJson($product, null, JSON_NUMERIC_CHECK);

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

    public function insertProduct(Request $request, Response $response, array $args): Response
    {
        $mandatoryFields = [
            "name" => "nome",
            "price" => "preço",
            "stateId" => "estado",
            "cityId" => "cidade",
            "address" => "endereço",
            "houseNumber" => "número da casa",
            "zipCode" => "CEP",
        ];
        $fields = [
            "name",
            "urlImage",
            "price",
            "description",
            "stateId",
            "cityId",
            "address",
            "houseNumber",
            "zipCode",
            "complement"
        ];

        $data = $request->getParsedBody();
        $product = new ProductModel();
        $tokenData = $request->getAttribute("jwt");

        try {
            foreach ($mandatoryFields as $field => $description) {
                if (empty($data[$field])) {
                    throw new \InvalidArgumentException("O campo {$description} é obrigatório!");
                }
            }
            foreach ($fields as $field) {
                $product->{"set" . ucfirst($field)}($data[$field]);
            }
            $product->setUserId($tokenData["sub"]);

            $response = $response->withStatus(201)->withJson($this->productDAO->insertProduct($product));

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

    public function updateProduct(Request $request, Response $response, array $args): Response
    {
        $mandatoryFields = [
            "id" => "id do produto",
            "name" => "nome",
            "price" => "preço",
            "stateId" => "estado",
            "cityId" => "cidade",
            "address" => "endereço",
            "houseNumber" => "número da casa",
            "zipCode" => "CEP",
        ];
        $fields = [
            "id",
            "name",
            "urlImage",
            "price",
            "description",
            "stateId",
            "cityId",
            "address",
            "houseNumber",
            "zipCode",
            "complement"
        ];

        $data = $request->getParsedBody();
        $product = new ProductModel();

        try {
            foreach ($mandatoryFields as $field => $description) {
                if (empty($data[$field])) {
                    throw new \InvalidArgumentException("O campo {$description} é obrigatório!");
                }
            }
            foreach ($fields as $field) {
                $product->{"set" . ucfirst($field)}($data[$field]);
            }

            $response = $response->withStatus(201)->withJson($this->productDAO->updateProduct($product));

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

    public function deleteProduct(Request $request, Response $response, array $args): Response
    {
        $productId = 0;
        try {
            if (!isset($args["id"]) || !filter_var($args["id"], FILTER_VALIDATE_INT)) {
                throw new \InvalidArgumentException("Não foi possível excluir o produto, id informado é inválido!");
            }
            $productId = (int) $args["id"];
            $response = $response->withStatus(200)->withJson($this->productDAO->deleteProduct($productId));

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