<?php

namespace App\Models\Locations;

final class NeighborhoodModel
{
    private int $id;
    private int $cityId;
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
     * Get the value of cityId
     *
     * @return int
     */
    public function getCityId(): int
    {
        return $this->cityId;
    }

    /**
     * Set the value of cityId
     *
     * @param int $cityId
     *
     * @return self
     */
    public function setCityId(int $cityId): self
    {
        $this->cityId = $cityId;
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