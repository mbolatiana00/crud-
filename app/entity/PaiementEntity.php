<?php

namespace App\entity;

class PaiementEntity
{
    private int $id;
    private int $commande_id;
    private int $user_id;
    private ?int $admin_id;
    private float $amount;
    private string $payment_method;
    private string $payment_date;
    private string $statut;

    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getCommandeId(): int
    {
        return $this->commande_id;
    }
    public function setCommandeId(int $commande_id)
    {
        $this->commande_id = $commande_id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }
    public function setUserId(int $user_id)
    {
        $this->user_id = $user_id;
    }

    public function getAdminId(): ?int
    {
        return $this->admin_id;
    }
    public function setAdminId(?int $admin_id)
    {
        $this->admin_id = $admin_id;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
    public function setAmount(float $amount)
    {
        $this->amount = $amount;
    }

    public function getPaymentMethod(): string
    {
        return $this->payment_method;
    }
    public function setPaymentMethod(string $method)
    {
        $this->payment_method = $method;
    }

    public function getPaymentDate(): string
    {
        return $this->payment_date;
    }
    public function setPaymentDate(string $date)
    {
        $this->payment_date = $date;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }
    public function setStatut(string $statut)
    {
        $this->statut = $statut;
    }
}
