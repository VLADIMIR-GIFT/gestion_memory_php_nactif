<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Application</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css"> </head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Votre Projet</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item active">
                    <a class="nav-link" href="views/etudiant/dashboard.php">Tableau de Bord <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="views/auth/logout.php">Se déconnecter</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="views/auth/login.php">Se connecter</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="views/auth/register.php">S'inscrire</a>
                </li>
            <?php endif; ?>
            </ul>
    </div>
</nav>

<div class="container mt-4">
   