<?php

namespace App\Models;

final class ProductModel
{
    private int $id;
    private int $userId;
    private string $name;
    private float $price;
    private string $description;
    private string $urlImage;
    private \DateTime $created_at;
    private int $cityId;
    private int $stateId;
    private string $address;
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
     * Get the value of userId
     *
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @param int $userId
     *
     * @return self
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

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

    /**
     * Get the value of price
     *
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @param float $price
     *
     * @return self
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    /**
     * Get the value of description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param string $description
     *
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get the value of urlImage
     *
     * @return string
     */
    public function getUrlImage(): string
    {
        return $this->urlImage;
    }

    /**
     * Set the value of urlImage
     *
     * @param string $urlImage
     *
     * @return self
     */
    public function setUrlImage(string $urlImage): self
    {
        $this->urlImage = $urlImage;
        return $this;
    }

    /**
     * Get the value of created_at
     *
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @param \DateTime $created_at
     *
     * @return self
     */
    public function setCreatedAt(\DateTime $created_at): self
    {
        $this->created_at = $created_at;
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
     * Get the value of address
     *
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @param string $address
     *
     * @return self
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;
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