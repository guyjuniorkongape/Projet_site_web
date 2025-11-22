<?php
session_start();
require_once("connectbase.php");

// Vérifie si le client est bien connecté
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'client') {
    header("Location: connexion.php");
    exit();
}

$id_client = $_SESSION['id_utilisateur'];

// --- Récupération des demandes du client ---
$sqlDemandes = "SELECT * FROM demande WHERE id_client = ?";
$stmtDemandes = $conn->prepare($sqlDemandes);
$stmtDemandes->execute([$id_client]);
$demandes = $stmtDemandes->fetchAll(PDO::FETCH_ASSOC);

// --- Récupération des déménageurs ayant postulé ---
$sql = "
    SELECT DISTINCT u.nom, u.prenom, p.statut, p.id_proposition
    FROM proposition p
    JOIN demande d ON p.id_demande = d.id_demande
    JOIN utilisateur u ON p.id_demenageur = u.id_utilisateur
    WHERE d.id_client = ?
";

$stmt = $conn->prepare($sql);
$stmt->execute([$id_client]);
$demenageurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    <!-- BOUTONS PRINCIPAUX -->
    <div class="row justify-content-center">
      <div class="col-md-3">
        <div class="card">
          <img src="imgdemande.jpeg" alt="Demande" class="card-img-top">
          <h4>Créer une demande</h4>
          <a href="demande.php" class="btn btn-outline-dark mt-2">Faire une demande</a>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card">
          <img src="imgevaluation.webp" alt="Évaluation" class="card-img-top">
          <h4>Évaluer un déménageur</h4>
          <a href="evaluation.php" class="btn btn-outline-dark mt-2">Évaluer</a>
        </div>
      </div>
    </div>

    <!-- AFFICHAGE DES DEMANDES -->
    <div class="card mt-5">
      <h4>Vos demandes</h4>

      <?php if (!empty($demandes)): ?>
      <table class="table table-striped text-center mt-3">
        <thead>
          <tr>
            <th>Titre</th>
            <th>Date</th>
            <th>Voir Discussion</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($demandes as $d): ?>
            <tr>
              <td><?= htmlspecialchars($d['titre']) ?></td>
              <td><?= htmlspecialchars($d['date_demande']) ?></td>
              <td>
                <a href="Question.php?id=<?= $d['id_demande'] ?>" class="btn btn-primary btn-sm">Voir</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <?php else: ?>
        <p>Aucune demande pour le moment.</p>
      <?php endif; ?>
    </div>

    <!-- DEMENAGEURS AYANT POSTULÉ -->
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

        <tbody>
        <?php if (!empty($demenageurs)): ?>
          <?php foreach ($demenageurs as $d): ?>
            <tr>
              <td><?= htmlspecialchars($d['nom']) . " " . htmlspecialchars($d['prenom']) ?></td>
              <td><?= htmlspecialchars($d['statut']) ?></td>
              <td>
                <a href="ConsulterPropositionclient.php?id=<?= $d['id_proposition'] ?>" class="btn btn-success btn-sm">
                  Consulter Proposition
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="3">Aucun déménageur n’a encore postulé.</td></tr>
        <?php endif; ?>
        </tbody>
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
