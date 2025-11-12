<?php
session_start();
require_once("connectbase.php");

// Vérifie si le client est bien connecté
if (!isset($_SESSION['id_utilisateur']) || $_SESSION['role'] !== 'client') {
    header("Location: connexion.php");
    exit();
}

$id_client = $_SESSION['id_utilisateur'];

// Connexion à la base de données
$mysqli = new mysqli($host, $login, $passwd, $dbname);
if ($mysqli->connect_error) {
    die("Erreur de connexion : " . $mysqli->connect_error);
}

// Récupérer les déménageurs ayant postulé à ses demandes
$sql = "SELECT DISTINCT u.nom, u.prenom, p.statut, p.id_proposition
        FROM proposition p
        JOIN demande d ON p.id_demande = d.id_demande
        JOIN utilisateur u ON p.id_demenageur = u.id_utilisateur
        WHERE d.id_client = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id_client);
$stmt->execute();
$result = $stmt->get_result();

$demenageurs = [];
while ($row = $result->fetch_assoc()) {
    $demenageurs[] = $row;
}
$stmt->close();
$mysqli->close();
?>

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
