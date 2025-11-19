<?php
session_start();
require_once 'connectbase.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: connexion.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_utilisateur'], $_POST['action'])) {
    $id = $_POST['id_utilisateur'];
    $action = $_POST['action'];

    $stmt = $conn->prepare("UPDATE utilisateur SET actif = :val WHERE id_utilisateur = :id");
    $stmt->execute([
        'val' => $action === 'desactiver' ? 0 : 1,
        'id' => $id
    ]);

    header('Location: DesactiverCompte.php');
    exit();
}
?>
