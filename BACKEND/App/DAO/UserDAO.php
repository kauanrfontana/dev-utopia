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
        $result = [];
        $result["success"] = true;

        try {
            $sql = "SELECT * FROM users";
            $statement = $this->pdo->prepare($sql);

            if (!$statement->execute()) {
                throw new \Exception("Não foi possível buscar os usuários no momento. Por favor, tente mais tarde.");
            }
            $users = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $result["users"] = $users;
            return $result;

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getUserByEmail(string $email): ?UserMOdel
    {
        $sql = "SELECT * FROM users WHERE email = :email";

        $statement = $this->pdo->prepare($sql);

        $statement->bindParam(":email", $email, \PDO::PARAM_STR);

        if (!$statement->execute()) {
            return null;
        }

        $users = $statement->fetchAll(\PDO::FETCH_ASSOC);

        if (count($users) !== 0) {
            $user = new UserModel();

            $user->setId($users[0]["id"])
                ->setName($users[0]['name'])
                ->setEmail($users[0]['email'])
                ->setPassword($users[0]['password']);
            return $user;
        }
        return null;

    }

    public function insertUser(UserModel $user): array
    {
        $result = [];
        $result["success"] = true;
        try {

            $sql = "INSERT INTO users (
                [name], 
                [email], 
                [password], 
                [street_avenue_id],
                [house_number],
                [complement],
                [zip_code],
                [created_at]
                ) VALUES (
                    :name, 
                    :email, 
                    :password, 
                    :streetAvenueId,
                    :houseNumber,
                    :complement,
                    :zipCode,
                    :createdAt
                    )";
            $statement = $this->pdo->prepare($sql);

            $currentDateTime = (new \DateTime())->format("Y-m-d H:i:s");

            $statement->bindValue(":name", $user->getName(), \PDO::PARAM_STR);
            $statement->bindValue(":email", $user->getEmail(), \PDO::PARAM_STR);
            $statement->bindValue(":password", $user->getPassword(), \PDO::PARAM_STR);
            $statement->bindValue(":streetAvenueId", $user->getStreetAvenueId(), \PDO::PARAM_INT);
            $statement->bindValue(":houseNumber", $user->getHouseNumber(), \PDO::PARAM_STR);
            $statement->bindValue(":complement", $user->getComplement(), \PDO::PARAM_STR);
            $statement->bindValue(":zipCode", $user->getZipCode(), \PDO::PARAM_STR);
            $statement->bindValue(":createdAt", $currentDateTime, \PDO::PARAM_STR);

            if (!$statement->execute()) {
                throw new \Exception("Não foi possível inserir o usuário no momento. Por favor, tente mais tarde.");
            }

            $result["message"] = "Usuário inserido com sucesso.";
            return $result;

        } catch (\Throwable $e) {
            throw $e;
        }
    }
}