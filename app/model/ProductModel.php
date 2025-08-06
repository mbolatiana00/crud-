<?php

namespace App\model;

use App\entity\ProductEntity;
use Database\DBConnection;

class ProductModel
{
    private $pdo;

    public function __construct(DBConnection $db)
    {
        $this->pdo = $db->getPDO();
    }

    public function getAll(): array
    {
        $query = "SELECT id, name, description, price, category FROM menu_items";
        $stmt = $this->pdo->query($query);

        if (!$stmt) {
            error_log("Erreur dans la requête SQL: " . print_r($this->pdo->errorInfo(), true));
            return [];
        }

        $products = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $products[] = $this->hydrate($row);
        }

        return $products;
    }

    protected function hydrate(array $data): ProductEntity
    {
        return new ProductEntity(
            $data['id'],
            $data['name'],
            $data['description'],
            $data['price'],
            $data['category']
        );
    }

    public function findById(int $id): ?ProductEntity
    {
        try {
            $stmt = $this->pdo->prepare("SELECT id, name, description, price, category FROM menu_items WHERE id = ?");
            $stmt->execute([$id]);
            return ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) ? $this->hydrate($data) : null;
        } catch (\PDOException $e) {
            error_log('ProductModel findById error: ' . $e->getMessage());
            return null;
        }
    }
}
