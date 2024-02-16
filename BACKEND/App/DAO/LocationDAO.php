<?php

namespace App\DAO;

use App\Models\LocationModel;

final class LocationDAO extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getFullLocationsByUser(): array
    {
        try {
            $sql = 'SELECT * FROM locations';
            $statement = $this->pdo->prepare($sql);

            if (!$statement->execute()) {
                throw new \Exception('Não foi possível buscar as localizações no momento. Por favor, tente mais tarde.');
            }
            $locations = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $locations;

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function insertLocationReturnId(LocationModel $location): int
    {
        try {
            $sql = 'INSERT INTO locations (
                [country], 
                [state], 
                [city], 
                [street_avenue], 
                [house_number], 
                [complement], 
                [zip_code] 
                ) VALUES (
                    [:country], 
                    [:state], 
                    [:cit]y], 
                    [:street_avenue], 
                    [:house_number], 
                    [:complement], 
                    [:zip_code]
                    )';
            $statement = $this->pdo->prepare($sql);

            $statement->bindValue(':country', $location->getCountry(), \PDO::PARAM_STR);
            $statement->bindValue(':state', $location->getState(), \PDO::PARAM_STR);
            $statement->bindValue(':city', $location->getCity(), \PDO::PARAM_STR);
            $statement->bindValue(':street_avenue', $location->getStreetAvenue(), \PDO::PARAM_STR);
            $statement->bindValue(':house_number', $location->getHouseNumber(), \PDO::PARAM_STR);
            $statement->bindValue(':complement', $location->getComplement(), \PDO::PARAM_STR);
            $statement->bindValue(':zip_code', $location->getZipCode(), \PDO::PARAM_STR);

            if (!$statement->execute()) {
                throw new \Exception('Erro ao inserir localização');
            }
            $id = $this->pdo->lastInsertId();

            return $id;
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}