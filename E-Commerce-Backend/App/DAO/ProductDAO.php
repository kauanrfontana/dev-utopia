<?php

namespace App\DAO;

use App\Models\ProductModel;
use App\Services\PaginationService;

class ProductDAO extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllProducts(array $filters): array
    {
        $result = [];

        try {
            $orderColumn = "created_at";
            $orderType = "DESC";
            if ($filters["orderColumn"] == "price") {
                $orderColumn = "price";
            }
            if ($filters["orderColumn"] == "createdAt") {
                $orderColumn = "created_at";
            }
            if (!empty($filters["orderType"])) {
                $orderType = $filters["orderType"];
            }

            $likeClousure = $filters["searchText"];

            $procedurePaginationLine = PaginationService::getPaginationLine($filters["currentPage"], $filters["itemsPerPage"]);

            $sql = "SELECT 
                        id, 
                        name, 
                        url_image AS urlImage, 
                        price 
                    FROM products 
                    WHERE 
                        name LIKE " . "'%" . $likeClousure . "%'" .
                "ORDER BY $orderColumn $orderType 
                    $procedurePaginationLine";

            $statement = $this->pdo->prepare($sql);

            if (!$statement->execute()) {
                throw new \Exception("Não foi possível buscar os produtos no momento. Por favor, tente mais tarde.");
            }

            $products = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $result["data"] = $products;

            $sqlCount = "SELECT COUNT(*) as total 
                        FROM products  
                        WHERE name LIKE " . "'%" . $likeClousure . "%'";

            $statement = $this->pdo->prepare($sqlCount);

            $statement->execute();

            $result["totalItems"] = $statement->fetch(\PDO::FETCH_COLUMN);

            return $result;

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getMyProducts(array $filters, int $userId): array
    {
        $result = [];

        try {
            $orderColumn = "created_at";
            $orderType = "DESC";
            if ($filters["orderColumn"] == "price") {
                $orderColumn = "price";
            }
            if ($filters["orderColumn"] == "createdAt") {
                $orderColumn = "created_at";
            }
            if (!empty($filters["orderType"])) {
                $orderType = $filters["orderType"];
            }

            $likeClousure = $filters["searchText"];

            $procedurePaginationLine = PaginationService::getPaginationLine($filters["currentPage"], $filters["itemsPerPage"]);

            $sql = "SELECT 
                        id, 
                        name, 
                        url_image as urlImage, 
                        price 
                    FROM products 
                    WHERE
                        user_id = :userId AND 
                        name LIKE " . "'%" . $likeClousure . "%'" .
                "ORDER BY $orderColumn $orderType 
                    $procedurePaginationLine";

            $statement = $this->pdo->prepare($sql);

            $statement->bindParam(":userId", $userId, \PDO::PARAM_INT);

            if (!$statement->execute()) {
                throw new \Exception("Não foi possível buscar os produtos no momento. Por favor, tente mais tarde.");
            }

            $products = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $result["data"] = $products;

            $sqlCount = "SELECT COUNT(*) as total 
                        FROM products  
                        WHERE user_id = :userId AND name LIKE " . "'%" . $likeClousure . "%'";

            $statement = $this->pdo->prepare($sqlCount);

            $statement->bindParam(":userId", $userId, \PDO::PARAM_INT);

            $statement->execute();

            $result["totalItems"] = $statement->fetch(\PDO::FETCH_COLUMN);

            return $result;

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getProductById(int $productId): array
    {
        $result = [];

        try {
            $sql = "SELECT 
                        id, 
                        user_id AS userId,
                        name, 
                        COALESCE(url_image, '') AS urlImage, 
                        price, 
                        COALESCE(description, '') AS description, 
                        state_id AS stateId, 
                        city_id AS cityId, 
                        address, 
                        COALESCE(complement, '') AS complement, 
                        house_number AS houseNumber, 
                        zip_code AS zipCode   
                    FROM products WHERE id = :id";

            $statement = $this->pdo->prepare($sql);

            $statement->bindParam(":id", $productId, \PDO::PARAM_INT);

            if (!$statement->execute()) {
                throw new \Exception("Não foi possível buscar o produto no momento. Por favor, tente mais tarde.");
            }

            $product = $statement->fetch(\PDO::FETCH_ASSOC);

            $result["data"] = $product;

            return $result;

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function insertProduct(ProductModel $productModel): array
    {
        $result = [];
        try {
            $sql = "INSERT INTO products (
                        user_id, 
                        name, 
                        url_image, 
                        price, 
                        description, 
                        state_id, 
                        city_id, 
                        address, 
                        complement, 
                        house_number, 
                        zip_code,
                        created_at
                        ) VALUES (
                            :userId, 
                            :name, 
                            :urlImage, 
                            :price, 
                            :description, 
                            :stateId, 
                            :cityId, 
                            :address, 
                            :complement, 
                            :houseNumber, 
                            :zipCode,
                            GETDATE()
                            )";
            $statement = $this->pdo->prepare($sql);

            $statement->bindValue(":userId", $productModel->getUserId(), \PDO::PARAM_INT);
            $statement->bindValue(":name", $productModel->getName(), \PDO::PARAM_STR);
            $statement->bindValue(":urlImage", $productModel->getUrlImage(), \PDO::PARAM_STR);
            $statement->bindValue(":price", $productModel->getPrice(), \PDO::PARAM_STR);
            $statement->bindValue(":description", $productModel->getDescription(), \PDO::PARAM_STR);
            $statement->bindValue(":stateId", $productModel->getStateId(), \PDO::PARAM_INT);
            $statement->bindValue(":cityId", $productModel->getCityId(), \PDO::PARAM_INT);
            $statement->bindValue(":address", $productModel->getAddress(), \PDO::PARAM_STR);
            $statement->bindValue(":complement", $productModel->getComplement(), \PDO::PARAM_STR);
            $statement->bindValue(":houseNumber", $productModel->getHouseNumber(), \PDO::PARAM_STR);
            $statement->bindValue(":zipCode", $productModel->getZipCode(), \PDO::PARAM_STR);

            if (!$statement->execute()) {
                throw new \Exception("Não foi possível inserir o produto no momento. Por favor, tente mais tarde.");
            }

            $result["message"] = "Produto inserido com sucesso!";
            return $result;

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function updateProduct(ProductModel $productModel): array
    {
        $result = [];

        try {
            $sql = "UPDATE products SET 
                        name = :name, 
                        url_image = :urlImage, 
                        price = :price, 
                        description = :description, 
                        state_id = :stateId, 
                        city_id = :cityId, 
                        address = :address, 
                        complement = :complement, 
                        house_number = :houseNumber, 
                        zip_code = :zipCode 
                    WHERE id = :id";

            $statement = $this->pdo->prepare($sql);

            $statement->bindValue(":name", $productModel->getName(), \PDO::PARAM_STR);
            $statement->bindValue(":urlImage", $productModel->getUrlImage(), \PDO::PARAM_STR);
            $statement->bindValue(":price", $productModel->getPrice(), \PDO::PARAM_STR);
            $statement->bindValue(":description", $productModel->getDescription(), \PDO::PARAM_STR);
            $statement->bindValue(":stateId", $productModel->getStateId(), \PDO::PARAM_INT);
            $statement->bindValue(":cityId", $productModel->getCityId(), \PDO::PARAM_INT);
            $statement->bindValue(":address", $productModel->getAddress(), \PDO::PARAM_STR);
            $statement->bindValue(":complement", $productModel->getComplement(), \PDO::PARAM_STR);
            $statement->bindValue(":houseNumber", $productModel->getHouseNumber(), \PDO::PARAM_STR);
            $statement->bindValue(":zipCode", $productModel->getZipCode(), \PDO::PARAM_STR);
            $statement->bindValue(":id", $productModel->getId(), \PDO::PARAM_INT);

            if (!$statement->execute()) {
                throw new \Exception("Não foi possível atualizar o produto no momento. Por favor, tente mais tarde.");
            }

            $result["message"] = "Produto atualizado com sucesso!";
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function deleteProduct(int $productId): array
    {
        $result = [];
        try {
            $sql = "DELETE FROM products WHERE id = :id";

            $statement = $this->pdo->prepare($sql);

            $statement->bindValue(":id", $productId, \PDO::PARAM_INT);

            if (!$statement->execute()) {
                throw new \Exception("Não foi possível excluir o produto no momento. Por favor, tente mais tarde.");
            }

            $result["message"] = "Produto excluído com sucesso!";
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}