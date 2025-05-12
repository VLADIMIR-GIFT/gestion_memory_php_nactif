<?php
require_once __DIR__ . '/../models/Etudiant.php';
require_once __DIR__ . '/../models/Binome.php';
require_once __DIR__ . '/../models/Encadreur.php';
use Helpers\Mailer;

class EtudiantController {
    public static function uploadPdf() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $etudiant = Etudiant::getById($_SESSION['user_id']);
            $etudiant->theme = $_POST['theme'];

            // Gestion de l'upload PDF
            $targetDir = "../uploads/";
            $fileName = uniqid() . '_' . basename($_FILES["pdf"]["name"]);
            $targetFile = $targetDir . $fileName;

            if (move_uploaded_file($_FILES["pdf"]["tmp_name"], $targetFile)) {
                $etudiant->pdf_path = $targetFile;
                $etudiant->save();
                header('Location: dashboard.php');
            } else {
                echo "Erreur lors de l'upload";
            }
        }
    }

    public static function sendRappel() {
        $etudiant = Etudiant::getById($_SESSION['user_id']);
        $adminEmail = "admin@example.com";
        $subject = "Rappel d'affectation";
        $message = "L'étudiant {$etudiant->nom} {$etudiant->prenom} n'a pas encore d'encadreur.";

        Mailer::send($adminEmail, $subject, $message);
        
        echo json_encode(['message' => 'Rappel envoyé à l\'admin']);
        exit();
    }
}

// Gestion des routes
$action = $_GET['action'] ?? '';
switch ($action) {
    case 'upload':
        EtudiantController::uploadPdf();
        break;
    case 'rappel':
        EtudiantController::sendRappel();
        break;
}
?>