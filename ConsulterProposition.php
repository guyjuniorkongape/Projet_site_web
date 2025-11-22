<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'demenageur') {
    header('Location: connexion.php');
    exit();
}

require_once 'connectbase.php';
$id_demenageur = $_SESSION['id_utilisateur'];

try {
    $sql = "SELECT 
        p.id_proposition AS id,
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
    $propositions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Propositions reçues</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1a75cf;">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="logoEM.png" alt="Logo EM" width="40" class="me-2">
            ESIG'MOVING
        </a>
        <div class="d-flex">
            <a href="Deconnexion.php" class="btn btn-outline-light">Se déconnecter</a>
        </div>
    </div>
</nav>

<div class="container-fluid py-4">
    <div class="row g-4">
        <div class="col-lg-6">
            <h2 class="mb-4">Voici toutes les annonces :</h2>

            <?php if (!empty($propositions)): ?>
                <?php foreach ($propositions as $prop): ?>
                    <a href="choisirProposition.php?id=<?= urlencode($prop['id']) ?>" class="text-decoration-none text-dark">
                        <div class="card mb-3 shadow-sm">
                            <div class="card-body">
                                <p><strong>Client :</strong> <?= htmlspecialchars($prop['client_nom']) ?></p>
                                <p><strong>Demande :</strong> <?= htmlspecialchars($prop['description']) ?></p>
                                <p><strong>Date :</strong> <?= htmlspecialchars($prop['date_demande']) ?></p>
                                <p><strong>Prix proposé :</strong> 
                                    <?= $prop['prix_estime'] !== null && $prop['prix_estime'] !== '' 
                                        ? htmlspecialchars($prop['prix_estime']) . ' €' 
                                        : 'Pas encore proposé' ?>
                                </p>
                                <p><strong>Statut :</strong> <?= htmlspecialchars($prop['statut']) ?></p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-info">Aucune proposition reçue pour le moment.</div>
            <?php endif; ?>
        </div>

        <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <img src="imgdemande.jpeg" alt="Personnes" class="img-fluid rounded shadow">
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
