<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once("connectbase.php");
    $mysqli = new mysqli($host, $login, $passwd, $dbname);

    if ($mysqli->connect_error) {
        $_SESSION['erreur'] = "Erreur de connexion à la base.";
        header("Location: Evaluation.php");
        exit();
    }

    $id_client = $_SESSION['id_utilisateur'];
    $id_demenageur = $_POST['id_demenageur'];
    $note = $_POST['note'];
    $commentaire = $_POST['commentaire'];

    $stmt = $mysqli->prepare("INSERT INTO evaluation (id_client, id_demenageur, note, commentaire) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $id_client, $id_demenageur, $note, $commentaire);

    if ($stmt->execute()) {
        $_SESSION['message'] = "✅ Évaluation envoyée avec succès !";
        header("Location: client.php");
    } else {
        $_SESSION['erreur'] = "Erreur lors de l'enregistrement de l'évaluation.";
        header("Location: Evaluation.php");
    }

    $stmt->close();
    $mysqli->close();
}
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
      <img src="photo_projet.png" alt="Déménageur" class="rounded mb-3" style="width:120px; height:120px; object-fit:cover;">
      <form action="#" method="post">
        <label for="note">Note (sur 5)</label>
        <select id="note" name="note" class="form-select mb-3" required>
          <option value="">Choisir...</option>
          <option value="1">1 ★</option>
          <option value="2">2 ★★</option>
          <option value="3">3 ★★★</option>
          <option value="4">4 ★★★★</option>
          <option value="5">5 ★★★★★</option>
        </select>

        <label for="commentaire">Commentaire</label>
        <textarea id="commentaire" name="commentaire" rows="4"></textarea>

        <button type="submit" class="btn btn-outline-dark w-100 mt-3">Envoyer l’évaluation</button>
      </form>

      <div class="text-center mt-3">
        <a href="client.php" class="btn btn-custom">Retour au tableau de bord</a>
      </div>
    </div>
  </main>
</body>
</html>
