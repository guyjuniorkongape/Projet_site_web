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
