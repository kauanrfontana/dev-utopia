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

    public function getUserByEmail(string $email): ?UserModel
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
                ->setName($users[0]["name"])
                ->setEmail($users[0]["email"])
                ->setPassword($users[0]["password"]);
            return $user;
        }
        return null;

    }

    public function getUser(int $userId): array
    {
        $result = [];

        try {
            $sql = "SELECT 
                    COALESCE(name, '') AS name, 
                    COALESCE(email, '') AS email, 
                    COALESCE(address, '') AS address, 
                    COALESCE(state_id, 0) AS stateId, 
                    COALESCE(city_id, 0) AS cityId, 
                    COALESCE(house_number, '') AS houseNumber, 
                    COALESCE(complement, '') AS complement, 
                    COALESCE(zip_code, '') AS zipCode
            FROM users 
            WHERE id = :userId
            ";

            $statement = $this->pdo->prepare($sql);

            $statement->bindParam(":userId", $userId, \PDO::PARAM_INT);

            if (!$statement->execute()) {
                throw new \Exception("Não foi possível consultar o usuário, confira os dados, e tente novamente mais tarde!");
            }

            $user = $statement->fetch(\PDO::FETCH_ASSOC);

            $sqlRoles = "SELECT r.name
                    FROM users u
                    INNER JOIN user_roles ur
                    ON u.id = ur.user_id
                    INNER JOIN roles r
                    ON ur.role_id = r.id
                    WHERE u.id = :userId";

            $statement = $this->pdo->prepare($sqlRoles);

            $statement->bindParam(":userId", $userId, \PDO::PARAM_INT);

            if (!$statement->execute()) {
                throw new \Exception("Não foi possível consultar o usuário, confira os dados, e tente novamente mais tarde!");
            }

            $userRoles = $statement->fetchAll(\PDO::FETCH_COLUMN);

            $user["roles"] = $userRoles;

            $result["user"] = $user;
            return $result;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function insertUser(UserModel $user): array
    {
        $result = [];
        try {
            $this->pdo->beginTransaction();

            $sqlValidateEmail = "SELECT * FROM users WHERE email = :email";
            $statement = $this->pdo->prepare($sqlValidateEmail);

            $statement->bindValue(":email", $user->getEmail(), \PDO::PARAM_STR);
            if (!$statement->execute()) {
                throw new \Exception("Não foi possível validar o e-mail no momento. Por favor, tente mais tarde.");
            }
            $userRegistered = $statement->fetchAll(\PDO::FETCH_ASSOC);

            if (count($userRegistered) !== 0) {
                throw new \InvalidArgumentException("O e-mail informado já está cadastrado no sistema.");
            }


            $sqlUserRegister = "INSERT INTO users (
                name, 
                email, 
                password, 
                created_at
                ) VALUES (
                    :name, 
                    :email, 
                    :password, 
                    CONVERT(datetime, :createdAt, 120)
                    )";
            $statement = $this->pdo->prepare($sqlUserRegister);

            $currentDateTime = (new \DateTime())->format("Y-m-d H:i:s");

            $statement->bindValue(":name", $user->getName(), \PDO::PARAM_STR);
            $statement->bindValue(":email", $user->getEmail(), \PDO::PARAM_STR);
            $statement->bindValue(":password", $user->getPassword(), \PDO::PARAM_STR);
            $statement->bindValue(":createdAt", $currentDateTime, \PDO::PARAM_STR);

            if (!$statement->execute()) {
                throw new \Exception("Não foi possível inserir o usuário no momento. Por favor, tente mais tarde.");
            }

            $userId = (int) $this->pdo->lastInsertId();

            $roleDAO = new RoleDAO();
            $roleCustomerId = $roleDAO->getRoleIdByCategory(1);

            $sqlSetUserAsCustomer = "INSERT INTO user_roles(
                user_id, 
                role_id
                ) VALUES (
                    :userId, 
                    :roleId
                    )";
            $statement = $this->pdo->prepare($sqlSetUserAsCustomer);

            $statement->bindParam(":userId", $userId, \PDO::PARAM_INT);
            $statement->bindParam(":roleId", $roleCustomerId, \PDO::PARAM_INT);

            if (!$statement->execute()) {
                throw new \Exception("Não foi possível inserir o usuário no momento. Por favor, tente mais tarde.");
            }

            $result["message"] = "Usuário inserido com sucesso.";

            $this->pdo->commit();
            return $result;

        } catch (\Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function updateUser(UserModel $user): array
    {
        $result = [];

        try {
            $sql = "UPDATE users SET 
                        name = :name,
                        email = :email,
                        address = :address,
                        state_id = :stateId,
                        city_id = :cityId,
                        house_number = :houseNumber,
                        complement = :complement,
                        zip_code = :zipCode
                    WHERE id = :id";

            $statement = $this->pdo->prepare($sql);

            $statement->bindValue(":name", $user->getName(), \PDO::PARAM_STR);
            $statement->bindValue(":email", $user->getEmail(), \PDO::PARAM_STR);
            $statement->bindValue(":address", $user->getAddress(), \PDO::PARAM_STR);
            $statement->bindValue(":stateId", $user->getStateId(), \PDO::PARAM_INT);
            $statement->bindValue(":cityId", $user->getCityId(), \PDO::PARAM_INT);
            $statement->bindValue(":houseNumber", $user->getHouseNumber(), \PDO::PARAM_STR);
            $statement->bindValue(":complement", $user->getComplement(), \PDO::PARAM_STR);
            $statement->bindValue(":zipCode", $user->getZipCode(), \PDO::PARAM_STR);
            $statement->bindValue(":id", $user->getId(), \PDO::PARAM_INT);

            if (!$statement->execute()) {
                throw new \Exception("Não foi possível atualizar os dados do usuário no momento. Por favor, tente mais tarde.");
            }

            $result["message"] = "Usuário atualizados com sucesso.";

            return $result;

        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function updatePassword(UserModel $user): array
    {
        $result = [];

        try {
            $sql = "UPDATE users SET password = :password WHERE id = :id";

            $statement = $this->pdo->prepare($sql);

            $statement->bindValue(":password", $user->getPassword(), \PDO::PARAM_STR);
            $statement->bindValue(":id", $user->getId(), \PDO::PARAM_INT);

            if (!$statement->execute()) {
                throw new \Exception("Não foi possível atualizar a senha, tente novamente mais tarde.");
            }

            $result["message"] = "Senha atualizada com sucesso.";

            return $result;
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}