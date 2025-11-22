<?php
session_start();
require_once 'connectbase.php';

// Vérification du rôle
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'client') {
    header("Location: connexion.php");
    exit();
}

if (!isset($_GET['id'])) {
    exit("ID de proposition manquant.");
}

$id_proposition = $_GET['id'];
$id_client = $_SESSION['id_utilisateur'];

// Vérifier que la proposition appartient au client
$sql = "SELECT p.id_proposition
        FROM proposition p
        JOIN demande d ON p.id_demande = d.id_demande
        WHERE p.id_proposition = ? AND d.id_client = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id_proposition, $id_client]);
$prop = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$prop) {
    exit("Accès refusé.");
}

// Mettre la proposition en refusee
$sql = "UPDATE proposition SET statut = 'refusee' WHERE id_proposition = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id_proposition]);

header("Location: client.php?msg=proposition_refusee");
exit();
?>
