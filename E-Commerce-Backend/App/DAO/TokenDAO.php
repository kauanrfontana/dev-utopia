<?php
namespace App\DAO;


use App\DAO\Connection;
use App\Models\TokenModel;



class TokenDAO extends Connection
{

    public function __construct()
    {
        parent::__construct();
    }

    public function createToken(TokenModel $token): void
    {
        $sql = "INSERT INTO tokens (user_id, token, refresh_token, expired_at)
                VALUES (
                    :user_id,
                    :token,
                    :refresh_token,
                    CONVERT(datetime, :expired_at, 120)
                )";
        $statement = $this->pdo->prepare($sql);

        $statement->bindValue(":user_id", $token->getUserId(), \PDO::PARAM_INT);
        $statement->bindValue(":token", $token->getToken(), \PDO::PARAM_STR);
        $statement->bindValue(":refresh_token", $token->getRefreshToken(), \PDO::PARAM_STR);
        $statement->bindValue(":expired_at", $token->getExpiredAt(), \PDO::PARAM_STR);

        $statement->execute();
    }

    public function verifyRefreshToken(string $refreshToken): bool
    {
        $sql = "SELECT id FROM [tokens] 
                WHERE refresh_token = :refresh_token AND active = 1";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(":refresh_token", $refreshToken, \PDO::PARAM_STR);
        
        $statement->execute();

        $tokens = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return count($tokens) > 0;
    }

    public function deactiveToken(string $refresh_token): void
    {
        $sql = "UPDATE tokens 
                SET active = 0 
                WHERE refresh_token = :refresh_token";

        $statement = $this->pdo->prepare($sql);

        $statement->bindParam(":refresh_token", $refresh_token, \PDO::PARAM_STR);

        $statement->execute();
    }


}