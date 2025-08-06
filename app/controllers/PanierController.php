<?php

namespace App\controllers;

use App\model\PanierModel;
use Database\DBConnection;
use App\Controllers\Controller;

class PanierController extends Controller
{
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user']['id'] ?? 0;
            $product_id = $_POST['product_id'] ?? null;
            $quantity = $_POST['quantity'] ?? 1;

            if ($user_id && $product_id) {
                $panierModel = new PanierModel($this->getDB());
               
                $panierModel->ajouterAuPanier($user_id, $product_id, $quantity);
              
                header('Location: /products');
                exit;
            }
        }

      
        return $this->view('panier.add', []);
    }

    public function index()
    {
        $user_id = $_SESSION['user']['id'] ?? 0;
        $panierModel = new PanierModel($this->getDB());
        $items = $panierModel->getPanierByUserId($user_id);
        $total = $panierModel->getTotalPanier($user_id); // Calcul du total

        return $this->view('panier.index', ['items' => $items, 'total' => $total 
       ]);
    }
    public function vider()
    {
        $user_id = $_SESSION['user']['id'] ?? null;
        if (!$user_id) return header('Location: /login');

      
        $panierModel = new PanierModel($this->getDB());
        $panierModel->viderPanier($user_id);

        header('Location: /panier');
        exit;
    }

    public function viderUnSeul(){
        $product_id = $_POST['product_id'];
        $user_id = $_SESSION['user']['id'] ?? null;
        if(!$user_id) return header('Location:/login');
        $panierModel = new PanierModel($this->getDB());
        $panierModel->supprimerUnPanier($user_id, $product_id);
        header('Location: /panier');
        exit;
    }


    public function count()
    {
        $user_id = $_SESSION['user']['id'] ?? 0;
        $panierModel = new PanierModel($this->getDB());
        $count = $panierModel->nombreDePannier($user_id);
        echo json_encode(['count' => $count]);
    }
}
