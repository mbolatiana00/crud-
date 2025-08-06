<?php

namespace App\entity;

class PanierEntity
{
    private int $id;
    private int $user_id;
    private int $product_id;
    private int $quantity;

   
    private ?string $product_name = null;
    private ?string $product_description = null;
    private ?float $product_price = null;

    public function __construct(int $id = 0, int $user_id = 0, int $product_id = 0, int $quantity = 1)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->product_id = $product_id;
        $this->quantity = $quantity;
    }

    

    public function getId(): int
    {
        return $this->id;
    }
    public function getUserId(): int
    {
        return $this->user_id;
    }
    public function getProductId(): int
    {
        return $this->product_id;
    }
    public function getQuantity(): int
    {
        return $this->quantity;
    }
    public function setUserId(int $id): void
    {
        $this->user_id = $id;
    }
    public function setProductId(int $id): void
    {
        $this->product_id = $id;
    }
    public function setQuantity(int $q): void
    {
        $this->quantity = $q;
    }

    
    public function getProductName(): ?string
    {
        return $this->product_name;
    }
    public function setProductName(string $name): void
    {
        $this->product_name = $name;
    }

    public function getProductDescription(): ?string
    {
        return $this->product_description;
    }
    public function setProductDescription(string $description): void
    {
        $this->product_description = $description;
    }

    public function getProductPrice(): ?float
    {
        return $this->product_price;
    }
    public function setProductPrice(float $price): void
    {
        $this->product_price = $price;
    }
}
