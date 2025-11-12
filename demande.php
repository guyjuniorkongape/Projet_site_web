<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once("connectbase.php");
    $mysqli = new mysqli($host, $login, $passwd, $dbname);

    if ($mysqli->connect_error) {
        $_SESSION['erreur'] = "Erreur de connexion à la base.";
        header("Location: Demande.php");
        exit();
    }

    $id_client = $_SESSION['id_utilisateur'];
    $description = $_POST['description'];


    if ($mysqli->connect_error) {
        $_SESSION['erreur'] = "Erreur de connexion à la base.";
        header("Location: Demande.php");
        exit();
    }

    $id_client = $_SESSION['id_utilisateur'];
    $description = $_POST['description'];

    $stmt = $mysqli->prepare("INSERT INTO demande (id_client, description) VALUES (?, ?)");
    $stmt->bind_param("is", $id_client, $description);

    if ($stmt->execute()) {
        $_SESSION['message'] = "✅ Demande enregistrée avec succès !";
        header("Location: client.php");
    } else {
        $_SESSION['erreur'] = "Erreur lors de la création de la demande.";
        header("Location: Demande.php");
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
  <title>Créer une demande | ESIG'MOVING</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style2.css">
</head>
<body>
  <header>
    <img src="logoEM.png" alt="Logo" class="logo">
    <h1>ESIG’MOVING</h1>
    <h3>Nouvelle demande</h3>
  </header>

  <main class="container d-flex flex-column align-items-center">
    <div class="form-box">
      <form action="#" method="post">
        <label for="adresse">Adresse de départ</label>
        <input type="text" id="adresse" name="adresse" required>

        <label for="destination">Adresse de destination</label>
        <input type="text" id="destination" name="destination" required>

        <label for="date">Date du déménagement</label>
        <input type="date" id="date" name="date" required>

        <label for="details">Détails supplémentaires</label>
        <textarea id="details" name="details" rows="4"></textarea>

        <button type="submit" class="btn btn-outline-dark w-100 mt-3">Enregistrer la demande</button>
      </form>

      <div class="text-center mt-3">
        <a href="client.php" class="btn btn-custom">Retour au tableau de bord</a>
      </div>
    </div>
  </main>
</body>
</html>
