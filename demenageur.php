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
    $stmt->execute(['id_demenageur' => $id_demenageur]); // ✅ correction ici
    $demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord déménageur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="logo-title">
        <img src="logoEM.png" alt="Logo EM" class="logo">
        <h1>ESIG'MOVING</h1>
    </div>

    <div class="banner-image">
        <img src="imageCANAP.jpg" alt="Personnes" class="main-image">
    </div>

    <div class="container">
        <div class="center-panel">
            <div>
                <h2>Bienvenue, <?= htmlspecialchars($_SESSION['nom']) ?> !</h2>
                <p>Voici les demandes que vous avez acceptées :</p>

                <?php if (!empty($demandes)): ?>
                    <?php foreach ($demandes as $prop): ?>
                        <div style="background-color: white; padding: 20px; border-radius: 10px; width: 80%; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                            <p><strong>Client :</strong> <?= htmlspecialchars($prop['client_nom']) ?></p>
                            <p><strong>Demande :</strong> <?= htmlspecialchars($prop['description']) ?></p>
                            <p><strong>Date :</strong> <?= htmlspecialchars($prop['date_demande']) ?></p>
                            <p><strong>Prix proposé :</strong> 
                                <?= $prop['prix_estime'] !== null && $prop['prix_estime'] !== '' ? htmlspecialchars($prop['prix_estime']) . ' €' : 'Pas encore proposé' ?>
                            </p>
                            <p><strong>Statut :</strong> <?= htmlspecialchars($prop['statut']) ?></p>

                            <div class="buttons" style="margin-top: 10px;">
                                <button onclick="window.location.href='Question.php?id=<?= urlencode($prop['id_demande']) ?>'" style="background-color: #007BFF; color: white;">Question</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucune demande acceptée pour le moment.</p>
                <?php endif; ?>
            </div>

            <div class="buttons" style="margin-top: 30px;">
                <button onclick="location.href='ConsulterProposition.php'">Voir les propositions</button>
                <button onclick="location.href='Deconnexion.php'">Se déconnecter</button>
            </div>
        </div>
    </div>

</body>
</html>
