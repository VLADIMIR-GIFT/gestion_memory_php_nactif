<?php
require_once 'Database.php'; // Assurez-vous que le chemin est correct

class Etudiant {
    public $id;
    public $nom;
    public $prenom;
    public $email;
    public $password;
    public $specialite;
    public $theme;
    public $pdf_path;
    public $encadreur_id;

    /**
     * Sauvegarde l'étudiant en base de données (insert ou update).
     */
    public function save() {
        $db = Database::getConnection();
    
        // Vérifie si l'email existe déjà (uniquement à la création)
        if (!$this->id) {
            $stmt = $db->prepare("SELECT COUNT(*) FROM etudiants WHERE email = ?");
            $stmt->execute([$this->email]);
            if ($stmt->fetchColumn() > 0) {
                throw new Exception("Un étudiant avec cet email existe déjà.");
            }
    
            // Insertion
            $stmt = $db->prepare("INSERT INTO etudiants (nom, prenom, email, password, specialite) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$this->nom, $this->prenom, $this->email, $this->password, $this->specialite]);
            $this->id = $db->lastInsertId();
    
        } else {
            // Mise à jour
            $stmt = $db->prepare("UPDATE etudiants SET nom = ?, prenom = ?, email = ?, password = ?, specialite = ?, theme = ?, pdf_path = ?, encadreur_id = ? WHERE id = ?");
            $stmt->execute([$this->nom, $this->prenom, $this->email, $this->password, $this->specialite, $this->theme, $this->pdf_path, $this->encadreur_id, $this->id]);
        }
    }

     public static function getAllExcept($etudiantId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM etudiants WHERE id != ?");
        $stmt->execute([$etudiantId]);
        $etudiants = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $etudiants[] = new Etudiant($row['id'], $row['nom'], $row['prenom'], $row['email'], $row['password'], $row['specialite'], $row['theme'], $row['encadreur_id'], $row['binome_id'], $row['pdf_path']); // Ajustez les arguments du constructeur si nécessaire
        }
        return $etudiants;
    }
    
    /**
     * Récupère un étudiant par son ID.
     */
    public static function getById($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM etudiants WHERE id = ?");
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Etudiant');
        return $stmt->fetch();
    }

    /**
     * Récupère un étudiant par son email.
     */
    public static function getByEmail($email) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM etudiants WHERE email = ?");
        $stmt->execute([$email]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Etudiant');
        return $stmt->fetch();
    }

    /**
     * Récupère tous les étudiants.
     */
    public static function getAll() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM etudiants");
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Etudiant');
        return $stmt->fetchAll();
    }

    /**
     * Récupère tous les étudiants sauf celui avec l'ID spécifié.
     */

}
?>