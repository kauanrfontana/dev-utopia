<?php

namespace App\Services;

use App\DAO\TokenDAO;
use App\DAO\UserDAO;
use App\Models\TokenModel;
use App\Models\UserModel;
use Firebase\JWT\JWT;

class AuthService
{
    public static function encodeToken($token): string
    {
        try {
            $KEY = JWT_SECRET_KEY;
            return JWT::encode($token, $KEY);

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function decodeToken(string $token): object
    {
        try {
            $KEY = JWT_SECRET_KEY;
            return JWT::decode(
                $token,
                $KEY,
                ["HS256"]
            );

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function setTokens(UserModel $usuario): array
    {
        $expiredAt = (new \DateTime())->modify("+1 hour")->format("Y-m-d H:i:s");

        $tokenPayload = [
            "sub" => $usuario->getId(),
            "nome" => $usuario->getName(),
            "email" => $usuario->getEmail(),
            "exp" => (new \DateTime($expiredAt))->getTimestamp()
        ];

        $token = self::encodeToken($tokenPayload);

        $refreshTokenPayload = [
            "email" => $usuario->getEmail(),
            "random" => uniqid()
        ];

        $refreshToken = self::encodeToken($refreshTokenPayload);

        $tokenModel = new TokenModel();
        $tokenModel->setExpiredAt($expiredAt)
            ->setToken($token)
            ->setRefreshToken($refreshToken)
            ->setUserId($usuario->getId());

        $tokenDAO = new TokenDAO();
        $tokenDAO->createToken($tokenModel);

        return [
            "token" => $token,
            "refresh_token" => $refreshToken
        ];
    }

    public static function refreshToken(string $refreshToken): array
    {

        $refreshTokenDecoded = self::decodeToken($refreshToken);

        $tokenDAO = new tokenDAO();

        $refreshTokenExists = $tokenDAO->verifyRefreshToken($refreshToken);

        if (!$refreshTokenExists)
            return [];

        $userDAO = new userDAO();
        $usuario = $userDAO->getUserByEmail($refreshTokenDecoded->email);
        if (is_null($usuario))
            return [];


        $result = self::setTokens($usuario);
        $tokenDAO->deactiveToken($refreshToken);

        return $result;
    }


}