<?php


namespace App\entity;

class ProductEntity
{
    private $id;
    private $name;
    private $description;
    private $price;
    private $category;

    public function __construct($id, $name, $description, $price, $category)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->category = $category;
    }

    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getDescription() { return $this->description; }
    public function getPrice() { return $this->price; }
    public function getCategory() { return $this->category; }
}