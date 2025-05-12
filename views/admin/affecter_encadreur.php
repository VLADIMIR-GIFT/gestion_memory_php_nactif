<?php 
require_once '../../layouts/header.php';
require_once '../../models/Binome.php';
require_once '../../models/Encadreur.php';

$binome = Binome::getById($_GET['binome_id']);
$encadreurs = Encadreur::getCompatible($binome->getSpecialite());
?>

<div class="container">
    <h2>Affecter un Encadreur</h2>
    <p>Binôme: <?= $binome->etudiant1->prenom ?> & <?= $binome->etudiant2->prenom ?></p>
    <p>Spécialité: <?= $binome->getSpecialite() ?></p>
    
    <form action="../../controllers/AdminController.php?action=affecter" method="POST">
        <input type="hidden" name="binome_id" value="<?= $binome->id ?>">
        
        <div class="form-group">
            <label>Sélectionnez un encadreur:</label>
            <select name="encadreur_id" class="form-control" required>
                <?php foreach ($encadreurs as $e): ?>
                    <option value="<?= $e->id ?>">
                        <?= $e->prenom ?> <?= $e->nom ?> (<?= implode(', ', $e->specialites) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Affecter</button>
    </form>
</div>

<?php require_once '../../layouts/footer.php'; ?>