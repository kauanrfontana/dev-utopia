<?php

namespace App\Models;

final class ReviewModel
{
    private int $id;
    private int $stars;
    private string $review;
    private int $productId;
    private int $userId;
    private \DateTime $creadedAt;
    private \DateTime $updatedAt;




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
     * Get the value of stars
     *
     * @return int
     */
    public function getStars(): int
    {
        return $this->stars;
    }

    /**
     * Set the value of stars
     *
     * @param int $stars
     *
     * @return self
     */
    public function setStars(int $stars): self
    {
        $this->stars = $stars;
        return $this;
    }

    /**
     * Get the value of review
     *
     * @return string
     */
    public function getReview(): string
    {
        return $this->review;
    }

    /**
     * Set the value of review
     *
     * @param string $review
     *
     * @return self
     */
    public function setReview(string $review): self
    {
        $this->review = $review;
        return $this;
    }

    /**
     * Get the value of productId
     *
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * Set the value of productId
     *
     * @param int $productId
     *
     * @return self
     */
    public function setProductId(int $productId): self
    {
        $this->productId = $productId;
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
     * Get the value of creadedAt
     *
     * @return \DateTime
     */
    public function getCreadedAt(): \DateTime
    {
        return $this->creadedAt;
    }

    /**
     * Set the value of creadedAt
     *
     * @param \DateTime $creadedAt
     *
     * @return self
     */
    public function setCreadedAt(\DateTime $creadedAt): self
    {
        $this->creadedAt = $creadedAt;
        return $this;
    }

    /**
     * Get the value of updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return self
     */
    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}