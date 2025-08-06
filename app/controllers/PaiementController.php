<?php

namespace App\controllers;

use App\Controllers\Controller;
use App\model\PaiementModel;
use Database\DBConnection;

class PaiementController extends Controller
{
    protected $paiementModel;


    public function index()
    { 
        $this->paiementModel =   new PaiementModel($this->getDB());
        $paiements = $this->paiementModel->findAll();
        var_dump($paiements);
        exit;
        return $this->view('paiement.paiment', ['paiements' => $paiements]);
        
    }

    public function store()
    {
        $data = [
            'commande_id' => $_POST['commande_id'],
            'user_id' => $_POST['user_id'],
            'admin_id' => null,
            'amount' => $_POST['amount'],
            'payment_method' => $_POST['payment_method'],
            'payment_date' => date('Y-m-d H:i:s'),
            'statut' => 'en_attente'
        ];
        $this->paiementModel->create($data);
        header('Location: /paiement');
    }

    public function valider(int $id)
    {
        $this->paiementModel->updateStatut($id, 'validé');
        header('Location: /paiement');
    }

    public function rejeter(int $id)
    {
        $this->paiementModel->updateStatut($id, 'rejeté');
        header('Location: /paiement');
    }
}
