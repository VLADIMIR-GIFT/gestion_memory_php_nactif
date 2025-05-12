<?php
require_once __DIR__ . '/../../controllers/AuthController.php';

use AuthController;

// On exécute directement la méthode register (seulement pour POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    AuthController::register();
} else {
    // Sinon, on redirige vers le formulaire
    header('Location: register.php');
    exit;
}
