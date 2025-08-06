<?php

namespace App\model;

use PDO;
use App\entity\UserEntity;
use Database\DBConnection;

class UserModel
{
    private $pdo;

    public function __construct(DBConnection $db)
    {
        $this->pdo = $db->getPDO();
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM users");
        $users = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = $this->hydrate($data);
        }

        return $users;
    }

    public function findById(int $id): ?UserEntity
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $data ? $this->hydrate($data) : null;
    }

    public function create(
        string $nom,
        string $prenom,
        string $email,
        string $password,
        ?string $adresse = null,
        ?string $telephone = null,
        string $role = 'client'
    ): bool {
        $stmt = $this->pdo->prepare("
            INSERT INTO users 
            (nom, prenom, email, password, role, adresse, telephone) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        return $stmt->execute([
            $nom,
            $prenom,
            $email,
            $hashedPassword,
            $role,
            $adresse,
            $telephone
        ]);
    }

    public function update(UserEntity $user): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE users SET 
            nom = ?, 
            prenom = ?, 
            email = ?, 
            password = ?, 
            role = ?, 
            adresse = ?, 
            telephone = ? 
            WHERE id = ?
        ");

        return $stmt->execute([
            $user->getNom(),
            $user->getPrenom(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getRole(),
            $user->getAdresse(),
            $user->getTelephone(),
            $user->getId()
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function findByEmail(string $email): ?UserEntity
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $data ? $this->hydrate($data) : null;
    }

    private function hydrate(array $data): UserEntity
    {
        return new UserEntity(
            (int)$data['id'],
            $data['nom'],
            $data['prenom'],
            $data['email'],
            $data['password'],
            $data['role'],
            $data['adresse'] ?? null,
            $data['telephone'] ?? null,
            $data['created_at'] ?? null
        );
    }
    public function save(UserEntity $user): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $user->getNom(),
            $user->getPrenom(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getRole()
        ]);
    }
}
