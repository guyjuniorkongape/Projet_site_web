<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion ‹ ESIG'MOVING</title>

    <!-- Lien vers Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!--  Ton fichier CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

<?php
    $message = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // Exemple d'identifiants (à remplacer par une vraie base de données)
        $valid_username = 'admin';
        $valid_password = '1234';

        if ($username === $valid_username && $password === $valid_password) {
            $message = '<div class="alert alert-success mt-3">Connexion réussie !</div>';
        } else {
            $message = '<div class="alert alert-danger mt-3">Nom d\'utilisateur ou mot de passe incorrect.</div>';
        }
    }
?>

<div class="card shadow p-4" style="max-width: 380px; width: 100%;">
    <div class="text-center mb-3">
        <div class="logo mb-2">EM</div>
        <h2 class="fw-bold title">ESIG’MOVING</h2>
    </div>

    <img src="photo_projet.png" alt="Illustration ESIG'MOVING" class="img-fluid rounded mb-4">

    <form method="post" action="">
        <div class="mb-3 text-start">
            <label for="username" class="form-label">Nom d'utilisateur ou e-mail</label>
            <input type="text" id="username" name="username" class="form-control" required>
        </div>

        <div class="mb-3 text-start">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" id="password" name="password" class="form-control" required autocomplete="current-password">
        </div>

        <button type="submit" class="btn btn-primary w-100">Se connecter</button>
    </form>

    <?php if ($message) echo $message; ?>

    <div class="text-center mt-3">
        <a href="#" class="text-decoration-none">Mot de passe oublié ?</a><br>
        <a href="#" class="text-decoration-none">&larr; Retour à l’accueil</a>
    </div>
</div>

<!-- Scripts Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
