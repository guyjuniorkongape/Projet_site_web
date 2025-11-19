<?php
session_start();
require_once 'connectbase.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: connexion.php');
    exit();
}

// Récupérer toutes les demandes avec info client
$sql = "SELECT 
    d.id_demande,
    d.description,
    d.date_demande,
    u.nom AS client_nom,
    u.email
FROM demande d
JOIN utilisateur u ON d.id_client = u.id_utilisateur";

$stmt = $conn->query($sql);
$demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les annonces clients</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #e3f2fd;">

<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #b5d8ee;">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="logoEM.png" alt="Logo" width="40" class="me-2">
            <strong>ESIG'MOVING - Admin</strong>
        </a>
        <div class="d-flex">
            <a href="admin.php" class="btn btn-outline-dark">Retour au tableau de bord</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <h2 class="mb-4 text-center">Annonces des clients</h2>

    <?php if (!empty($demandes)): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white">
                <thead class="table-light">
                    <tr>
                        <th>Client</th>
                        <th>Email</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($demandes as $demande): ?>
                        <tr>
                            <td><?= htmlspecialchars($demande['client_nom']) ?></td>
                            <td><?= htmlspecialchars($demande['email']) ?></td>
                            <td><?= htmlspecialchars($demande['description']) ?></td>
                            <td><?= htmlspecialchars($demande['date_demande']) ?></td>
                            <td>
                                <a href="SupprimerDemande.php?id=<?= urlencode($demande['id_demande']) ?>" class="btn btn-danger btn-sm">
                                    🗑 Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">Aucune demande enregistrée.</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
