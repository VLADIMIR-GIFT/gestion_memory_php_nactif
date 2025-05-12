<?php
// Chargement des modèles
require_once __DIR__ . '/models/Database.php';
require_once __DIR__ . '/models/test_db.php'; // Optionnel
require_once __DIR__ . '/models/Etudiant.php';
require_once __DIR__ . '/models/Encadreur.php';
require_once __DIR__ . '/models/Binome.php';

// Chargement des contrôleurs
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/EtudiantController.php';
require_once __DIR__ . '/controllers/AdminController.php';
require_once __DIR__ . '/controllers/BinomeController.php';

// Chargement des helpers
require_once __DIR__ . '/helpers/Session.php';
require_once __DIR__ . '/helpers/Mailer.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}