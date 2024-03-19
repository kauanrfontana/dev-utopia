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
use GuzzleHttp\Client;

final class LocationController
{

    public function getStates(Request $request, Response $response, array $args): Response
    {
        $client = new Client();
        $stateId = $request->getParam("stateId");
        $apiUrl = LOCATION_PUBLIC_API . "/estados?orderBy=nome";
        try {
            if (!empty ($stateId)) {
                $apiUrl = LOCATION_PUBLIC_API . "/estados/{$stateId}";
            }

            $apiResponse = $client->request("GET", $apiUrl);

            if ($apiResponse->getStatusCode() != "200") {
                throw new \Exception("Serviço de consulta indisponível no momento, tente novamente mais tarde!");
            }

            $states = json_decode($apiResponse->getBody()->getContents(), true);
            if (isset ($states["nome"])) {
                $states = [
                    "id" => $states["id"],
                    "name" => $states["nome"]
                ];
            } else {
                $states = array_map(function ($state) {
                    return [
                        "id" => $state["id"],
                        "name" => $state["nome"]
                    ];
                }, $states);
            }

            $response = $response->withStatus(200)->withJson([
                "data" => $states
            ]);

        } catch (\Exception $e) {
            $response = $response->withStatus(500)->withJson([
                "message" => $e->getMessage()
            ]);
        }

        return $response;
    }


    public function getCitiesByState(Request $request, Response $response, array $args): Response
    {
        $client = new Client();

        $stateId = $request->getParam("stateId");
        try {
            if (empty ($stateId)) {
                throw new \InvalidArgumentException("Parâmetro identificador de estado não informado!");
            }

            $apiResponse = $client->request("GET", LOCATION_PUBLIC_API . "/estados/{$stateId}/municipios?orderBy=nome");

            if ($apiResponse->getStatusCode() == "200") {

                $cities = json_decode($apiResponse->getBody()->getContents(), true);

                $cities = array_map(function ($city) {
                    return [
                        "id" => $city["id"],
                        "name" => $city["nome"]
                    ];
                }, $cities);

                $response = $response->withStatus(200)->withJson([
                    "data" => $cities
                ]);
            }

        } catch (\InvalidArgumentException $e) {
            $response = $response->withStatus(400)->withJson([
                "message" => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            $response = $response->withStatus(500)->withJson([
                "message" => $e->getMessage()
            ]);
        }

        return $response;
    }
}