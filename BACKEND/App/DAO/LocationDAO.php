<?php

namespace App\DAO;

use App\Models\CountryModel;


final class LocationDAO extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCountries(): array
    {
        $result = [];
        try {
            $sql = 'SELECT [id], [name] from [countries]';

            $statement = $this->pdo->prepare($sql);

            if ($statement->execute()) {
                throw new \Exception("Houve um erro ao consultar os países cadastrados, tente novamente mais tarde!");
            }
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

            return $result;

        } catch (\Throwable $e) {
            throw $e;
        }
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

}