<?php 
require_once '../../layouts/header.php';
require_once '../../models/Etudiant.php';
require_once '../../models/Encadreur.php';
require_once '../../models/Binome.php';

$etudiants = Etudiant::getAll();
$encadreurs = Encadreur::getAll();
$binomes = Binome::getAll();
$nonAffectes = Binome::getNonAffectes();
?>

<div class="container">
    <h2>Tableau de Bord Administrateur</h2>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Statistiques</h5>
                    <p>Étudiants inscrits: <?= count($etudiants) ?></p>
                    <p>Binômes formés: <?= count($binomes) ?></p>
                    <p>Binômes non affectés: <?= count($nonAffectes) ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title">Liste des Binômes</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Membre 1</th>
                        <th>Membre 2</th>
                        <th>Spécialité</th>
                        <th>Encadreur</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($binomes as $binome): ?>
                        <tr>
                            <td><?= $binome->etudiant1->prenom ?> <?= $binome->etudiant1->nom ?></td>
                            <td><?= $binome->etudiant2->prenom ?> <?= $binome->etudiant2->nom ?></td>
                            <td><?= $binome->getSpecialite() ?></td>
                            <td>
                                <?= $binome->encadreur ? $binome->encadreur->prenom.' '.$binome->encadreur->nom : 'Non affecté' ?>
                            </td>
                            <td>
                                <a href="affecter_encadreur.php?binome_id=<?= $binome->id ?>" class="btn btn-sm btn-primary">Affecter</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../../layouts/footer.php'; ?>