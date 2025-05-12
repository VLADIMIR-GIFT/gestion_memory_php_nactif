<?php
require_once 'Database.php';
require_once 'Etudiant.php';
require_once 'Encadreur.php';

class Binome {
    public $id;
    public $etudiant1; // Représentera l'étudiant 1 du binôme
    public $etudiant2; // Représentera l'étudiant 2 du binôme
    public $encadreur;
    public $specialite;

    public static function createDemande($sourceId, $cibleId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO binome (etudiant_source_id, etudiant_cible_id, statut) VALUES (?, ?, 'en_attente')");
        return $stmt->execute([$sourceId, $cibleId]);
    }

    public static function confirmerDemande($demandeId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE binome SET statut = 'accepte' WHERE id = ?");
        return $stmt->execute([$demandeId]);
    }

    public static function affecterEncadreur($binomeId, $encadreurId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE etudiants SET encadreur_id = ? WHERE binome_id = ?");
        // Note: Vous devrez peut-être adapter cette logique en fonction de la façon dont vous liez l'encadreur au binôme.
        // Actuellement, 'binome_id' dans 'etudiants' n'est pas directement lié à l'ID de la table 'binome'.
        // Il faudrait clarifier comment l'encadreur est lié à un binôme.
        // Pour l'instant, je vais supposer que vous voulez mettre l'encadreur_id des DEUX étudiants du binôme.
        $binome = self::getById($binomeId);
        $stmt1 = $db->prepare("UPDATE etudiants SET encadreur_id = ? WHERE id = ?");
        $stmt1->execute([$encadreurId, $binome->etudiant1->id]);
        $stmt2 = $db->prepare("UPDATE etudiants SET encadreur_id = ? WHERE id = ?");
        return $stmt2->execute([$encadreurId, $binome->etudiant2->id]);
    }

    public static function getNonAffectes() {
        $db = Database::getConnection();
        $stmt = $db->query("
            SELECT b.id, s.nom AS etudiant_source_nom, s.prenom AS etudiant_source_prenom, s.id AS etudiant_source_id,
                   c.nom AS etudiant_cible_nom, c.prenom AS etudiant_cible_prenom, c.id AS etudiant_cible_id,
                   s.specialite
            FROM binome b
            JOIN etudiants s ON b.etudiant_source_id = s.id
            JOIN etudiants c ON b.etudiant_cible_id = c.id
            WHERE b.statut = 'accepte'
            AND (s.encadreur_id IS NULL OR c.encadreur_id IS NULL)
        ");

        return self::fetchBinomesFromStmt($stmt);
    }

    public static function getByEtudiantId($etudiantId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT b.id, b.etudiant_source_id, b.etudiant_cible_id
            FROM binome b
            WHERE (b.etudiant_source_id = ? OR b.etudiant_cible_id = ?) AND b.statut = 'accepte'
        ");
        $stmt->execute([$etudiantId, $etudiantId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $binome = new Binome();
            $binome->id = $row['id'];
            $binome->etudiant1 = Etudiant::getById($row['etudiant_source_id']);
            $binome->etudiant2 = Etudiant::getById($row['etudiant_cible_id']);
            return $binome;
        }
        return null;
    }

    public static function getById($binomeId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT b.id, b.etudiant_source_id, b.etudiant_cible_id
            FROM binome b
            WHERE b.id = ? AND b.statut = 'accepte'
        ");
        $stmt->execute([$binomeId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $binome = new Binome();
            $binome->id = $row['id'];
            $binome->etudiant1 = Etudiant::getById($row['etudiant_source_id']);
            $binome->etudiant2 = Etudiant::getById($row['etudiant_cible_id']);
            return $binome;
        }
        return null;
    }

    public static function getAll() {
        $db = Database::getConnection();
        $stmt = $db->query("
            SELECT b.id, s.nom AS etudiant_source_nom, s.prenom AS etudiant_source_prenom, s.id AS etudiant_source_id,
                   c.nom AS etudiant_cible_nom, c.prenom AS etudiant_cible_prenom, c.id AS etudiant_cible_id,
                   s.specialite
            FROM binome b
            JOIN etudiants s ON b.etudiant_source_id = s.id
            JOIN etudiants c ON b.etudiant_cible_id = c.id
            WHERE b.statut = 'accepte'
        ");

        return self::fetchBinomesFromStmt($stmt);
    }

    private static function fetchBinomesFromStmt($stmt) {
        $binomes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $binome = new Binome();
            $binome->id = $row['id'];

            $binome->etudiant1 = new Etudiant();
            $binome->etudiant1->id = $row['etudiant_source_id'];
            $binome->etudiant1->nom = $row['etudiant_source_nom'];
            $binome->etudiant1->prenom = $row['etudiant_source_prenom'];
            $binome->etudiant1->specialite = $row['specialite']; // Récupérer la spécialité du source

            $binome->etudiant2 = new Etudiant();
            $binome->etudiant2->id = $row['etudiant_cible_id'];
            $binome->etudiant2->nom = $row['etudiant_cible_nom'];
            $binome->etudiant2->prenom = $row['etudiant_cible_prenom'];

            $binomes[] = $binome;
        }
        return $binomes;
    }

    public function getSpecialite() {
        return $this->etudiant1->specialite ?? null; // Retourne la spécialité du premier étudiant (source)
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