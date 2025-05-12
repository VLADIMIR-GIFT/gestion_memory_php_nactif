<?php require_once __DIR__ . '/views/layouts/header.php'; ?>

<div class="container">
    <h2>Uploader votre cahier des charges</h2>
    <form action="../../controllers/EtudiantController.php?action=upload" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Thème du projet:</label>
            <input type="text" name="theme" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Fichier PDF:</label>
            <input type="file" name="pdf" class="form-control" accept=".pdf" required>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
</div>

<?php require_once __DIR__ . '/views/layouts/footer.php'; ?>