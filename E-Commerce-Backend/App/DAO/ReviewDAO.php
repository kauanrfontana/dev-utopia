<?php

namespace App\DAO;

use App\Models\ReviewModel;

class ReviewDAO extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getReviewsByProduct(int $productId, int $userId)
    {
        try {
            $sql = "SELECT * 
                    FROM product_reviews 
                    WHERE product_id = :productId
                    ORDER BY
                        CASE 
                            WHEN user_id = :userId THEN 0
                            ELSE 1
                        END";

            $statement = $this->pdo->prepare($sql);

            $statement->bindParam(':productId', $productId, \PDO::PARAM_INT);
            $statement->bindParam(':userId', $userId, \PDO::PARAM_INT);

            if (!$statement->execute()) {
                throw new \Exception("Não foi possível consultar as avalizações do produto no momento. Por favor, tente novamente mais tarde.");
            }

            $reviews = $statement->fetchAll(\PDO::FETCH_ASSOC);

            return $reviews;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function insertReview(ReviewModel $review)
    {
        $result = [];
        try {
            $sql = "INSERT INTO product_reviews (product_id, user_id, stars, review, created_at)
                    VALUES (:productId, :userId, :stars, :review, NOW())";

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

}