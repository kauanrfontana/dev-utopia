<?php
namespace App\DAO;


final class PurchasedItemDAO extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function productWasPurchasedItemByUser(int $productId, int $userId): bool
    {
        $sql = "SELECT 
                    COUNT(*)
                FROM purchased_items                 
                WHERE product_id = :productId
                AND user_id = :userId";

        $statement = $this->pdo->prepare($sql);

        $statement->bindParam("productId", $productId, \PDO::PARAM_INT);

        $statement->bindParam("userId", $userId, \PDO::PARAM_INT);

        if (!$statement->execute()) {
            throw new \Exception("Não foi possível consultar o item comprado no momento. Por favor, tente novamente mais tarde.");
        }

        $purchasedItem = $statement->fetch(\PDO::FETCH_COLUMN);


        return $purchasedItem != 0;
    }

    public function insertPurchase(int $userId, array $products)
    {
        $result = [];
        try {
            $this->pdo->beginTransaction();
            $sql = "INSERT INTO purchased_items (user_id, product_id, purchase_date) VALUES (:userId, :productId, GETDATE())";


            foreach ($products as $product) {
                $statement = $this->pdo->prepare($sql);

                $statement->bindParam("userId", $userId, \PDO::PARAM_INT);

                $statement->bindParam("productId", $product["id"], \PDO::PARAM_INT);

                if (!$statement->execute()) {
                    throw new \Exception("Não foi possível realizar a compra no momento. Por favor, tente mais tarde.");
                }

            }
            $this->pdo->commit();
            $result["message"] = "Compra realizada com sucesso!";

            $shoppingCartDAO = new ShoppingCartDAO();
            $shoppingCartDAO->clearShoppingCart($userId);

            return $result;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }


}