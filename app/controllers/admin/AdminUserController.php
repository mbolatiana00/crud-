<?php

namespace App\controllers\admin;

use App\controllers\Controller;
use App\model\UserModel;
use App\entity\UserEntity;
use App\model\CommandeModel;
use App\entity\CommandeEntity;

class AdminUserController extends Controller
{
    public function index()
    {
        $this->isAdmin();

        $userModel = new UserModel($this->getDB());
        $users = $userModel->findAll();

        $commandeModel = new CommandeModel($this->getDB());
        $commandes = $commandeModel->getAllCommandes();

        // Filtrer les commandes en attente
        $commandesEnAttente = array_filter($commandes, function ($commande) {
            return $commande->getStatut() === 'en_attente';
        });

        return $this->view('admin.index', [
            'users' => $users,
            'commandes' => $commandesEnAttente
        ]);
    }

    public function addForm()
    {
        return $this->view('admin.admin_add_user');
    }

    public function updateRole(int $id)
    {
        $this->isAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newRole = $_POST['role'] ?? null;
            $validRoles = ['admin', 'client', 'serveur', 'cuisinier'];

            if (!in_array($newRole, $validRoles)) {
                $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Rôle invalide.'];
                header('Location: /admin/users');
                exit();
            }

            if ($_SESSION['user']['id'] == $id && $newRole !== 'admin') {
                $_SESSION['flash'] = [
                    'type' => 'danger',
                    'message' => 'Vous ne pouvez pas modifier votre propre rôle.'
                ];
                header('Location: /admin/users');
                exit();
            }

            $userModel = new UserModel($this->getDB());
            $user = $userModel->findById($id);
            if ($user) {
                $user->setRole($newRole);
                $userModel->update($user);
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => "Rôle mis à jour pour {$user->getEmail()}"
                ];
            }
        }

        header('Location: /admin/users');
        exit();
    }

    public function delete(int $id)
    {
        $this->isAdmin();

        if ($_SESSION['user']['id'] == $id) {
            $_SESSION['flash'] = [
                'type' => 'danger',
                'message' => 'Vous ne pouvez pas supprimer votre propre compte.'
            ];
            header('Location: /admin/users');
            exit();
        }

        $userModel = new UserModel($this->getDB());
        $userModel->delete($id);

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Utilisateur supprimé.'];
        header('Location: /admin/users');
        exit();
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $role = $_POST['role'];

            $user = new UserEntity(null, $nom, $prenom, $email, $password, $role);
            $userModel = new UserModel($this->getDB());
            $userModel->save($user);

            header("Location: /admin");
            exit;
        }
    }

    public function validerCommande(int $id)
    {
        $this->isAdmin();

        $commandeModel = new CommandeModel($this->getDB());
        $commandeData = $commandeModel->findWithItems($id);

        if ($commandeData && $commandeData['commande']) {
            $commande = $commandeData['commande'];
            $commandeModel->updateStatut($id, 'validée');
            $this->envoyerEmailConfirmation($commande, $commandeData['items']);
            $_SESSION['flash'] = [
                'type' => 'success',
                'message' => 'Commande validée et client notifié.'
            ];
        }elseif($commandeData && $commandeData['commande']){
            $commande = $commandeData['commande'];
            $commandeModel->updateStatut($id, 'pret');
        }
         else {
            $_SESSION['flash'] = [
                'type' => 'danger',
                'message' => 'Commande introuvable.'
            ];
        }

        header('Location: /admin');
        exit();
    }

    private function envoyerEmailConfirmation(CommandeEntity $commande, array $items)
    {
        $to = $commande->getClientEmail();
        $subject = 'Confirmation de votre commande #' . $commande->getId();

        $itemsHtml = '';
        foreach ($items as $item) {
            $itemsHtml .= "<tr>
                <td>{$item['name']}</td>
                <td>{$item['quantity']}</td>
                <td>{$item['prix_unitaire']} €</td>
                <td>" . ($item['quantity'] * $item['prix_unitaire']) . " €</td>
            </tr>";
        }

        $message = "
        <html>
        <head>
            <title>Confirmation de commande</title>
            <style>
                table { border-collapse: collapse; width: 100%; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
            </style>
        </head>
        <body>
            <h2>Merci pour votre commande !</h2>
            <p>Votre commande #{$commande->getId()} a été validée.</p>
            
            <h3>Détails de la commande</h3>
            <table>
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Prix unitaire</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    $itemsHtml
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan='3'>Total</th>
                        <th>{$commande->getTotal()} €</th>
                    </tr>
                </tfoot>
            </table>
            
            <p>Mode de consommation: {$commande->getModeConsommation()}</p>
        </body>
        </html>
        ";

        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: no-reply@votrerestaurant.com\r\n";

        mail($to, $subject, $message, $headers);
    }
}
