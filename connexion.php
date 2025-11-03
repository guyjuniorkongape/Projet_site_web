<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion  ESIG'MOVING</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style2.css">
</head>
<body class="bg-custom">

<div class="container-fluid d-flex flex-column flex-md-row min-vh-100">
    <!-- Zone gauche -->
    <div class="col-md-6 d-flex flex-column justify-content-center align-items-center p-5">
        <div class="logo mb-3">EM</div>
        <h1 class="title mb-4">ESIGMOVING</h1>
        <div class="card border-dark shadow-sm p-4 form-box w-100" style="max-width: 380px;">
            <h4 class="text-center mb-4">Connexion</h4>

            <?php
                $message = '';
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $username = $_POST['username'] ?? '';
                    $password = $_POST['password'] ?? '';

                    $valid_username = 'admin';
                    $valid_password = '1234';

                    if ($username === $valid_username && $password === $valid_password) {
                        $message = '<div class="alert alert-success">Connexion réussie !</div>';
                    } else {
                        $message = '<div class="alert alert-danger">Nom d\'utilisateur ou mot de passe incorrect.</div>';
                    }
                }
            ?>

            <form method="post" action="">
                <div class="mb-3">
                    <label for="username" class="form-label">Nom d’utilisateur</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-outline-dark w-100">Se connecter</button>
            </form>

            <?php if ($message) echo $message; ?>

            <div class="text-center mt-3">
                <a href="creationcompte.php" class="text-dark text-decoration-none">Créer un compte</a><br>
                <a href="index.php" class="text-dark text-decoration-none">&larr; Retour à l’accueil</a>
            </div>
        </div>
    </div>

    <!-- Zone image droite -->
    <div class="col-md-6 p-0 d-none d-md-block">
        <img src="image.jpg" alt="Illustration ESIG'MOVING" class="img-fluid h-100 w-100 object-fit-cover">
    </div>
</div>

</body>
</html>
