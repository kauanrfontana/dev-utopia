<?php

namespace App\Controllers;

use App\DAO\ReviewDAO;
use App\Models\ReviewModel;
use Slim\Container;
use Slim\Http\{
    Request,
    Response
};

class ReviewController
{
    private Container $container;
    private ReviewDAO $reviewDAO;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->reviewDAO = $container->offsetGet(ReviewDAO::class);
    }

    public function getReviewsByProduct(Request $request, Response $response, array $args)
    {
        $productId = 0;
        $tokenData = $request->getAttribute("token");
        try {
            if (!isset($args["id"]) || !is_numeric($args["id"])) {
                throw new \InvalidArgumentException("Não foi possível consultar as avaliações, parâmetro informado é inválido!");
            }

            $productId = (int) $args["id"];
            $userId = $tokenData["sub"];
            $reviews = $this->reviewDAO->getReviewsByProduct($productId, $userId);

            return $response->withStatus(200)->withJson([
                "data" => $reviews
            ], null, JSON_NUMERIC_CHECK);
        } catch (\InvalidArgumentException $e) {
            return $response->withStatus(400)->withJson([
                "message" => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            return $response->withStatus(500)->withJson([
                "message" => $e->getMessage()
            ]);
        }
    }

    public function insertReview(Request $request, Response $response, array $args)
    {
        $mandatoryFields = ["productId" => "id do produto", "stars" => "estrelas", "review" => "avaliação"];
        $data = $request->getParsedBody();
        $tokenData = $request->getAttribute("token");
        try {

            foreach ($mandatoryFields as $field => $description) {
                if (empty($data[$field])) {
                    throw new \InvalidArgumentException("O campo {$description} é obrigatório!");
                }
            }

            $review = new ReviewModel();
            $review->setProductId($data["productId"])
                ->setUserId($tokenData["sub"])
                ->setStars($data["stars"])
                ->setReview($data["review"]);

            return $response->withStatus(201)->withJson($this->reviewDAO->insertReview($review));
        } catch (\InvalidArgumentException $e) {
            return $response->withStatus(400)->withJson([
                "message" => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            return $response->withStatus(500)->withJson([
                "message" => $e->getMessage()
            ]);
        }
    }


}