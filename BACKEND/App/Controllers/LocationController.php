<?php

namespace App\Controllers;

use App\DAO\LocationDAO;
use App\Models\Locations\{
    CityModel,
    CountryModel,
    NeighborhoodModel,
    StateModel,
    StreetAvenueModel
};

use Slim\Container;
use Slim\Http\{
    Request,
    Response
};


final class LocationController
{
    private LocationDAO $locationDAO;

    public function __construct(Container $container)
    {
        $this->locationDAO = $container->offsetGet(LocationDAO::class);
    }

    public function getAllLocationsByType(Request $request, Response $response, array $args): Response
    {
        try {
            if (empty($request->getParam("type"))) {
                throw new \Exception("Parâmetro de tipo de localização não definido!");
            }

            $type = $request->getParam("type");

            if (!method_exists($this->locationDAO, "get" . ucfirst($type))) {
                throw new \Exception("Não encontrado retorno para o tipo de localização {$type}!");
            }
            $response = $response->withStatus(200)->withJson($this->locationDAO->{"get" . ucfirst($type)}());
        } catch (\Throwable $e) {
            $response = $response->withStatus(500)->withJson([
                "success" => false,
                "message" => $e->getMessage(),
                "typesAllowed" => "countries, states, cities, neighborhoods, stretsAvenues"
            ]);
        }
        return $response;
    }

    public function insertCountry(Request $request, Response $response, array $args): Response
    {
        $mandatoryData = ["name" => "nome"];
        $data = $request->getParsedBody();
        $country = new CountryModel();

        try {
            foreach ($mandatoryData as $field => $description) {
                if (empty($data[$field])) {
                    throw new \InvalidArgumentException("O campo {$description} é obrigatório para cadastrar um país.");
                }

                $country->{"set" . ucfirst($field)}($data[$field]);
            }

            $response = $response->withStatus(200)->withJson($this->locationDAO->insertCountry($country));
        } catch (\InvalidArgumentException $e) {
            $response = $response->withStatus(400)->withJson([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        } catch (\Throwable $e) {
            $response = $response->withStatus(500)->withJson([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
        return $response;
    }

    public function insertState(Request $request, Response $response, array $args): Response
    {
        $mandatoryData = ["name" => "nome", "countryId" => "id do país"];
        $data = $request->getParsedBody();
        $state = new StateModel();

        try {
            foreach ($mandatoryData as $field => $description) {
                if (empty($data[$field])) {
                    throw new \InvalidArgumentException("O campo {$description} é obrigatório para cadastrar um estado.");
                }

                $state->{"set" . ucfirst($field)}($data[$field]);
            }

            $response = $response->withStatus(200)->withJson($this->locationDAO->insertState($state));
        } catch (\InvalidArgumentException $e) {
            $response = $response->withStatus(400)->withJson([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        } catch (\Throwable $e) {
            $response = $response->withStatus(500)->withJson([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
        return $response;
    }

    public function insertCity(Request $request, Response $response, array $args): Response
    {
        $mandatoryData = ["name" => "nome", "stateId" => "id do estado"];
        $data = $request->getParsedBody();
        $city = new CityModel();

        try {
            foreach ($mandatoryData as $field => $description) {
                if (empty($data[$field])) {
                    throw new \InvalidArgumentException("O campo {$description} é obrigatório para cadastrar uma cidade.");
                }

                $city->{"set" . ucfirst($field)}($data[$field]);
            }

            $response = $response->withStatus(200)->withJson($this->locationDAO->insertCity($city));
        } catch (\InvalidArgumentException $e) {
            $response = $response->withStatus(400)->withJson([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        } catch (\Throwable $e) {
            $response = $response->withStatus(500)->withJson([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
        return $response;
    }


    public function insertNeighborhood(Request $request, Response $response, array $args): Response
    {
        $mandatoryData = ["name" => "nome", "cityId" => "id da cidade"];
        $data = $request->getParsedBody();
        $neighborhood = new NeighborhoodModel();

        try {
            foreach ($mandatoryData as $field => $description) {
                if (empty($data[$field])) {
                    throw new \InvalidArgumentException("O campo {$description} é obrigatório para cadastrar um bairro.");
                }

                $neighborhood->{"set" . ucfirst($field)}($data[$field]);
            }

            $response = $response->withStatus(200)->withJson($this->locationDAO->insertNeighborhood($neighborhood));
        } catch (\InvalidArgumentException $e) {
            $response = $response->withStatus(400)->withJson([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        } catch (\Throwable $e) {
            $response = $response->withStatus(500)->withJson([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
        return $response;
    }
    public function insertStreetAvenue(Request $request, Response $response, array $args): Response
    {
        $mandatoryData = ["name" => "nome", "neighborhoodId" => "id do bairro"];
        $data = $request->getParsedBody();
        $streetAvenue = new StreetAvenueModel();

        try {
            foreach ($mandatoryData as $field => $description) {
                if (empty($data[$field])) {
                    throw new \InvalidArgumentException("O campo {$description} é obrigatório para cadastrar uma rua/avenida.");
                }

                $streetAvenue->{"set" . ucfirst($field)}($data[$field]);
            }

            $response = $response->withStatus(200)->withJson($this->locationDAO->insertStreetAvenue($streetAvenue));
        } catch (\InvalidArgumentException $e) {
            $response = $response->withStatus(400)->withJson([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        } catch (\Throwable $e) {
            $response = $response->withStatus(500)->withJson([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
        return $response;
    }





}