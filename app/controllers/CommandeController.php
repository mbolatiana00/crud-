<?php

namespace App\controllers;

use App\model\{CommandeModel, PanierModel};

class CommandeController extends Controller
{
    public function index()
    {
        $this->guard();

        $panierModel = new PanierModel($this->getDB());
        $items = $panierModel->getPanierByUserId($_SESSION['user']['id']);

        if (empty($items)) {
           return $this->view('panier.index');
        }

        return $this->view('commande.index', [
            'items' => $items,
            'total' => $panierModel->getTotalPanier($_SESSION['user']['id']),
            'user' => $_SESSION['user']
        ]);
    }

    public function valider()
    {
        $this->guard();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->view('commande.valider');
          
        }

      

        try {
            $data = $this->validateCommandeData($_POST);
            $commandeId = $this->processCommande($data);
           
         
            header('Location:confirmation/' . $commandeId);
            exit;
        } catch (\Exception $e) {
            return $this->reshowFormWithError($e->getMessage(), $_POST);
        }
    }

    private function validateCommandeData(array $post): array
    {
        $required = ['nom', 'email', 'mode_consommation'];
        foreach ($required as $field) {
            if (empty($post[$field])) {
                throw new \Exception("Le champ $field est requis");
            }
        }

        $mode = $post['mode_consommation'];
        if (!in_array($mode, ['sur_place', 'a_emporter', 'livraison'])) {
            throw new \Exception("Mode de consommation invalide");
        }

        return [
            'user_id' => $_SESSION['user']['id'],
            'client_info' => [
                'nom' => $post['nom'],
                'email' => $post['email'],
                'telephone' => $post['telephone'] ?? null
            ],
            'livraison' => [
                'mode' => $mode,
                'table_number' => ($mode === 'sur_place') ? ($post['table_number'] ?? null) : null,
                'adresse' => ($mode === 'livraison') ? ($post['adresse'] ?? null) : null
            ],
            'commentaires' => $post['commentaires'] ?? null
        ];
    }

    private function processCommande(array $data): int
    {
        $panierModel = new PanierModel($this->getDB());
        $items = $panierModel->getPanierByUserId($data['user_id']);

        if (empty($items)) {
            throw new \Exception("Votre panier est vide");
        }

        $commandeModel = new CommandeModel($this->getDB());
        $commandeId = $commandeModel->create([
            ...$data,
            'items' => $items,
            'total' => $panierModel->getTotalPanier($data['user_id'])
        ]);

        $panierModel->viderPanier($data['user_id']);
        return $commandeId;
    }

    private function reshowFormWithError(string $error, array $formData)
    {
        $panierModel = new PanierModel($this->getDB());

        return $this->view('commande.index', [
            'items' => $panierModel->getPanierByUserId($_SESSION['user']['id']),
            'total' => $panierModel->getTotalPanier($_SESSION['user']['id']),
            'user' => $_SESSION['user'],
            'error' => $error,
            'form_data' => $formData
        ]);
    }

    public function confirmation(int $id)
    {
        $commandeModel = new CommandeModel($this->getDB());
        $commandes = $commandeModel->findForUser($id, $_SESSION['user']['id'] ?? 0);

        if (!$commandes) {
           return $this->view('/');
        }
   
        return $this->view('commande.confirmation', [
                'commande' => $commandes,
                'id' => $id,                
                
            ]
    );
    }
    public function updateStatut(int $id)
    {
        $this->guard(); // Vérifie que l'utilisateur est connecté

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newStatut = $_POST['statut'] ?? null;

            if (!in_array($newStatut, ['en_attente', 'preparation', 'pret', 'termine', 'livre', 'annule'])) {
                $_SESSION['flash']['error'] = "Statut invalide.";
                header("Location: /commande/confirmation/$id");
                exit;
            }

            $commandeModel = new CommandeModel($this->getDB());
            $commande = $commandeModel->findForUser($id, $_SESSION['user']['id'] ?? 0);

            if (!$commande) {
                $_SESSION['flash']['error'] = "Commande introuvable.";
                header("Location: /commande/confirmation/$id");
                exit;
            }

            $commandeModel->updateStatut($id, $newStatut);

            $_SESSION['flash']['success'] = "Statut mis à jour avec succès.";
            header("Location: /commande/confirmation/$id");
            exit;
        }
    }
}
