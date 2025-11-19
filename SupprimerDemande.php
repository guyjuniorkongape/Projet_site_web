<?php
session_start();
require_once 'connectbase.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: connexion.php');
    exit();
}

if (!isset($_GET['id'])) {
    exit("ID de la demande manquant.");
}

$id_demande = $_GET['id'];

// Supprimer les propositions liées à cette demande
$deletePropositions = $conn->prepare("DELETE FROM proposition WHERE id_demande = ?");
$deletePropositions->execute([$id_demande]);

// Supprimer les questions liées à cette demande (si ta table question existe)
$deleteQuestions = $conn->prepare("DELETE FROM question WHERE id_demande = ?");
$deleteQuestions->execute([$id_demande]);

// Supprimer la demande elle-même
$deleteDemande = $conn->prepare("DELETE FROM demande WHERE id_demande = ?");
$deleteDemande->execute([$id_demande]);

// Redirection vers la page de gestion
header("Location: GererClient.php"); 
exit();
