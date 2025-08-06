<?php

namespace App\entity;

class UserEntity
{
    private ?int $id;
    private string $nom;
    private string $prenom;
    private string $email;
    private string $password;
    private string $role;
    private ?string $adresse;
    private ?string $telephone;
    private ?string $created_at;

    public function __construct(
        ?int $id = null,
        string $nom = '',
        string $prenom = '',
        string $email = '',
        string $password = '',
        string $role = 'client',
        ?string $adresse = null,
        ?string $telephone = null,
        ?string $created_at = null
    ) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->adresse = $adresse;
        $this->telephone = $telephone;
        $this->created_at = $created_at;
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getNom(): string
    {
        return $this->nom;
    }
    public function getPrenom(): string
    {
        return $this->prenom;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function getRole(): string
    {
        return $this->role;
    }
    public function getAdresse(): ?string
    {
        return $this->adresse;
    }
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }
    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    // Setters
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    public function setRole(string $role): void
    {
        $this->role = $role;
    }
    public function setAdresse(?string $adresse): void
    {
        $this->adresse = $adresse;
    }
    public function setTelephone(?string $telephone): void
    {
        $this->telephone = $telephone;
    }
    public function setCreatedAt(?string $created_at): void
    {
        $this->created_at = $created_at;
    }
}
