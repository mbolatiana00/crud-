<?php
namespace App\controllers;

use App\Controllers\Controller;
use App\model\CommandeModel;

class HistoriqueCommandeController extends Controller{

    public function index(){

        $stmt = new CommandeModel($this->getDB());
        $historiques = $stmt->getAllCommandes();
    
        return $this->view('historique.commandes', ['historiques' => $historiques ]);
    }
}