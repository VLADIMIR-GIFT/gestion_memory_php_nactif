<?php
require_once 'Database.php';
require_once 'Etudiant.php';
require_once 'Encadreur.php';

class Binome {
    public $id;
    public $etudiant1;
    public $etudiant2;
    public $encadreur;
    public $specialite;

    public static function createDemande($sourceId, $cibleId) {
        // TODO: À implémenter
    }

    public static function confirmerDemande($demandeId) {
        // TODO: À implémenter
    }

    public static function affecterEncadreur($binomeId, $encadreurId) {
        // TODO: À implémenter
    }

    public static function getNonAffectes() {
        $db = Database::getConnection();
        $stmt = $db->query("
            SELECT b.id, e1.id AS etudiant1_id, e1.nom AS etudiant1_nom, e1.prenom AS etudiant1_prenom,
                   e2.id AS etudiant2_id, e2.nom AS etudiant2_nom, e2.prenom AS etudiant2_prenom,
                   b.specialite, b.encadreur_id
            FROM binomes b
            JOIN etudiants e1 ON b.etudiant1_id = e1.id
            JOIN etudiants e2 ON b.etudiant2_id = e2.id
            WHERE b.encadreur_id IS NULL
        ");

        return self::fetchBinomesFromStmt($stmt);
    }

    public static function getByEtudiantId($etudiantId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT b.id, b.etudiant1_id, b.etudiant2_id, b.encadreur_id, b.specialite
            FROM binomes b
            WHERE b.etudiant1_id = ? OR b.etudiant2_id = ?
        ");
        $stmt->execute([$etudiantId, $etudiantId]);

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $binome = new Binome();
            $binome->id = $row['id'];
            $binome->etudiant1 = Etudiant::getById($row['etudiant1_id']);
            $binome->etudiant2 = Etudiant::getById($row['etudiant2_id']);
            $binome->encadreur = $row['encadreur_id'] ? Encadreur::getById($row['encadreur_id']) : null;
            $binome->specialite = $row['specialite'];
            return $binome;
        }

        return null;
    }

    public static function getById($binomeId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT b.id, b.etudiant1_id, b.etudiant2_id, b.encadreur_id, b.specialite
            FROM binomes b
            WHERE b.id = ?
        ");
        $stmt->execute([$binomeId]);

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $binome = new Binome();
            $binome->id = $row['id'];
            $binome->etudiant1 = Etudiant::getById($row['etudiant1_id']);
            $binome->etudiant2 = Etudiant::getById($row['etudiant2_id']);
            $binome->encadreur = $row['encadreur_id'] ? Encadreur::getById($row['encadreur_id']) : null;
            $binome->specialite = $row['specialite'];
            return $binome;
        }

        return null;
    }

    public static function getAll() {
        $db = Database::getConnection();
        $stmt = $db->query("
            SELECT b.id, e1.id AS etudiant1_id, e1.nom AS etudiant1_nom, e1.prenom AS etudiant1_prenom,
                   e2.id AS etudiant2_id, e2.nom AS etudiant2_nom, e2.prenom AS etudiant2_prenom,
                   b.specialite, b.encadreur_id
            FROM binomes b
            JOIN etudiants e1 ON b.etudiant1_id = e1.id
            JOIN etudiants e2 ON b.etudiant2_id = e2.id
        ");

        return self::fetchBinomesFromStmt($stmt);
    }

    private static function fetchBinomesFromStmt($stmt) {
        $binomes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $binome = new Binome();
            $binome->id = $row['id'];

            $binome->etudiant1 = new Etudiant();
            $binome->etudiant1->id = $row['etudiant1_id'];
            $binome->etudiant1->nom = $row['etudiant1_nom'];
            $binome->etudiant1->prenom = $row['etudiant1_prenom'];

            $binome->etudiant2 = new Etudiant();
            $binome->etudiant2->id = $row['etudiant2_id'];
            $binome->etudiant2->nom = $row['etudiant2_nom'];
            $binome->etudiant2->prenom = $row['etudiant2_prenom'];

            $binome->specialite = $row['specialite'];
            $binome->encadreur = $row['encadreur_id'] ? Encadreur::getById($row['encadreur_id']) : null;

            $binomes[] = $binome;
        }

        return $binomes;
    }

    public function getSpecialite() {
        return $this->specialite;
    }

    public function getOtherMember($etudiantId) {
        if ($this->etudiant1 && $this->etudiant1->id != $etudiantId) {
            return $this->etudiant1;
        }
        if ($this->etudiant2 && $this->etudiant2->id != $etudiantId) {
            return $this->etudiant2;
        }
        return null;
    }
}
?>
