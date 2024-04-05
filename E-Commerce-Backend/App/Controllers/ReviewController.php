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
        $mandatoryPaginationParams = ["currentPage", "itemsPerPage"];
        $data = $request->getParams();
        $productId = 0;
        $tokenData = $request->getAttribute("jwt");
        try {
            if (!isset($args["id"]) || !is_numeric($args["id"])) {
                throw new \InvalidArgumentException("Não foi possível consultar as avaliações, parâmetro informado é inválido!");
            }
            foreach ($mandatoryPaginationParams as $param) {
                if (empty($data[$param])) {
                    throw new \InvalidArgumentException("Parâmetro de paginação obrigatório não encontrado!");
                }
            }

            $productId = (int) $args["id"];
            $userId = $tokenData["sub"];

            return $response->withStatus(200)->withJson($this->reviewDAO->getReviewsByProduct($productId, $userId, $data), null, JSON_NUMERIC_CHECK);
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
        $mandatoryFields = ["stars" => "estrelas", "review" => "avaliação"];
        $data = $request->getParsedBody();
        $tokenData = $request->getAttribute("jwt");
        try {
            if (!isset($args["id"]) || !is_numeric($args["id"])) {
                throw new \InvalidArgumentException("Não foi possível inserir a avaliação, parâmetro informado é inválido!");
            }
            foreach ($mandatoryFields as $field => $description) {
                if (empty($data[$field])) {
                    throw new \InvalidArgumentException("O campo {$description} é obrigatório!");
                }
            }

            $review = new ReviewModel();
            $review->setProductId($args["id"])
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

    public function updateReview(Request $request, Response $response, array $args)
    {
        $mandatoryFields = ["stars" => "estrelas", "review" => "avaliação"];
        $data = $request->getParsedBody();
        $tokenData = $request->getAttribute("jwt");
        try {
            if (!isset($args["id"]) || !is_numeric($args["id"])) {
                throw new \InvalidArgumentException("Não foi possível atualizar a avaliação, parâmetro informado é inválido!");
            }
            foreach ($mandatoryFields as $field => $description) {
                if (empty($data[$field])) {
                    throw new \InvalidArgumentException("O campo {$description} é obrigatório!");
                }
            }

            $review = new ReviewModel();
            $review->setProductId($args["id"])
                ->setUserId($tokenData["sub"])
                ->setStars($data["stars"])
                ->setReview($data["review"]);

            return $response->withStatus(200)->withJson($this->reviewDAO->updateReview($review));
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