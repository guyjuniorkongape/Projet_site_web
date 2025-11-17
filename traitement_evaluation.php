<?php
session_start();
require_once("connectbase.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_SESSION['id_utilisateur'])) {
        header("Location: connexion.php");
        exit();
    }

    $id_client = $_SESSION['id_utilisateur'];
    $id_demenageur = $_POST['id_demenageur'];
    $note = $_POST['note'];
    $commentaire = $_POST['commentaire'];

    $stmt = $conn->prepare("
        INSERT INTO evaluation (id_client, id_demenageur, note, commentaire)
        VALUES (?, ?, ?, ?)
    ");

    $success = $stmt->execute([$id_client, $id_demenageur, $note, $commentaire]);

    if ($success) {
        $_SESSION['message'] = "Évaluation envoyée avec succès !";
        header("Location: client.php");
        exit();
    } else {
        $_SESSION['erreur'] = "Erreur lors de l'enregistrement.";
        header("Location: Evaluation.php");
        exit();
    }
}
?>
