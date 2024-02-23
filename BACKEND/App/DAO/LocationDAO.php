<?php

namespace App\DAO;

use App\Models\LocationModel;

final class LocationDAO extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertCountry(string $country): void
    {
        try {
            $sql = 'INSERT INTO countries ([name]) VALUES [:name]';
            $statement = $this->pdo->prepare($sql);

            $statement->bindValue(':name', $country, \PDO::PARAM_STR);

            if (!$statement->execute()) {
                throw new \Exception('Erro ao inserir país, verifique os dados e tente novamente mais tarde');
            }
        } catch (\Throwable $e) {
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
                [neighborhood], 
                [street_avenue], 
                [house_number], 
                [complement], 
                [zip_code] 
                ) VALUES (
                    [:country], 
                    [:state], 
                    [:cit]y], 
                    [:neighborhood], 
                    [:street_avenue], 
                    [:house_number], 
                    [:complement], 
                    [:zip_code]
                    )';
            $statement = $this->pdo->prepare($sql);

            $statement->bindValue(':country', $location->getCountry(), \PDO::PARAM_INT);
            $statement->bindValue(':state', $location->getState(), \PDO::PARAM_INT);
            $statement->bindValue(':city', $location->getCity(), \PDO::PARAM_INT);
            $statement->bindValue(':neighborhood', $location->getNeighborhood(), \PDO::PARAM_INT);
            $statement->bindValue(':street_avenue', $location->getStreetAvenue(), \PDO::PARAM_INT);
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