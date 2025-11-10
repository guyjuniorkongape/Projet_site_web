<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Créer un compte ‹ ESIG'MOVING</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    
    <!-- Partie gauche -->
    <div class="left-panel">
      <div class="logo-title">
        <img src="logoEM.png" alt="Logo EM" class="logo">
        <h1>ESIG'MOVING</h1>
      </div>
      <div class="form-box">
        <form method="post" action="">
          <label for="username">Nom d'utilisateur</label>
          <input type="text" id="username" name="username" required>

          <label for="email">Adresse e-mail</label>
          <input type="email" id="email" name="email" required>

          <label for="password">Mot de passe</label>
          <input type="password" id="password" name="password" required>

          <label for="confirm">Confirmer le mot de passe</label>
          <input type="password" id="confirm" name="confirm" required>

          <button type="submit">Créer le compte</button>
        </form>

            <div class="text-center mt-3">
                <a href="connexion.php" class="text-dark text-decoration-none">Déjà un compte ? Se connecter</a><br>
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
