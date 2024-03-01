<?php

namespace App\Models\Locations;

final class StateModel
{
    private int $id;
    private int $countryId;
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
     * Get the value of countryId
     *
     * @return int
     */
    public function getCountryId(): int
    {
        return $this->countryId;
    }

    /**
     * Set the value of countryId
     *
     * @param int $countryId
     *
     * @return self
     */
    public function setCountryId(int $countryId): self
    {
        $this->countryId = $countryId;
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