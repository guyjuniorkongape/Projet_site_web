<?php
session_start();
require_once 'connectbase.php';

if (!isset($_GET['id'])) {
    exit;
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT p.id_proposition, d.description, d.date_demande, p.prix_estime, p.statut
                        FROM proposition p
                        JOIN demande d ON p.id_demande = d.id_demande
                        WHERE p.id_proposition = ?");
$stmt->execute([$id]);
$proposition = $stmt->fetch();

if (!$proposition) {
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'refuser') {
        $update = $conn->prepare("UPDATE proposition SET statut = 'refusee' WHERE id_proposition = ?");
        $update->execute([$id]);
        $message = "Proposition refusée.";
    }

    if (isset($_POST['action']) && $_POST['action'] === 'valider' && isset($_POST['prix']) && $_POST['prix'] !== '') {
        $prix = $_POST['prix'];
        $update = $conn->prepare("UPDATE proposition SET prix_estime = ?, statut = 'acceptee' WHERE id_proposition = ?");
        $update->execute([$prix, $id]);
        $message = "Proposition acceptée avec succès.";
    }

    if (isset($_POST['action']) && $_POST['action'] === 'valider' && (!isset($_POST['prix']) || $_POST['prix'] === '')) {
        $message = "Veuillez proposer un prix avant d'accepter.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choisir une proposition</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="left-panel">
        <div class="logo-title">
            <img src="logoEM.png" alt="Logo" class="logo">
            <h1>Valider la proposition</h1>
        </div>

        <div style="background-color: white; padding: 30px; border-radius: 10px; width: 100%; max-width: 500px;">
            <?php if (isset($message)): ?>
                <p style="color: green; font-weight: bold;"><?= $message ?></p>
            <?php endif; ?>

            <p><strong>Demande :</strong> <?= htmlspecialchars($proposition['description']) ?></p>
            <p><strong>Date :</strong> <?= htmlspecialchars($proposition['date_demande']) ?></p>
            <p><strong>Prix actuel :</strong> <?= $proposition['prix_estime'] ? htmlspecialchars($proposition['prix_estime']) . ' €' : 'Non défini' ?></p>
            <p><strong>Statut :</strong> <?= htmlspecialchars($proposition['statut']) ?></p>

            <form method="post" class="buttons" style="margin-top: 20px;">
                <input type="number" name="prix" placeholder="Proposer un prix" step="0.01">
                <button type="submit" name="action" value="valider">Valider</button>
                <button type="submit" name="action" value="refuser" style="background-color: red; color: white;">Refuser</button>
            </form>
            <div class="buttons" style="margin-top: 20px;">
    <button onclick="window.location.href='ConsulterProposition.php'"> Retour aux propositions</button>
</div>

        </div>
    </div>

    <div class="right-panel">
        <img src="imgsalut.jpg" alt="Image" class="main-image">
    </div>
</div>
</body>
</html>
