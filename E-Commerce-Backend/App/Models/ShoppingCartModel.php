<?php

namespace App\Models;

final class ShoppingCartModel
{
    private int $userId;
    private array $products;
    private int $qtdProducts;
    private float $totalPrice;




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
     * Get the value of products
     *
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * Set the value of products
     *
     * @param array $products
     *
     * @return self
     */
    public function setProducts(array $products): self
    {
        $this->products = $products;
        return $this;
    }

    /**
     * Get the value of qtdProducts
     *
     * @return int
     */
    public function getQtdProducts(): int
    {
        return $this->qtdProducts;
    }

    /**
     * Set the value of qtdProducts
     *
     * @param int $qtdProducts
     *
     * @return self
     */
    public function setQtdProducts(int $qtdProducts): self
    {
        $this->qtdProducts = $qtdProducts;
        return $this;
    }

    /**
     * Get the value of totalPrice
     *
     * @return float
     */
    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }

    /**
     * Set the value of totalPrice
     *
     * @param float $totalPrice
     *
     * @return self
     */
    public function setTotalPrice(float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;
        return $this;
    }
}