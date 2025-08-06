<?php

namespace App\Controllers;

use App\model\UserModel;
use App\entity\UserEntity;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return $this->view('auth.register');
    }

    public function registerAuth()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération des données
            $nom = trim($_POST['nom'] ?? '');
            $prenom = trim($_POST['prenom'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            $adresse = trim($_POST['adresse'] ?? null);
            $telephone = ($_POST['telephone'] ?? null);
            $role = 'client'; // Par défaut pour l'inscription

            // Validation
            $errors = [];
            if (empty($nom)) $errors[] = "Le nom est obligatoire";
            if (empty($prenom)) $errors[] = "Le prénom est obligatoire";
            if (empty($email)) $errors[] = "L'email est obligatoire";
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalide";
            if (empty($password)) $errors[] = "Le mot de passe est obligatoire";
            if ($password !== $confirmPassword) $errors[] = "Les mots de passe ne correspondent pas";

            if (!empty($errors)) {
                return $this->view('auth.register', ['errors' => $errors]);
            }

            // Vérification email unique
            $userModel = new UserModel($this->getDB());
            if ($userModel->findByEmail($email)) {
                return $this->view('auth.register', ['errors' => ['Cet email est déjà utilisé']]);
            }

            // Création de l'utilisateur
            if ($userModel->create($nom, $prenom, $email, $password, $adresse, $telephone, $role)) {
                // Redirection vers la page de connexion avec message de succès
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Inscription réussie! Vous pouvez maintenant vous connecter.'
                ];
                return $this->view('auth.login');
            } else {
                return $this->view('auth.register', ['errors' => ['Une erreur est survenue lors de l\'inscription']]);
            }
        }
        return $this->view('auth.register');
    }
}
