<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'administr') {
    header('Location: connexion.php');
    exit();
}

require_once 'connectbase.php';
$id_demenageur = $_SESSION['id_utilisateur'];

try {
    $sql = "SELECT 
        p.id_proposition AS id,
        d.id_demande,
        client.nom AS client_nom,
        d.description,
        d.date_demande,
        p.prix_estime,
        p.statut
    FROM proposition p
    JOIN demande d ON p.id_demande = d.id_demande
    JOIN utilisateur client ON d.id_client = client.id_utilisateur
    WHERE p.id_demenageur = :id_demenageur";

    $stmt = $conn->prepare($sql);
    $stmt->execute(['id_demenageur' => $id_demenageur]); 
    $demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>
