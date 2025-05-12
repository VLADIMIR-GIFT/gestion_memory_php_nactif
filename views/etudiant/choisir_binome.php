<?php 
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/models/Etudiant.php';

$etudiants = Etudiant::getAllExcept($_SESSION['user_id']);
?>

<div class="container">
    <h2>Choisir votre binôme</h2>
    <form action="../controllers/BinomeController.php?action=demander" method="POST">
        <div class="form-group">
            <label>Sélectionnez un étudiant:</label>
            <select name="binome_id" class="form-control" required>
                <?php foreach ($etudiants as $e): ?>
                    <option value="<?= $e->id ?>">
                        <?= $e->prenom ?> <?= $e->nom ?> (<?= $e->specialite ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer la demande</button>
    </form>
</div>

<?php require_once __DIR__ . '/views/layouts/footer.php'; ?>