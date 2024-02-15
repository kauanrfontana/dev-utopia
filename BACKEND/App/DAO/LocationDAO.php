<?php

namespace App\DAO;

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
}