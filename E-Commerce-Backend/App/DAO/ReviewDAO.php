<?php

namespace App\DAO;

use App\Models\ReviewModel;
use App\Services\PaginationService;

class ReviewDAO extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getReviewsByProduct(int $productId, int $userId, array $filters)
    {
        $result = [];
        try {

            $procedurePaginationLine = PaginationService::getPaginationLine($filters["currentPage"], $filters["itemsPerPage"]);

            $sql = "SELECT 
                        pr.id, 
                        pr.stars, 
                        pr.review, 
                        pr.product_id AS productId, 
                        pr.user_id AS userId, 
                        pr.created_at AS createdAt, 
                        pr.updated_at AS updatedAt, 
                        u.name AS userName 
                    FROM product_reviews pr
                    INNER JOIN users u
                    ON pr.user_id = u.id
                    WHERE pr.product_id = :productId
                    ORDER BY
                        CASE 
                            WHEN pr.user_id = :userId THEN 0
                            ELSE 1
                        END, pr.stars DESC
                        $procedurePaginationLine";

            $statement = $this->pdo->prepare($sql);

            $statement->bindParam(':productId', $productId, \PDO::PARAM_INT);
            $statement->bindParam(':userId', $userId, \PDO::PARAM_INT);

            if (!$statement->execute()) {
                throw new \Exception("Não foi possível consultar as avalizações do produto no momento. Por favor, tente novamente mais tarde.");
            }

            $reviews = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $result["data"]["reviews"] = $reviews;

            $sqlCount = "SELECT COUNT(*) AS total
                         FROM product_reviews pr
                         INNER JOIN users u
                         ON pr.user_id = u.id
                         WHERE pr.product_id = :productId";

            $statement = $this->pdo->prepare($sqlCount);

            $statement->bindParam(':productId', $productId, \PDO::PARAM_INT);

            $statement->execute();

            $result["totalItems"] = $statement->fetch(\PDO::FETCH_COLUMN);

            $purchaseDAO = new PurchasedItemDAO();
            $result["data"]["wasPurchased"] = $purchaseDAO->productWasPurchasedItemByUser($productId, $userId);

            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function insertReview(ReviewModel $review)
    {
        $result = [];
        try {
            $sql = "INSERT INTO product_reviews (product_id, user_id, stars, review, created_at)
                    VALUES (:productId, :userId, :stars, :review, GETDATE())";

            $statement = $this->pdo->prepare($sql);

            $statement->bindValue(':productId', $review->getProductId(), \PDO::PARAM_INT);
            $statement->bindValue(':userId', $review->getUserId(), \PDO::PARAM_INT);
            $statement->bindValue(':stars', $review->getStars(), \PDO::PARAM_INT);
            $statement->bindValue(':review', $review->getReview(), \PDO::PARAM_STR);

            if (!$statement->execute()) {
                throw new \Exception("Não foi possível inserir a avaliação do produto no momento. Por favor, tente novamente mais tarde.");
            }

            $result["message"] = "Avaliação inserida com sucesso!";
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function updateReview(ReviewModel $review)
    {
        $result = [];
        try {
            $sql = "UPDATE product_reviews
                    SET stars = :stars, review = :review, updated_at = GETDATE()
                    WHERE product_id = :productId AND user_id = :userId";

            $statement = $this->pdo->prepare($sql);

            $statement->bindValue(':productId', $review->getProductId(), \PDO::PARAM_INT);
            $statement->bindValue(':userId', $review->getUserId(), \PDO::PARAM_INT);
            $statement->bindValue(':stars', $review->getStars(), \PDO::PARAM_INT);
            $statement->bindValue(':review', $review->getReview(), \PDO::PARAM_STR);

            if (!$statement->execute()) {
                throw new \Exception("Não foi possível atualizar a avaliação do produto no momento. Por favor, tente novamente mais tarde.");
            }

            $result["message"] = "Avaliação atualizada com sucesso!";
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

}