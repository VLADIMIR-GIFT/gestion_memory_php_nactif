<?php
require_once  __DIR__ . '/../models/Binome.php';
require_once  __DIR__ . '/../models/Etudiant.php';
require_once  __DIR__ . '/../helpers/Mailer.php';
use Helpers\Mailer;

class BinomeController {
    public static function demanderBinome() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $etudiantSourceId = $_SESSION['user_id'];
            $etudiantCibleId = $_POST['binome_id'];

            // Crée une demande de binôme
            Binome::createDemande($etudiantSourceId, $etudiantCibleId);

            // Envoie un email de notification
            $etudiantCible = Etudiant::getById($etudiantCibleId);
            $subject = "Demande de binôme";
            $message = "Vous avez une demande de binôme de la part de ...";
            
            Mailer::send($etudiantCible->email, $subject, $message);

            header('Location: ../views/etudiant/dashboard.php');
        }
    }

    public static function confirmerBinome() {
        $demandeId = $_GET['demande_id'];
        Binome::confirmerDemande($demandeId);
        header('Location: ../views/etudiant/dashboard.php');
    }
}

// Gestion des routes
$action = $_GET['action'] ?? '';
switch ($action) {
    case 'demander':
        BinomeController::demanderBinome();
        break;
    case 'confirmer':
        BinomeController::confirmerBinome();
        break;
}
?>