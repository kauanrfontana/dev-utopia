<?php
namespace App\DAO;

use App\Models\ShoppingCartModel;

final class ShoppingCartDAO extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getShoppingCartByUserId(int $userId): array
    {
        try {
            $sql = "SELECT 
                p.id AS productId,
                p.name,
                p.url_image AS urlImage,
                p.description,
                p.price,
                p.state_id AS stateId,
                p.city_id AS cityId,
                p.address,
                p.house_number AS houseNumber,
                p.zip_code AS zipCode
                FROM shopping_carts sc
                INNER JOIN products p
                ON sc.product_id = p.id
                WHERE sc.user_id = :userId";

            $statement = $this->pdo->prepare($sql);

            $statement->bindParam("userId", $userId);

            if (!$statement->execute()) {
                throw new \Exception("Não foi possível consultar o carrinho de compras no momento. Por favor, tente mais tarde.");
            }

            $shoppingCartData = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $products = [];
            $qtdProducts = 0;
            $totalPrice = 0;
            foreach ($shoppingCartData as $shoppingCart) {
                $products[] = [
                    "id" => $shoppingCart["productId"],
                    "name" => $shoppingCart["name"],
                    "urlImage" => $shoppingCart["urlImage"],
                    "description" => $shoppingCart["description"],
                    "price" => $shoppingCart["price"],
                    "stateId" => $shoppingCart["stateId"],
                    "cityId" => $shoppingCart["cityId"],
                    "address" => $shoppingCart["address"],
                    "houseNumber" => $shoppingCart["houseNumber"],
                    "zipCode" => $shoppingCart["zipCode"],
                ];
                $qtdProducts++;
                $totalPrice += $shoppingCart["price"];
            }
            $shoppingCart = new ShoppingCartModel();

            $shoppingCart = [
                "userId" => $userId,
                "products" => $products,
                "qtdProducts" => $qtdProducts,
                "totalPrice" => $totalPrice
            ];

            return $shoppingCart;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function addProductToShoppingCart(int $userId, int $productId): array
    {
        $result = [];
        try {
            $sqlValidationItem = "SELECT * FROM shopping_carts WHERE user_id = :userId AND product_id = :productId";

            $statement = $this->pdo->prepare($sqlValidationItem);

            $statement->bindParam("userId", $userId, \PDO::PARAM_INT);
            $statement->bindParam("productId", $productId, \PDO::PARAM_INT);
            $statement->execute();
            if (count($statement->fetchAll(\PDO::FETCH_ASSOC)) > 0) {
                throw new \InvalidArgumentException("Produto já adicionado ao carrinho de compras.");
            }
            $sql = "INSERT INTO shopping_carts (user_id, product_id) VALUES (:userId, :productId)";

            $statement = $this->pdo->prepare($sql);

            $statement->bindParam("userId", $userId, \PDO::PARAM_INT);
            $statement->bindParam("productId", $productId, \PDO::PARAM_INT);

            if (!$statement->execute()) {
                throw new \Exception("Não foi possível adicionar o produto ao carrinho de compras no momento. Por favor, tente mais tarde.");
            }

            $result["message"] = "Produto adicionado ao carrinho de compras com sucesso!";

            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function removeProductFromShoppingCart(int $userId, int $productId): array
    {
        $result = [];
        try {
            $sql = "DELETE FROM shopping_carts WHERE user_id = :userId AND product_id = :productId";

            $statement = $this->pdo->prepare($sql);

            $statement->bindParam("userId", $userId, \PDO::PARAM_INT);
            $statement->bindParam("productId", $productId, \PDO::PARAM_INT);

            if (!$statement->execute()) {
                throw new \Exception("Não foi possível remover o produto do carrinho de compras no momento. Por favor, tente mais tarde.");
            }

            $result["message"] = "Produto removido do carrinho de compras com sucesso!";

            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function purchase()
    {

    }
}