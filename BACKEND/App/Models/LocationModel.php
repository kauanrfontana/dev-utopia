<?php

namespace App\Models;

final class LocationModel
{
    private int $id;
    private int $country;
    private int $state;
    private int $city;
    private int $neighborhood;
    private int $streetAvenue;
    private string $houseNumber;
    private string $complement;
    private string $zipCode;



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
     * Get the value of country
     *
     * @return int
     */
    public function getCountry(): int
    {
        return $this->country;
    }

    /**
     * Set the value of country
     *
     * @param int $country
     *
     * @return self
     */
    public function setCountry(int $country): self
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Get the value of state
     *
     * @return int
     */
    public function getState(): int
    {
        return $this->state;
    }

    /**
     * Set the value of state
     *
     * @param int $state
     *
     * @return self
     */
    public function setState(int $state): self
    {
        $this->state = $state;
        return $this;
    }

    /**
     * Get the value of city
     *
     * @return int
     */
    public function getCity(): int
    {
        return $this->city;
    }

    /**
     * Set the value of city
     *
     * @param int $city
     *
     * @return self
     */
    public function setCity(int $city): self
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Get the value of neighborhood
     *
     * @return int
     */
    public function getNeighborhood(): int
    {
        return $this->neighborhood;
    }

    /**
     * Set the value of neighborhood
     *
     * @param int $neighborhood
     *
     * @return self
     */
    public function setNeighborhood(int $neighborhood): self
    {
        $this->neighborhood = $neighborhood;
        return $this;
    }

    /**
     * Get the value of streetAvenue
     *
     * @return int
     */
    public function getStreetAvenue(): int
    {
        return $this->streetAvenue;
    }

    /**
     * Set the value of streetAvenue
     *
     * @param int $streetAvenue
     *
     * @return self
     */
    public function setStreetAvenue(int $streetAvenue): self
    {
        $this->streetAvenue = $streetAvenue;
        return $this;
    }

    /**
     * Get the value of houseNumber
     *
     * @return string
     */
    public function getHouseNumber(): string
    {
        return $this->houseNumber;
    }

    /**
     * Set the value of houseNumber
     *
     * @param string $houseNumber
     *
     * @return self
     */
    public function setHouseNumber(string $houseNumber): self
    {
        $this->houseNumber = $houseNumber;
        return $this;
    }

    /**
     * Get the value of complement
     *
     * @return string
     */
    public function getComplement(): string
    {
        return $this->complement;
    }

    /**
     * Set the value of complement
     *
     * @param string $complement
     *
     * @return self
     */
    public function setComplement(string $complement): self
    {
        $this->complement = $complement;
        return $this;
    }

    /**
     * Get the value of zipCode
     *
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    /**
     * Set the value of zipCode
     *
     * @param string $zipCode
     *
     * @return self
     */
    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;
        return $this;
    }
}