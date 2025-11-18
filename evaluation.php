<?php
session_start();
require_once("connectbase.php");

// Vérifie si le client est connecté
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'client') {
    header("Location: connexion.php");
    exit();
}

$id_client = $_SESSION['id_utilisateur'];

// Récupérer les déménagements terminés
$sql = "
    SELECT 
        u.id_utilisateur AS id_demenageur,
        u.nom,
        u.prenom,
        d.id_demande
    FROM demande d
    JOIN proposition p ON p.id_demande = d.id_demande
    JOIN utilisateur u ON u.id_utilisateur = p.id_demenageur
    WHERE d.id_client = ?
      AND d.statut = 'terminee'
      AND p.statut = 'acceptee'
";

$stmt = $conn->prepare($sql);
$stmt->execute([$id_client]);
$demenageurs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Évaluer un déménageur | ESIG'MOVING</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style2.css">
</head>
<body>
  <header>
    <img src="logoEM.png" alt="Logo" class="logo">
    <h1>ESIG’MOVING</h1>
    <h3>Évaluation du déménageur</h3>
  </header>

  <main class="container d-flex flex-column align-items-center">

    <div class="form-box text-center">

      <?php if (empty($demenageurs)): ?>
          <p>Aucun déménagement terminé n'est disponible pour une évaluation.</p>
          <a href="client.php" class="btn btn-custom mt-3">Retour</a>

      <?php else: ?>

      <form action="traitement_evaluation.php" method="post">

        <label for="id_demenageur">Sélectionner un déménageur :</label>
        <select name="id_demenageur" id="id_demenageur" class="form-select mb-3" required>
            <option value="">Choisir...</option>

            <?php foreach ($demenageurs as $d): ?>
                <option value="<?= $d['id_demenageur'] ?>">
                    <?= htmlspecialchars($d['nom'] . " " . $d['prenom']) ?> 
                    (Demande n°<?= $d['id_demande'] ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <label for="note">Note (sur 5)</label>
        <select id="note" name="note" class="form-select mb-3" required>
          <option value="">Choisir...</option>
          <option value="1">★</option>
          <option value="2">★★</option>
          <option value="3">★★★</option>
          <option value="4">★★★★</option>
          <option value="5">★★★★★</option>
        </select>

        <label for="commentaire">Commentaire</label>
        <textarea id="commentaire" name="commentaire" rows="3" class="form-control"></textarea>

        <button type="submit" class="btn btn-outline-dark w-100 mt-3">
          Envoyer l’évaluation
        </button>
      </form>

      <?php endif; ?>

      <div class="text-center mt-3">
        <a href="client.php" class="btn btn-custom">Retour au tableau de bord</a>
      </div>
    </div>
  </main>
</body>
</html>
