<?php

namespace App\Controllers;

use App\DAO\LocationDAO;
use App\Models\LocationModel;
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
    public function getUserLocation(Request $request, Response $response, array $args): Response
    {
        $response->getBody()->write('Locations');
        return $response;
    }

    public function insertLocation(Request $request, Response $response, array $args): Response
    {
        $mandatoryFields = ['country' => 'país', 'state' => 'estado', 'city' => 'cidade', 'neighborhood' => 'bairro', 'streetAvenue' => 'logradouro', 'houseNumber' => 'numero da casa', 'complement' => 'complemento', 'zipCode' => 'cep'];
        $data = $request->getParsedBody();
        $location = new LocationModel();

        try {
            foreach ($mandatoryFields as $field => $description) {
                if (empty($data[$field])) {
                    throw new \Exception("O campo {$description} é obrigatório.");
                }
                $location->{'set' . ucfirst($field)}($data[$field]);
            }
            $response = $response->withJson([
                'location_id' => $this->locationDAO->insertLocationReturnId($location)
            ]);

        } catch (\Throwable $e) {
            $response = $response->withStatus(400);
            $response = $response->withJson([
                'error' => $e->getMessage()
            ]);
        }

        return $response;
    }


}