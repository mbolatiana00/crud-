<?php

namespace App\model;

use Database\DBConnection;
use App\entity\CommandeEntity;

class CommandeModel
{
    private \PDO $pdo;

    public function __construct(DBConnection $db)
    {
        $this->pdo = $db->getPDO();
    }

    public function createFromPanier(int $user_id, array $panierData): int
    {
        $this->pdo->beginTransaction();

        try {
            // 1. Créer la commande principale
            $stmt = $this->pdo->prepare("
                INSERT INTO commandes 
                (user_id, table_number, mode_consommation, total)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([
                $user_id,
                $panierData['table_number'],
                $panierData['mode_consommation'],
                $panierData['total']
            ]);
            $commandeId = $this->pdo->lastInsertId();

            // 2. Ajouter les items
            $stmtItems = $this->pdo->prepare("
                INSERT INTO commandes_items
                (commande_id, menu_item_id, quantity, prix_unitaire)
                VALUES (?, ?, ?, ?)
            ");

            foreach ($panierData['items'] as $item) {
                $stmtItems->execute([
                    $commandeId,
                    $item['id'],
                    $item['quantity'],
                    $item['price'],
                    $item['name']
                ]);
            }

            $this->pdo->commit();
            return $commandeId;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
    public function getByUserId(int $user_id): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM commandes WHERE user_id = ? ORDER BY date_commande DESC");
        $stmt->execute([$user_id]);

        $commandes = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $commandes[] = $this->hydrate($row);
        }
        return $commandes;
    }

    private function hydrate(array $data): CommandeEntity
    {
        return new CommandeEntity(
            (int)$data['id'],
            (int)$data['user_id'],
            $data['table_number'],
            $data['date_commande'],
            $data['statut'],
            $data['mode_consommation'],
            $data['adresse_livraison'],
            (float)$data['total']
        );
    } public function getTotalPanier(int $user_id): float
    {
        $stmt = $this->pdo->prepare("
            SELECT SUM(pr.price * p.quantity) AS total
            FROM panier p
            JOIN menu_items pr ON p.menu_item_id = pr.id
            WHERE p.user_id = ?
        ");
        $stmt->execute([$user_id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return (float)($result['total'] ?? 0);
    }
    public function addItems(int $commande_id, array $items): void
    {
        $stmt = $this->pdo->prepare("
        INSERT INTO commandes_items 
        (commande_id, menu_item_id, quantity, prix_unitaire)
        VALUES (?, ?, ?, ?)
    ");

        foreach ($items as $item) {
            $stmt->execute([
                $commande_id,
                $item['menu_item_id'],
                $item['quantity'],
                $item['prix_unitaire']
            ]);
        }
    }
    public function getAllCommandes(): array
    {
        $stmt = $this->pdo->query("
        SELECT c.*, u.email  
        FROM commandes c
        LEFT JOIN users u ON c.user_id = u.id
        ORDER BY c.date_commande DESC
    ");

        return array_map([$this, 'hydrate'], $stmt->fetchAll(\PDO::FETCH_ASSOC));
    }

    public function findWithItems(int $id): ?array
    {
        // Commande principale
        $stmt = $this->pdo->prepare("
        SELECT c.*, u.email , u.email 
        FROM commandes c
        LEFT JOIN users u ON c.user_id = u.id
        WHERE c.id = ?
    ");
        $stmt->execute([$id]);
        $commande = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$commande) return null;

        // Items de la commande
        $stmtItems = $this->pdo->prepare("
        SELECT ci.*, mi.name 
        FROM commandes_items ci
        JOIN menu_items mi ON ci.menu_item_id = mi.id
        WHERE ci.commande_id = ?
    ");
        $stmtItems->execute([$id]);

        return [
            'commande' => $this->hydrate($commande),
            'items' => $stmtItems->fetchAll(\PDO::FETCH_ASSOC)
        ];
    }

    public function updateStatut(int $id, string $statut): bool
    {
        $stmt = $this->pdo->prepare("
        UPDATE commandes 
        SET statut = ?, updated_at = NOW() 
        WHERE id = ?
    ");
        return $stmt->execute([$statut, $id]);
    }

    public function getStats(): array
    {
        $stats = [];

        // Nombre de commandes par statut
        $stmt = $this->pdo->query("
        SELECT statut, COUNT(*) as count 
        FROM commandes 
        GROUP BY statut
    ");
        $stats['par_statut'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Chiffre d'affaires du jour
        $stmt = $this->pdo->query("
        SELECT COALESCE(SUM(total), 0) as ca 
        FROM commandes 
        WHERE DATE(date_commande) = CURDATE()
    ");
        $stats['ca_jour'] = $stmt->fetchColumn();

        return $stats;
    }
    public function create(array $data): int
    {

    $this->pdo->beginTransaction();
    
    try {
        
        $stmt = $this->pdo->prepare("
            INSERT INTO commandes (
                user_id, client_nom, client_email, client_telephone,
                mode_consommation, table_number, adresse_livraison, 
                commentaires, total
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $data['user_id'],
            $data['client_info']['nom'],
            $data['client_info']['email'],
            $data['client_info']['telephone'],
            $data['livraison']['mode'],
            $data['livraison']['table_number'],
            $data['livraison']['adresse'],
            $data['commentaires'],
            $data['total']
        ]);
        
        $commandeId = $this->pdo->lastInsertId();
        
      
        $stmtItems = $this->pdo->prepare("
            INSERT INTO commandes_items (
                commande_id, menu_item_id, quantity, prix_unitaire, item_name
            ) VALUES (?, ?, ?, ?, ?)
        ");

            foreach ($data['items'] as $item) {
                $stmtItems->execute([
                    $commandeId,
                    $item->getProductId(),
                    $item->getQuantity(),
                    $item->getProductPrice(),
                    $item->getProductName()         
                ]);
            }


            $this->pdo->commit();
        return $commandeId;
        
    } catch (\Exception $e) {
        $this->pdo->rollBack();
        throw $e;
    }
}

public function findForUser(int $commandeId, int $userId): ?CommandeEntity
{
    $stmt = $this->pdo->prepare("
        SELECT c.* 
        FROM commandes c
        WHERE c.id = ? AND c.user_id = ?
    ");
    $stmt->execute([$commandeId, $userId]);
    
    return ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) 
        ? $this->hydrate($data) 
        : null;
}
    public function validerCommande(int $id): bool
    {
        // Mise à jour du statut
        $sql = "UPDATE commandes SET statut = 'pret' WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(['id' => $id]);

        if ($result) {
            // Récupérer email client pour notification
            $stmtEmail = $this->pdo->prepare("
            SELECT u.email, c.id, c.total 
            FROM commandes c 
            JOIN users u ON c.user_id = u.id
            WHERE c.id = :id
        ");
            $stmtEmail->execute(['id' => $id]);
            $user = $stmtEmail->fetch(\PDO::FETCH_ASSOC);

            if ($user) {
               
                $to = $user['email'];
                $subject = "Votre commande est prête";
                $message = "Bonjour,\n\nVotre commande #{$user['id']} est prête. Veuillez procéder au paiement de {$user['total']}.\n\nMerci.";
                $headers = "From: resto.test\r\n";

                mail($to, $subject, $message, $headers);
            }
        }

        return $result;
    }
 
}