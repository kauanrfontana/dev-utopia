<?php

namespace App\Controllers;

use App\DAO\LocationDAO;
use App\Models\CityModel;
use App\Models\CountryModel;
use App\Models\StateModel;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;


final class LocationController
{
    private LocationDAO $locationDAO;

    public function __construct(Container $container)
    {
        $this->locationDAO = $container->offsetGet(LocationDAO::class);
    }

    public function getCountries(Request $request, Response $response, array $args): Response
    {
        try {
            $response = $response->withStatus(200)->withJson($this->locationDAO->getCountries());
        } catch (\Throwable $e) {
            $response = $response->withStatus(500)->withJson([
                'message' => $e->getMessage()
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

                $country->{'set' . ucfirst($field)}($data[$field]);
            }

            $response = $response->withStatus(200)->withJson($this->locationDAO->insertCountry($country));
        } catch (\InvalidArgumentException $e) {
            $response = $response->withStatus(400)->withJson([
                "message" => $e->getMessage()
            ]);
        } catch (\Throwable $e) {
            $response = $response->withStatus(500)->withJson([
                "message" => $e->getMessage()
            ]);
        }
        return $response;
    }

    public function getStates(Request $request, Response $response, array $args): Response
    {
        try {
            $response = $response->withStatus(200)->withJson($this->locationDAO->getStates());
        } catch (\Throwable $e) {
            $response = $response->withStatus(500)->withJson([
                'message' => $e->getMessage()
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

                $state->{'set' . ucfirst($field)}($data[$field]);
            }

            $response = $response->withStatus(200)->withJson($this->locationDAO->insertState($state));
        } catch (\InvalidArgumentException $e) {
            $response = $response->withStatus(400)->withJson([
                "message" => $e->getMessage()
            ]);
        } catch (\Throwable $e) {
            $response = $response->withStatus(500)->withJson([
                "message" => $e->getMessage()
            ]);
        }
        return $response;
    }

    public function getCities(Request $request, Response $response, array $args): Response
    {
        try {
            $response = $response->withStatus(200)->withJson($this->locationDAO->getCities());
        } catch (\Throwable $e) {
            $response = $response->withStatus(500)->withJson([
                'message' => $e->getMessage()
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

                $city->{'set' . ucfirst($field)}($data[$field]);
            }

            $response = $response->withStatus(200)->withJson($this->locationDAO->insertCity($city));
        } catch (\InvalidArgumentException $e) {
            $response = $response->withStatus(400)->withJson([
                "message" => $e->getMessage()
            ]);
        } catch (\Throwable $e) {
            $response = $response->withStatus(500)->withJson([
                "message" => $e->getMessage()
            ]);
        }
        return $response;
    }





}