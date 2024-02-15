<?php
namespace App\DAO;

final class UserDAO extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getAllUsers(): array
    {
        try {
            $sql = 'SELECT * FROM users';
            $statement = $this->pdo->prepare($sql);

            if (!$statement->execute()) {
                throw new \Exception('Não foi possível buscar os usuários no momento. Por favor, tente mais tarde.');
            }
            $users = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $users;

        } catch (\Exception $e) {
            throw $e;
        }
    }
}