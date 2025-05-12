<?php require_once(__DIR__ . '/../layouts/header.php'); ?>

<div class="container">
    <h2>Inscription Étudiant</h2>
    <form action="../../controllers/AuthController.php?action=register" method="POST">
        <div class="form-group">
            <label>Nom:</label>
            <input type="text" name="nom" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Prénom:</label>
            <input type="text" name="prenom" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Mot de passe:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>
    <p>Déjà inscrit? <a href="../auth/login.php">Connectez-vous ici</a></p>
</div>

<?php require_once(__DIR__ . '/../layouts/footer.php'); ?>
