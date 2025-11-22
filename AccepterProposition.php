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

// 1️⃣ Récupérer la demande liée à la proposition
$sql = "SELECT p.id_demande 
        FROM proposition p 
        JOIN demande d ON p.id_demande = d.id_demande
        WHERE p.id_proposition = ? AND d.id_client = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id_proposition, $id_client]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    exit("Accès refusé à cette proposition.");
}

$id_demande = $result['id_demande'];

// 2️⃣ Mettre la proposition en "valide"
$sql = "UPDATE proposition SET statut = 'valide' WHERE id_proposition = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id_proposition]);

// 3️⃣ Refuser toutes les autres propositions
$sql = "UPDATE proposition 
        SET statut = 'refusee' 
        WHERE id_demande = ? AND id_proposition != ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id_demande, $id_proposition]);

// 4️⃣ Mettre la demande en "en_cours"
$sql = "UPDATE demande 
        SET statut = 'en_cours' 
        WHERE id_demande = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id_demande]);

// Redirection
header("Location: client.php?msg=proposition_acceptee");
exit();
?>
