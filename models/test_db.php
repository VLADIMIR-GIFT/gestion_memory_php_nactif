<?php
require_once 'models/Database.php';

try {
    $db = Database::getConnection();
    echo "Connexion réussie à la base de données!";
    
    // Tester une requête simple
    $stmt = $db->query("SHOW TABLES");
    echo "<br>Tables disponibles : " . $stmt->rowCount();
} catch (PDOException $e) {
    die("ERREUR : " . $e->getMessage());
}