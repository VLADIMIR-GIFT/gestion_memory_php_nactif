<?php
session_start(); // Démarrez la session en premier

require_once __DIR__ . '/../../models/Etudiant.php';
require_once __DIR__ . '/../../models/Binome.php';
require_once __DIR__ . '/../layouts/header.php';

$etudiantConnecteId = $_SESSION['user_id'] ?? null;
if (!$etudiantConnecteId) {
    echo "<div class='alert alert-danger'>Vous n'êtes pas connecté.</div>";
    exit;
}
$etudiantConnecte = Etudiant::getById($etudiantConnecteId);
if (!$etudiantConnecte) {
    echo "<div class='alert alert-danger'>Erreur : étudiant connecté non trouvé.</div>";
    exit;
}

$etudiantsDisponibles = Etudiant::getAllExcept($etudiantConnecteId); // Méthode à créer dans le modèle Etudiant
?>

<div class="container">
    <h2>Choisir un binôme</h2>
    <p>Sélectionnez l'étudiant avec qui vous souhaitez former un binôme :</p>

    <form action="../../controllers/BinomeController.php?action=envoyer_demande" method="post">
        <div class="form-group">
            <label for="etudiant_cible_id">Étudiant :</label>
            <select class="form-control" id="etudiant_cible_id" name="etudiant_cible_id" required>
                <option value="">-- Sélectionner un étudiant --</option>
                <?php foreach ($etudiantsDisponibles as $etudiant): ?>
                    <option value="<?= $etudiant->id ?>"><?= $etudiant->prenom ?> <?= $etudiant->nom ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer la demande</button>
    </form>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>