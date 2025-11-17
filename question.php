<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once("connectbase.php");
    $mysqli = new mysqli($host, $login, $passwd, $dbname);

    if ($mysqli->connect_error) {
        $_SESSION['erreur'] = "Erreur de connexion à la base.";
        header("Location: Question.php");
        exit();
    }

    $id_demande = $_POST['id_demande'];
    $id_auteur = $_SESSION['id_utilisateur'];
    $contenu_question = $_POST['contenu_question'];

    $stmt = $mysqli->prepare("INSERT INTO question (id_demande, id_auteur, contenu_question) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $id_demande, $id_auteur, $contenu_question);

    if ($stmt->execute()) {
        $_SESSION['message'] = "✅ Question envoyée avec succès.";
        header("Location: Question.php");
    } else {
        $_SESSION['erreur'] = "Erreur lors de l'envoi de la question.";
        header("Location: Question.php");
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
  <title>Questions des déménageurs | ESIG'MOVING</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style2.css">
</head>
<body>
  <header>
    <img src="logoEM.png" alt="Logo" class="logo">
    <h1>ESIG’MOVING</h1>
    <h3>Questions reçues</h3>
  </header>

  <main class="container text-center">
    <div class="form-box">
      <h4>Liste des questions</h4>
      <div class="mt-3 text-start">
        <button class="btn btn-outline-dark">Répondre</button>
      </div>
      <hr>
      <div class="text-start">
        <button class="btn btn-outline-dark">Répondre</button>
      </div>
      <div class="text-center mt-4">
        <a href="client.php" class="btn btn-custom">Retour au tableau de bord</a>
      </div>
    </div>
  </main>
</body>
</html>
