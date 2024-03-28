<?php

namespace App\DAO;

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
            if (!empty ($filters["orderType"])) {
                $orderType = $filters["orderType"];
            }

            $likeClousure = $filters["searchText"];

            $procedurePaginationLine = PaginationService::getPaginationLine($filters["currentPage"], $filters["itemsPerPage"]);

            $sql = "SELECT id, name, url_image as urlImage, price FROM products WHERE name LIKE " . "'%" . $likeClousure . "%'" . "ORDER BY $orderColumn $orderType $procedurePaginationLine";

            $statement = $this->pdo->prepare($sql);

            if (!$statement->execute()) {
                throw new \Exception("Não foi possível buscar os produtos no momento. Por favor, tente mais tarde.");
            }

            $products = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $result["data"] = $products;

            $sqlCount = "SELECT COUNT(*) as total FROM products  WHERE name LIKE " . "'%" . $likeClousure . "%'";

            $statement = $this->pdo->prepare($sqlCount);

            $statement->execute();

            $result["totalItems"] = $statement->fetch(\PDO::FETCH_COLUMN);

            return $result;

        } catch (\Exception $e) {
            throw $e;
        }
    }
}