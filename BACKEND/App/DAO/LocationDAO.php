<?php

namespace App\DAO;

use App\Models\CityModel;
use App\Models\CountryModel;
use App\Models\NeighborhoodModel;
use App\Models\StateModel;


final class LocationDAO extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCountries(): array
    {
        $result = [];
        $result["success"] = true;
        try {
            $sql = 'SELECT [id], [name] FROM [countries]';

            $statement = $this->pdo->prepare($sql);

            if (!$statement->execute()) {
                throw new \Exception("Houve um erro ao consultar os países cadastrados, tente novamente mais tarde!");
            }
            $result["data"] = $statement->fetchAll(\PDO::FETCH_ASSOC);

            return $result;

        } catch (\Throwable $e) {
            throw $e;
        }
    }
    public function insertCountry(CountryModel $country): array
    {
        $return = [];


        try {
            $sql = 'INSERT INTO [countries] ([name]) VALUES (:name)';
            $statement = $this->pdo->prepare($sql);

            $statement->bindValue(':name', $country->getName(), \PDO::PARAM_STR);

            if (!$statement->execute()) {
                throw new \Exception('Erro ao inserir país, verifique os dados e tente novamente mais tarde');
            }

            $return = [
                "success" => true,
                "message" => "País inserido com sucesso!"
            ];

            return $return;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getStates(): array
    {
        $result = [];
        $result["success"] = true;
        try {
            $sql = 'SELECT [id], [name], [country_id] FROM [states]';

            $statement = $this->pdo->prepare($sql);

            if (!$statement->execute()) {
                throw new \Exception("Houve um erro ao consultar os estados cadastrados, tente novamente mais tarde!");
            }
            $result["data"] = $statement->fetchAll(\PDO::FETCH_ASSOC);

            return $result;

        } catch (\Throwable $e) {
            throw $e;
        }
    }
    public function insertState(StateModel $state): array
    {
        $return = [];


        try {
            $sql = 'INSERT INTO [states] ([name], [country_id]) 
                    VALUES (
                        :name,
                        :countryId
                        )';
            $statement = $this->pdo->prepare($sql);

            $statement->bindValue(':name', $state->getName(), \PDO::PARAM_STR);
            $statement->bindValue(':countryId', $state->getCountryId(), \PDO::PARAM_INT);

            if (!$statement->execute()) {
                throw new \Exception('Erro ao inserir estado, verifique os dados e tente novamente mais tarde');
            }

            $return = [
                "success" => true,
                "message" => "Estado inserido com sucesso!"
            ];

            return $return;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getCities(): array
    {
        $result = [];
        $result["success"] = true;
        try {
            $sql = 'SELECT [id], [name], [state_id] FROM [cities]';

            $statement = $this->pdo->prepare($sql);

            if (!$statement->execute()) {
                throw new \Exception("Houve um erro ao consultar os cidade cadastrados, tente novamente mais tarde!");
            }
            $result["data"] = $statement->fetchAll(\PDO::FETCH_ASSOC);

            return $result;

        } catch (\Throwable $e) {
            throw $e;
        }
    }
    public function insertCity(CityModel $city): array
    {
        $return = [];


        try {
            $sql = 'INSERT INTO [cities] ([name], [state_id]) 
                    VALUES (
                        :name,
                        :stateId
                        )';
            $statement = $this->pdo->prepare($sql);

            $statement->bindValue(':name', $city->getName(), \PDO::PARAM_STR);
            $statement->bindValue(':stateId', $city->getStateId(), \PDO::PARAM_INT);

            if (!$statement->execute()) {
                throw new \Exception('Erro ao inserir cidade, verifique os dados e tente novamente mais tarde');
            }

            $return = [
                "success" => true,
                "message" => "Cidade inserido com sucesso!"
            ];

            return $return;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getNeighborhoods(): array
    {
        $result = [];
        $result["success"] = true;
        try {
            $sql = 'SELECT [id], [name], [state_id] FROM [neighborhoods]';

            $statement = $this->pdo->prepare($sql);

            if (!$statement->execute()) {
                throw new \Exception("Houve um erro ao consultar os cidade cadastrados, tente novamente mais tarde!");
            }
            $result["data"] = $statement->fetchAll(\PDO::FETCH_ASSOC);

            return $result;

        } catch (\Throwable $e) {
            throw $e;
        }
    }
    public function insertNeighborhood(NeighborhoodModel $neighborhood): array
    {
        $return = [];


        try {
            $sql = 'INSERT INTO [neighborhoods] ([name], [city_id]) 
                    VALUES (
                        :name,
                        :cityId
                        )';
            $statement = $this->pdo->prepare($sql);

            $statement->bindValue(':name', $neighborhood->getName(), \PDO::PARAM_STR);
            $statement->bindValue(':cityId', $neighborhood->getCityId(), \PDO::PARAM_INT);

            if (!$statement->execute()) {
                throw new \Exception('Erro ao inserir bairro, verifique os dados e tente novamente mais tarde');
            }

            $return = [
                "success" => true,
                "message" => "Cidade inserido com sucesso!"
            ];

            return $return;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

}

