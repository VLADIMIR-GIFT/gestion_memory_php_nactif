<?php
require_once(__DIR__ . '/../models/Etudiant.php');
require_once __DIR__ . '/../helpers/Session.php';
use Helpers\Session;

class AuthController {

    public static function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $etudiant = new Etudiant();
                $etudiant->nom = $_POST['nom'];
                $etudiant->prenom = $_POST['prenom'];
                $etudiant->email = $_POST['email'];
                $etudiant->password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $etudiant->specialite = $_POST['specialite'] ?? null;
                $etudiant->save();
                
                Session::set('user_id', $etudiant->id);
                header('Location: ../views/etudiant/dashboard.php');
                exit;
            } catch (Exception $e) {
                // Stocke l'erreur en session et redirige 
                Session::set('error', $e->getMessage());
                header('Location: ../views/auth/register.php');
                exit;
            }
        }
    }

    public static function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $etudiant = Etudiant::getByEmail($email);

            if ($etudiant && password_verify($password, $etudiant->password)) {
                Session::set('user_id', $etudiant->id);
                header('Location:  ../views/etudiant/dashboard.php');
                exit;
            } else {
                Session::set('error', 'Email ou mot de passe incorrect');
                header('Location: ../views/auth/login.php');
                exit;
            }
        }
    }

    public static function logout() {
        Session::destroy();
        header('Location: ../views/auth/login.php');
        exit;
    }
}

// Gestion des routes
$action = $_GET['action'] ?? '';
switch ($action) {
    case 'register':
        AuthController::register();
        break;
    case 'login':
        AuthController::login();
        break;
    case 'logout':
        AuthController::logout();
        break;
}
?>
