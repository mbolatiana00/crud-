<?php

namespace App\entity;

class CommandeEntity
{
    private int $id;
    private int $user_id;
    private ?string $table_number;
    private string $date_commande;
    private string $statut; // "en_attente", "preparation", "termine", "annule"
    private string $mode_consommation; // "sur_place", "a_emporter", "livraison"
    private ?string $adresse_livraison;
    private float $total;
    private ?string $client_email = null;
   



    public function __construct(
        int $id,
        int $user_id,
        ?string $table_number,
        string $date_commande,
        string $statut,
        string $mode_consommation,
        ?string $adresse_livraison,
        float $total
    ) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->table_number = $table_number;
        $this->date_commande = $date_commande;
        $this->statut = $statut;
        $this->mode_consommation = $mode_consommation;
        $this->adresse_livraison = $adresse_livraison;
        $this->total = $total;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getUserId(): int
    {
        return $this->user_id;
    }
    public function getTableNumber(): ?string
    {
        return $this->table_number;
    }
    public function getDateCommande(): string
    {
        return $this->date_commande;
    }
    public function getStatut(): string
    {
        return $this->statut;
    }
    public function getModeConsommation(): string
    {
        return $this->mode_consommation;
    }
    public function getAdresseLivraison(): ?string
    {
        return $this->adresse_livraison;
    }
 
    public function setStatut(string $statut): void
    {
        $this->statut = $statut;
    }

    public function setModeConsommation(string $mode_consommation): void
    {
        $this->mode_consommation = $mode_consommation;
    }

    public function setAdresseLivraison(?string $adresse_livraison): void
    {
        $this->adresse_livraison = $adresse_livraison;
    }


    public function setClientEmail(string $email): void
    {
        $this->client_email = $email;
    }
    public function getClientEmail(): ?string
    {
        return $this->client_email;
    }
  
    

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): void
    {
        $this->total = $total;
    }
}
    
