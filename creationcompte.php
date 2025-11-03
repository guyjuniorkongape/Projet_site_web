<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Créer un compte ‹ ESIG'MOVING</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style2.css">
</head>
<body class="bg-custom">

<div class="container-fluid d-flex flex-column flex-md-row min-vh-100">
    <!-- Zone gauche -->
    <div class="col-md-6 d-flex flex-column justify-content-center align-items-center p-5">
        <div class="logo mb-3">EM</div>
        <h1 class="title mb-4">ESIG’MOVING</h1>
        <div class="card border-dark shadow-sm p-4 form-box w-100" style="max-width: 400px;">
            <h4 class="text-center mb-4">Créer un compte</h4>

            <?php
                $message = '';
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $username = trim($_POST['username'] ?? '');
                    $email = trim($_POST['email'] ?? '');
                    $password = $_POST['password'] ?? '';
                    $confirm = $_POST['confirm'] ?? '';

                    if ($password !== $confirm) {
                        $message = '<div class="alert alert-danger">Les mots de passe ne correspondent pas.</div>';
                    } elseif (empty($username) || empty($email) || empty($password)) {
                        $message = '<div class="alert alert-warning">Veuillez remplir tous les champs.</div>';
                    } else {
                        $message = '<div class="alert alert-success">Compte créé avec succès !</div>';
                    }
                }
            ?>

            <form method="post" action="">
                <div class="mb-3">
                    <label for="username" class="form-label">Nom d'utilisateur</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Adresse e-mail</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="confirm" class="form-label">Confirmer le mot de passe</label>
                    <input type="password" id="confirm" name="confirm" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-outline-dark w-100">Créer le compte</button>
            </form>

            <?php if ($message) echo $message; ?>

            <div class="text-center mt-3">
                <a href="connexion.php" class="text-dark text-decoration-none">Déjà un compte ? Se connecter</a><br>
                <a href="index.php" class="text-dark text-decoration-none">&larr; Retour à l’accueil</a>
            </div>
        </div>
    </div>

    <!-- Zone image droite -->
    <div class="col-md-6 p-0 d-none d-md-block">
        <img src="photo_projet.png" alt="Illustration ESIG'MOVING" class="img-fluid h-100 w-100 object-fit-cover">
    </div>
</div>

</body>
</html>
