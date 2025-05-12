<?php
require_once  __DIR__ . '/../models/Encadreur.php';
require_once  __DIR__ . '/../models/Binome.php';
require_once  __DIR__ . '/../helpers/Mailer.php';
use Helpers\Mailer;

class AdminController {
    public static function addEncadreur() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $encadreur = new Encadreur();
            $encadreur->nom = $_POST['nom'];
            $encadreur->prenom = $_POST['prenom'];
            $encadreur->specialites = $_POST['specialites'];
            $encadreur->save();
            header('Location: dashboard.php');
        }
    }

    public static function affecterEncadreur() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $binomeId = $_POST['binome_id'];
            $encadreurId = $_POST['encadreur_id'];

            Binome::affecterEncadreur($binomeId, $encadreurId);

            // Notifier les étudiants et l'encadreur
            $binome = Binome::getById($binomeId);
            $encadreur = Encadreur::getById($encadreurId);

            $subject = "Affectation d'un encadreur";
            $message = "Vous avez été affecté à {$encadreur->prenom} {$encadreur->nom}";

            Mailer::send($binome->etudiant1->email, $subject, $message);
            Mailer::send($binome->etudiant2->email, $subject, $message);
            Mailer::send($encadreur->email, $subject, "Vous encadrez maintenant un nouveau binôme");

            header('Location: dashboard.php');
        }
    }
}

// Gestion des routes
$action = $_GET['action'] ?? '';
switch ($action) {
    case 'add_encadreur':
        AdminController::addEncadreur();
        break;
    case 'affecter':
        AdminController::affecterEncadreur();
        break;
}
?>