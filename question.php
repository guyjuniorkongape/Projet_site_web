<?php
session_start();
require_once 'connectbase.php';

if (!isset($_GET['id'])) {
    exit("Il faut un ID");
}

$id_demande = $_GET['id'];
$id_utilisateur = $_SESSION['id_utilisateur'];


$stmt = $conn->prepare("SELECT * FROM demande WHERE id_demande = ?");
$stmt->execute([$id_demande]);
$demande = $stmt->fetch();

if (!$demande) {
    exit("Demande introuvable.");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['contenu'])) {
    $contenu = $_POST['contenu'];
    $insert = $conn->prepare("INSERT INTO question (id_demande, id_auteur, contenu_question) VALUES (?, ?, ?)");
    $insert->execute([$id_demande, $id_utilisateur, $contenu]);
}


$qstmt = $conn->prepare("SELECT q.*, u.nom FROM question q JOIN utilisateur u ON q.id_auteur = u.id_utilisateur WHERE q.id_demande = ? ORDER BY q.date_question ASC");
$qstmt->execute([$id_demande]);
$questions = $qstmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Discussione</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="left-panel">
        <div class="logo-title">
            <img src="logoEM.png" alt="Logo" class="logo">
            <h1>Discussion</h1>
        </div>

        <div style="background-color: white; padding: 20px; border-radius: 10px; width: 90%; max-width: 600px;">
            <p><strong>Description :</strong> <?= htmlspecialchars($demande['description']) ?></p>
            <p><strong>Date :</strong> <?= htmlspecialchars($demande['date_demande']) ?></p>

            <?php if (!empty($questions)): ?>
                <?php foreach ($questions as $q): ?>
                    <div style="margin-bottom: 15px;">
                        <strong><?= htmlspecialchars($q['nom']) ?> :</strong><br>
                        <span><?= htmlspecialchars($q['contenu_question']) ?></span><br>
                        <span><?= htmlspecialchars($q['date_question']) ?></span><br>
            
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune question pour le moment.</p>
            <?php endif; ?>

            <form method="post" style="margin-top: 20px;">
                <textarea name="contenu" rows="3" style="width: 100%;" placeholder="Votre question..."></textarea>
                <button type="submit" style=" margin-top: 10px; background-color: #007BFF; color: white;">Envoyer</button>
            </form>

            <div class="buttons" style="margin-top: 20px;">
                <button onclick="window.location.href='demenageur.php'">Retour</button>
            </div>
        </div>
    </div>

    <div class="right-panel">
        <img src="imgsalut.jpg" alt="Image" class="main-image">
    </div>
</div>
</body>
</html>
