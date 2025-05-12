<?php
session_start();

// Inclut tous les fichiers nécessaires (contrôleurs, modèles, etc.)
require_once __DIR__ . '/bootstrap.php';

// Détection de l'action via l'URL (ex: index.php?action=login)
$action = $_GET['action'] ?? 'login'; // Action par défaut : login

// Fonction de routage centralisée
function route($action) {
    $routes = [
        'login' => '/views/auth/login.php',
        'register' => '/views/auth/register.php',
        'dashboard' => '/views/etudiant/dashboard.php',
        'upload_pdf' => '/views/etudiant/upload_pdf.php',
        'choisir_binome' => '/views/etudiant/choisir_binome.php',
        'admin_dashboard' => '/views/admin/dashboard.php',
        'ajouter_encadreur' => '/views/admin/ajouter_encadreur.php',
        'affecter_encadreur' => '/views/admin/affecter_encadreur.php',
    ];

    if (array_key_exists($action, $routes)) {
        include __DIR__ . $routes[$action];
    } else {
        http_response_code(404);
        echo 'Page non trouvée';
    }
}

// Appelle la fonction de routage
route($action);
