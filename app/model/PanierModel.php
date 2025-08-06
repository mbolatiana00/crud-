<?php

namespace App\model;

use Database\DBConnection;
use App\entity\PanierEntity;

class PanierModel
{
    private \PDO $pdo;

    public function __construct(DBConnection $pdo)
    {
        $this->pdo = $pdo->getPDO();
    }

    public function ajouterAuPanier(int $user_id, int $product_id, int $quantity): void
    {
        $stmt = $this->pdo->prepare("SELECT id, quantity FROM panier WHERE user_id = ? AND menu_item_id = ?");
        $stmt->execute([$user_id, $product_id]);
        $existing = $stmt->fetch();
        if ($existing) {
            $newQuantity = $existing['quantity'] + $quantity;
            $updateStmt = $this->pdo->prepare("UPDATE panier SET quantity = ? WHERE id = ?");
            $updateStmt->execute([$newQuantity, $existing['id']]);
        } else {
            $insertStmt = $this->pdo->prepare("INSERT INTO panier (user_id, menu_item_id, quantity) VALUES (?, ?, ?)");
            $insertStmt->execute([$user_id, $product_id, $quantity]);
        }
    }

    /**
     * Retourne un tableau d'objets PanierEntity avec les infos produit associées
     * 
     * @param int $user_id
     * @return PanierEntity[]
     */
    public function getPanierByUserId(int $user_id): array
    {
        $stmt = $this->pdo->prepare("
        SELECT p.id, p.user_id, p.menu_item_id AS product_id, p.quantity, 
               pr.name AS product_name, pr.price AS product_price, pr.description AS product_description
        FROM panier p
        JOIN menu_items pr ON p.menu_item_id = pr.id
        WHERE p.user_id = ?
    ");
        $stmt->execute([$user_id]);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        $panierItems = [];
        foreach ($rows as $row) {
            $panierItem = $this->hydrateEntity($row);
            $panierItems[] = $panierItem;
        }
        return $panierItems;
    }

    public function nombreDePannier(int $user_id): int
    {
        $stmt = $this->pdo->prepare("SELECT COALESCE(SUM(quantity), 0) as total FROM panier WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return (int) $stmt->fetchColumn();
    }

    public function supprimerUnPanier($user_id, $product_id){
        $stmt = $this->pdo->prepare("DELETE FROM panier WHERE user_id = ? AND menu_item_id = ?");
        $stmt->execute([$user_id, $product_id]);
    }

    public function viderPanier(int $user_id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM panier WHERE user_id = ?");
        $stmt->execute([$user_id]);
    }
    public function updateQuantity($user_id, $product_id, $quantity)
    {
        $stmt = $this->pdo->prepare("UPDATE panier SET quantity = ? WHERE user_id = ? AND menu_item_id = ?");
        $stmt->execute([$quantity, $user_id, $product_id]);
    }

    public function deleteFromPanier($user_id, $product_id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM panier WHERE user_id = ? AND menu_item_id = ?");
        $stmt->execute([$user_id, $product_id]);
    }
    // Dans PanierModel.php
    public function getTotalPanier(int $user_id): float
    {
        $stmt = $this->pdo->prepare("
        SELECT COALESCE(SUM(pr.price * p.quantity), 0) as total
        FROM panier p
        JOIN menu_items pr ON p.menu_item_id = pr.id
        WHERE p.user_id = ?
    ");
        $stmt->execute([$user_id]);
        return (float) $stmt->fetchColumn();
    }


    private function hydrateEntity(array $data): PanierEntity
    {
        $panier = new PanierEntity(
            (int)($data['id'] ?? 0),
            (int)($data['user_id'] ?? 0),
            (int)($data['product_id'] ?? 0),
            (int)($data['quantity'] ?? 1)
        );

        // On hydrate aussi les infos produit
        $panier->setProductName($data['product_name'] ?? null);
        $panier->setProductPrice(isset($data['product_price']) ? (float)$data['product_price'] : null);
        $panier->setProductDescription($data['product_description'] ?? null);

        return $panier;
    }
}
