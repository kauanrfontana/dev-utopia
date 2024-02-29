<?php
namespace App\DAO;

use App\Models\UserModel;

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

    public function insertUser(UserModel $user, int $addressId): array
    {
        try {
            $result = [];
            $result['success'] = true;

            $sql = 'INSERT INTO users (
                [name], 
                [email], 
                [password], 
                [location_id]
                ) VALUES (
                    :name, 
                    :email, 
                    :password, 
                    :location_id
                    )';
            $statement = $this->pdo->prepare($sql);

            $statement->bindValue(':name', $user->getName(), \PDO::PARAM_STR);
            $statement->bindValue(':email', $user->getEmail(), \PDO::PARAM_STR);
            $statement->bindValue(':password', $user->getPassword(), \PDO::PARAM_STR);
            $statement->bindParam(':location_id', $locationId, \PDO::PARAM_INT);

            if (!$statement->execute()) {
                throw new \Exception('Não foi possível inserir o usuário no momento. Por favor, tente mais tarde.');
            }

            return [
                'message' => 'Usuário inserido com sucesso.'
            ];

        } catch (\Throwable $e) {
            throw $e;
        }
    }
}