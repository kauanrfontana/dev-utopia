<?php
namespace App\DAO;


final class PurchasedItemDAO extends Connection
{
    public function __construct()
    {
        parent::__construct();
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