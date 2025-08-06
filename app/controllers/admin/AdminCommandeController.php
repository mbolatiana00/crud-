<?php

namespace App\controllers\admin;

use App\controllers\Controller;
use App\model\CommandeModel;

class AdminCommandeController extends Controller
{
    public function valider(int $id)
    {
        $commandeModel = new CommandeModel($this->getDB()); 

        $success = $commandeModel->validerCommande($id);

        if ($success) {
            $_SESSION['flash']['success'] = "Commande #$id validée avec succès.";
        } else {
            $_SESSION['flash']['error'] = "Erreur lors de la validation de la commande.";
        }

        header('Location: /admin');
        exit();
        $this->view('admin.index', ['commandes' => $commandes]);
    }
}
