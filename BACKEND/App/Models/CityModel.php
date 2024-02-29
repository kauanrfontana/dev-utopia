<?php

namespace App\Models;

final class CityModel
{
    private int $id;
    private int $stateId;
    private string $name;



    /**
     * Get the value of id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
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
     * Get the value of stateId
     *
     * @return int
     */
    public function getStateId(): int
    {
        return $this->stateId;
    }

    /**
     * Set the value of stateId
     *
     * @param int $stateId
     *
     * @return self
     */
    public function setStateId(int $stateId): self
    {
        $this->stateId = $stateId;
        return $this;
    }

    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

}