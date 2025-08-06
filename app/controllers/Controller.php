<?php

namespace App\Controllers;

use RuntimeException;
use Database\DBConnection;

abstract class Controller {

    protected $db;

    public function __construct(DBConnection $db)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->db = $db;
    }
    protected function guard()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
    }

    protected function view(string $path, array $data = [])
    {
        
        $basePath = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;

        // Normalisation du chemin
        $normalizedPath = str_replace(['\\', '/', '.'], DIRECTORY_SEPARATOR, $path);
        $viewFile = $basePath . $normalizedPath . '.php';

       
        if (!file_exists($viewFile)) {
            $errorMessage = "ERREUR: Vue introuvable\n";
            $errorMessage .= "Chemin recherché: " . $viewFile . "\n";
            $errorMessage .= "Structure attendue: \n";
            $errorMessage .= "- resto/views/panier/index.php\n";
            $errorMessage .= "- resto/views/layout/layout.php";
            throw new RuntimeException($errorMessage);
        }

        extract($data);
        ob_start();
        require $viewFile;
        $content = ob_get_clean();

      
        $layoutFile = $basePath . 'layout' . DIRECTORY_SEPARATOR . 'layout.php';
        if (file_exists($layoutFile)) {
            require $layoutFile;
        } else {
            echo $content;
        }
    }
    protected function getDB()
    {
        
        return $this->db;
    }

    protected function isAdmin(): bool
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /login');
            exit();
        }
        return true;
    }
    protected function getStatutColor(string $statut): string
    {
        $colors = [
            'en_attente' => 'warning',
            'preparation' => 'info',
            'termine' => 'success',
            'annule' => 'danger'
        ];
        return $colors[$statut] ?? 'secondary';
    }

    protected function getModeLabel(string $mode): string
    {
        $labels = [
            'sur_place' => 'Sur place',
            'a_emporter' => 'À emporter',
            'livraison' => 'Livraison'
        ];
        return $labels[$mode] ?? $mode;
    }

    
}
