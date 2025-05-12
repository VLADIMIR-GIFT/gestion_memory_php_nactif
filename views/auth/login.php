<?php require_once(__DIR__ . '/../layouts/header.php'); ?>

<div class="container">
    <h2>Connexion</h2>
    <form action="../../controllers/AuthController.php?action=login" method="POST">
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Mot de passe:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
    <p>Pas de compte? <a href="../auth/register.php">Inscrivez-vous ici</a></p>
</div>

<?php require_once(__DIR__ . '/../layouts/footer.php'); ?>
