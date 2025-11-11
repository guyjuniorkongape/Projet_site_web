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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <div class="logo-title">
                <img src="logoEM.png" alt="Logo EM" class="logo">
                <h1>ESIG'MOVING</h1>
            </div>

            <h2>Voici toutes les propositions que vous avez faites :</h2>

            <?php if (!empty($propositions)): ?>
                <?php foreach ($propositions as $prop): ?>
                    <a href="choisirProposition.php?id=<?= urlencode($prop['id']) ?>" style="text-decoration: none; color: inherit;">
                        <div style="background-color: white; padding: 20px; border-radius: 10px; width: 80%; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); cursor: pointer;">
                            <p><strong>Client :</strong> <?= htmlspecialchars($prop['client_nom']) ?></p>
                            <p><strong>Demande :</strong> <?= htmlspecialchars($prop['description']) ?></p>
                            <p><strong>Date :</strong> <?= htmlspecialchars($prop['date_demande']) ?></p>
                            <p><strong>Prix proposé :</strong> 
                                <?= $prop['prix_estime'] !== null && $prop['prix_estime'] !== '' ? htmlspecialchars($prop['prix_estime']) . ' €' : 'Pas encore proposé' ?>
                            </p>
                            <p><strong>Statut :</strong> <?= htmlspecialchars($prop['statut']) ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune proposition reçue pour le moment.</p>
            <?php endif; ?>

            <div class="buttons">
                <button onclick="location.href='Deconnexion.php'">Se déconnecter</button>
            </div>
        </div>

        <div class="right-panel">
            <img src="imgdemande.jpeg" alt="Personnes" class="main-image">
        </div>
    </div>
</body>
</html>
