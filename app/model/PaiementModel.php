<?php

namespace App\model;

use App\entity\PaiementEntity;
use Database\DBConnection;
use PDO;

class PaiementModel
{
    private  $pdo;

    public function __construct(DBConnection $pdo)
    {
        $this->pdo = $pdo->getPDO();
    }

    public function create(array $data): int
    {
        $sql = "INSERT INTO paiements (commande_id, user_id, admin_id, amount, payment_method, payment_date, statut)
                VALUES (:commande_id, :user_id, :admin_id, :amount, :payment_method, :payment_date, :statut)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $this->pdo->lastInsertId();
    }

    public function findById(int $id): ?PaiementEntity
    {
        $stmt = $this->pdo->prepare("SELECT * FROM paiements WHERE id = ?");
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, PaiementEntity::class);
        return $stmt->fetch() ?: null;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM paiements ORDER BY payment_date DESC");
        return $stmt->fetchAll(PDO::FETCH_CLASS, PaiementEntity::class);
    }

    public function updateStatut(int $id, string $statut): bool
    {
        $stmt = $this->pdo->prepare("UPDATE paiements SET statut = :statut WHERE id = :id");
        return $stmt->execute(['statut' => $statut, 'id' => $id]);
    }
}
