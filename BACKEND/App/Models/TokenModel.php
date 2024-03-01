<?php

namespace App\Models;

final class TokenModel
{
    private int $id;
    private string $token;
    private string $refreshToken;
    private string $expired_at;
    private int $user_id;


    /**
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     *
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     *
     * @param string $token
     *
     * @return self
     */
    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    /**
     *
     * @param string $refreshToken
     *
     * @return self
     */
    public function setRefreshToken(string $refreshToken): self
    {
        $this->refreshToken = $refreshToken;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getExpiredAt(): string
    {
        return $this->expired_at;
    }

    /**
     *
     * @param string $expired_at
     *
     * @return self
     */
    public function setExpiredAt(string $expired_at): self
    {
        $this->expired_at = $expired_at;
        return $this;
    }

    /**
     *
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     *
     * @param int $user_id
     *
     * @return self
     */
    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;
        return $this;
    }
}