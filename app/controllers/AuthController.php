<?php

namespace App\Controllers;

use App\model\UserModel;

class AuthController extends Controller
{
    public function login()
    {
        return $this->view('auth.login');
    }

    public function loginAuth()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $error = "Tous les champs sont obligatoires.";
                return $this->view('auth.login', ['error' => $error]);
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Email invalide.";
                return $this->view('auth.login', ['error' => $error]);
            }

            $userModel = new UserModel($this->getDB());
            $user = $userModel->findByEmail($email);

            if ($user !== null && password_verify($password, $user->getPassword())) {
                $_SESSION['user'] = [
                    'id' => $user->getId(),
                    'nom' => $user->getNom(),
                    'prenom' => $user->getPrenom(),
                    'email' => $user->getEmail(),
                    'role' => $user->getRole(),
                ];
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Connexion réussie ! Bienvenue ' . $user->getPrenom()
                ];
                if ($user->getRole() === 'admin') {
                    header('Location: /admin');
                } else {
                    header('Location: /');
                }
                exit;
            } else {
                $error = "Email ou mot de passe incorrect.";
                return $this->view('auth.login', ['error' => $error]);
            }
        }

        return $this->view('auth.login');
    }

    public function logout()
    {
        $_SESSION['flash'] = [
            'type' => 'info',
            'message' => 'Vous avez été déconnecté avec succès.'
        ];
        session_unset();
        session_destroy();
        header('Location: /login');
        exit;
    }
}
