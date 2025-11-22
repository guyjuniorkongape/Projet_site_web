<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>ESIG'MOVING</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css"> <!-- garde ton style pour les boutons -->
</head>
<body style="background-color:#b5d8ee;"> <!-- fond bleu clair -->

<div class="container-fluid vh-100">
  <div class="row h-100">
    
    <!-- Colonne gauche -->
    <div class="col-12 col-md-6 d-flex flex-column justify-content-start align-items-center pt-5">
      <div class="logo-title text-center mb-4">
        <img src="logoEM.png" alt="Logo EM" class="logo mb-2" style="max-width:100px;">
        <h1 class="mt-2">ESIG'MOVING</h1>
        <p class="lead">Votre déménagement simplifié</p>
      </div>
      <div class="buttons d-flex flex-column gap-3 w-75 mt-3">
        <button onclick="window.location.href='creationcompte.php'">CRÉER UN COMPTE</button>
        <button onclick="window.location.href='connexion.php'">CONNEXION</button>
        <button onclick="window.location.href='Information.php'">INFORMATIONS</button>
      </div>
    </div>

    <!-- Colonne droite -->
    <div class="col-12 col-md-6 p-0">
      <img src="image.jpg" alt="Personnes avec cartons" class="w-100 h-100 object-fit-cover">
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
