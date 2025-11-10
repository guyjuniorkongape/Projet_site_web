<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tableau de bord - Client | ESIG'MOVING</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style2.css">
</head>
<body>
  <header>
    <img src="logoEM.png" alt="Logo ESIG'MOVING" class="logo">
    <h1>ESIG’MOVING</h1>
    <p>Avec ESIG'MOVING, déménager n’a jamais été aussi simple.</p>
    <h3>Tableau de bord du client</h3>
  </header>

  <main class="dashboard container text-center">
    <div class="row justify-content-center">
      <div class="col-md-3">
        <div class="card">
          <img src="imgdemande.jpeg" alt="Demande" class="card-img-top">
          <h4>Créer une demande</h4>
          <a href="Demande.php" class="btn btn-outline-dark mt-2">Faire une demande</a>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card">
          <img src="imgquestion.webp" alt="Question" class="card-img-top">
          <h4>Répondre aux questions</h4>
          <a href="Question.php" class="btn btn-outline-dark mt-2">Répondre</a>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card">
          <img src="imgevaluation.webp" alt="Évaluation" class="card-img-top">
          <h4>Évaluer un déménageur</h4>
          <a href="Evaluation.php" class="btn btn-outline-dark mt-2">Évaluer</a>
        </div>
      </div>
    </div>

    <div class="card mt-5">
      <h4>Déménageurs ayant postulé</h4>
      <table class="table table-striped text-center mt-3">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Statut</th>
            <th>Action</th>
          </tr>
        </thead>
        
      </table>
    </div>

    <div class="mt-4">
      <a href="index.php" class="btn btn-custom">Retour à l'accueil</a>
    </div>
  </main>

  <footer class="text-center mt-5">
    &copy; 2025 ESIG'MOVING - Tous droits réservés
  </footer>
</body>
</html>
