<?php require_once '../../layouts/header.php'; ?>

<div class="container">
    <h2>Ajouter un Encadreur</h2>
    <form action="../../controllers/AdminController.php?action=add_encadreur" method="POST">
        <div class="form-group">
            <label>Nom:</label>
            <input type="text" name="nom" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Prénom:</label>
            <input type="text" name="prenom" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Spécialités:</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="specialites[]" value="AL">
                <label class="form-check-label">AL</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="specialites[]" value="SI">
                <label class="form-check-label">SI</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="specialites[]" value="SRC">
                <label class="form-check-label">SRC</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
</div>

<?php require_once '../../layouts/footer.php'; ?>