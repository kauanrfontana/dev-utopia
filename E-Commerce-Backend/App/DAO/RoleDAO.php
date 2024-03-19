<?php

namespace App\DAO;

class RoleDAO extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllRoles(): array
    {
        $result = [];

        try {
            $sql = "SELECT * FROM roles";
            $statement = $this->pdo->prepare($sql);

            if (!$statement->execute()) {
                throw new \Exception("Não foi possível buscar os cargos no momento. Por favor, tente mais tarde.");
            }
            $roles = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $result["roles"] = $roles;
            return $result;

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getRoleIdByCategory(int $category): int
    {

        try {
            $sql = "SELECT [id] FROM [roles] WHERE [category] = :category";

            $statement = $this->pdo->prepare($sql);

            $statement->bindParam(":category", $category, \PDO::PARAM_INT);

            if (!$statement->execute()) {
                throw new \Exception("Não foi possível buscar o cargo no momento. Por favor, tente mais tarde.");
            }

            $result = (int) $statement->fetchColumn();
            return $result;
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}