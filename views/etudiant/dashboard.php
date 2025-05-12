<?php 
require_once __DIR__ . '/../layouts/header.php';
require_once(__DIR__ . '/../../models/Etudiant.php');
require_once __DIR__ . '/../../models/Binome.php';
require_once __DIR__ . '/../../models/Encadreur.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$etudiant = Etudiant::getById($_SESSION['user_id']);
if (!$etudiant) {
    echo "<div class='alert alert-danger'>Erreur : étudiant non trouvé.</div>";
    exit;
}

$etudiant = Etudiant::getById($_SESSION['user_id']);
$binome = Binome::getByEtudiantId($etudiant->id);
$encadreur = $etudiant->encadreur_id ? Encadreur::getById($etudiant->encadreur_id) : null;
?>

<div class="container">
    <h2>Tableau de Bord Étudiant</h2>
    
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Vos informations</h5>
            <p>Nom: <?= $etudiant->nom ?></p>
            <p>Prénom: <?= $etudiant->prenom ?></p>
            <p>Spécialité: <?= $etudiant->specialite ?></p>
            <p>Thème: <?= $etudiant->theme ?? 'Non défini' ?></p>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title">Votre binôme</h5>
            <?php if ($binome): ?>
                <?php $autre = $binome->getOtherMember($etudiant->id); ?>
                       <p><?= $autre->prenom ?> <?= $autre->nom ?></p>
            <?php else: ?>
                <p>Pas de binôme défini</p>
                <a href="choisir_binome.php" class="btn btn-primary">Choisir un binôme</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title">Votre encadreur</h5>
            <?php if ($encadreur): ?>
                <p><?= $encadreur->prenom ?? '' ?> <?= $encadreur->nom ?? '' ?></p>
            <?php else: ?>
                <p>Pas encore d'encadreur attribué</p>
                <button class="btn btn-warning" onclick="envoyerRappel()">Signaler l'absence d'encadreur</button>
            <?php endif; ?>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title">Cahier des charges</h5>
            <?php if ($etudiant->pdf_path): ?>
                <p>Fichier téléchargé: <a href="<?= $etudiant->pdf_path ?>" target="_blank">Voir le PDF</a></p>
            <?php else: ?>
                <p>Pas de fichier téléchargé</p>
                <a href="upload_pdf.php" class="btn btn-primary">Uploader le cahier des charges</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function envoyerRappel() {
    fetch('../../controllers/EtudiantController.php?action=rappel')
        .then(response => response.json())
        .then(data => {
            alert(data.message);
        });
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>