<?php
require_once 'Database.php';

class Encadreur {
    public $id;
    public $nom;
    public $prenom;
    public $specialites = [];
    public $email; // Tableau des spécialités (AL, SI, SRC)

    /**
     * Sauvegarde l'encadreur en base de données (insert ou update)
     */
    public function save() {
        $db = Database::getConnection();
        
        // Convertit le tableau specialites en chaîne séparée par des virgules
        $specialitesStr = implode(',', $this->specialites);

        if ($this->id) {
            // Mise à jour
            $stmt = $db->prepare("UPDATE encadreurs SET nom = ?, prenom = ?, specialites = ? WHERE id = ?");
            $stmt->execute([$this->nom, $this->prenom, $specialitesStr, $this->id]);
        } else {
            // Insertion
            $stmt = $db->prepare("INSERT INTO encadreurs (nom, prenom, specialites) VALUES (?, ?, ?)");
            $stmt->execute([$this->nom, $this->prenom, $specialitesStr]);
            $this->id = $db->lastInsertId();
        }
    }

    /**
     * Récupère un encadreur par son ID
     */
    public static function getById($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM encadreurs WHERE id = ?");
        $stmt->execute([$id]);
        
        if ($row = $stmt->fetch()) {
            $encadreur = new Encadreur();
            $encadreur->id = $row['id'];
            $encadreur->nom = $row['nom'];
            $encadreur->prenom = $row['prenom'];
            $encadreur->specialites = explode(',', $row['specialites']);
            return $encadreur;
        }
        return null;
    }

    /**
     * Récupère tous les encadreurs
     */
    public static function getAll() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM encadreurs");
        
        $encadreurs = [];
        while ($row = $stmt->fetch()) {
            $encadreur = new Encadreur();
            $encadreur->id = $row['id'];
            $encadreur->nom = $row['nom'];
            $encadreur->prenom = $row['prenom'];
            $encadreur->specialites = explode(',', $row['specialites']);
            $encadreurs[] = $encadreur;
        }
        return $encadreurs;
    }

    /**
     * Récupère les encadreurs compatibles avec une spécialité donnée
     */
    public static function getCompatible($specialite) {
        $db = Database::getConnection();
        // Recherche les encadreurs dont les spécialités incluent $specialite
        $stmt = $db->prepare("SELECT * FROM encadreurs WHERE FIND_IN_SET(?, specialites)");
        $stmt->execute([$specialite]);
        
        $encadreurs = [];
        while ($row = $stmt->fetch()) {
            $encadreur = new Encadreur();
            $encadreur->id = $row['id'];
            $encadreur->nom = $row['nom'];
            $encadreur->prenom = $row['prenom'];
            $encadreur->specialites = explode(',', $row['specialites']);
            $encadreurs[] = $encadreur;
        }
        return $encadreurs;
    }

    /**
     * Supprime un encadreur
     */
    public static function delete($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM encadreurs WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
