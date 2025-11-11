<?php
session_start();
$message = ''; // Parce que message affichait 1 erreur

if (isset($_GET['erreur'])) {
    $message = '<div class="alert alert-danger">Nom d\'utilisateur ou mot de passe incorrect.</div>';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion  ESIG'MOVING</title>
  <link rel="stylesheet" href="style2.css">
</head>
<body>
  <div class="container">
    <!-- Partie gauche -->
    <div class="left-panel">
    <div class="logo-title">
     <img src="logoEM.png" alt="Logo EM" class="logo">

        <h1>ESIG'MOVING</h1>
      </div>

<<<<<<< Updated upstream
      <div class="form-box">
          <form action="#" method="post">
        <label for="username"> Nom d'utilisateur</label>
        <input type="text" id="username" name="username" class="form-control" required>

        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" class="form-control" required>
=======
           

            <form method="post" action="verif_connexion.php">
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
>>>>>>> Stashed changes

        <button type="submit" class="btn btn-outline-dark w-100">Se connecter</button>
      </form>
            <div class="text-center mt-3">
                <a href="creationcompte.php" class="text-dark text-decoration-none">Créer un compte</a><br>
                <a href="index.php" class="text-dark text-decoration-none">&larr; Retour à l’accueil</a>
            </div>
        </div>
    </div>

    <!-- Partie droite -->
    <div class="right-panel">
      <img src="image.jpg" alt="Personnes avec cartons" class="main-image">
    </div>
  </div>
</body>
</html>
