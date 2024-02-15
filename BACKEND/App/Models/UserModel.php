<?php

namespace App\Models;

final class UserModel
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private \DateTime $created_at;

    private int $location_id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at->format('Y-m-d H:i:s');
    }

    public function setCreatedAt(string $created_at): self
    {
        $this->created_at = new \DateTime($created_at);
        return $this;
    }

    public function getLocationId(): int
    {
        return $this->location_id;
    }

    public function setLocationId(int $location_id): self
    {
        $this->location_id = $location_id;
        return $this;
    }
}