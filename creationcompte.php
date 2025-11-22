<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CrÃ©er un compte â€¹ ESIG'MOVING</title>
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
      <div class="form-box">

<?php if(isset($_SESSION['erreur'])): ?>
  <div class="alert alert-danger">
    <?= $_SESSION['erreur']; unset($_SESSION['erreur']); ?>
  </div>
<?php endif; ?>

<?php if(isset($_SESSION['message'])): ?>
  <div class="alert alert-success">
    <?= $_SESSION['message']; unset($_SESSION['message']); ?>
  </div>
<?php endif; ?>

        <form method="post" action="traitement_creationcompte.php">
          <label for="nom">Nom d'utilisateur</label>
          <input type="text" id="nom" name="nom" required>

          <label for="prenom">Prénom</label>
          <input type="text" id="prenom" name="prenom" required>

          <label for="email">Adresse e-mail</label>
          <input type="email" id="email" name="email" required>

          <label for="role">Rôle</label>
              <select id="role" name="role" required>
                 <option value="">-- Sélectionnez un rôle --</option>
                 <option value="client">Client</option>
                 <option value="demenageur">Déménageur</option>
                 <option value="admin">Administrateur</option>
              </select>


          <label for="password">Mot de passe</label>
          <input type="password" id="password" name="password" required>

          <label for="confirm">Confirmer le mot de passe</label>
          <input type="password" id="confirm" name="confirm" required>

          <button type="submit">CrÃ©er le compte</button>
        </form>
        

            <div class="text-center mt-3">
                <a href="connexion.php" class="text-dark text-decoration-none">DÃ©jÃ  un compte ? Se connecter</a><br>
                <a href="index.php" class="text-dark text-decoration-none">&larr; Retour Ã  lâ€™accueil</a>
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
