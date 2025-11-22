<?php
session_start();
require_once 'connectbase.php';


if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: connexion.php");
    exit();
}

if (!isset($_GET['id'])) {
    exit("ID de la demande manquant.");
}

$id_demande = $_GET['id'];
$id_utilisateur = $_SESSION['id_utilisateur'];
$role = $_SESSION['role'];


//  RÉCUPÉRATION DE LA DEMANDE 
$stmt = $conn->prepare("SELECT * FROM demande WHERE id_demande = ?");
$stmt->execute([$id_demande]);
$demande = $stmt->fetch();

if (!$demande) {
    exit("Demande introuvable.");
}


//  INSERTION D’UNE QUESTION 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['contenu'])) {

    $contenu = trim($_POST['contenu']);

    if (!empty($contenu)) {
        $insert = $conn->prepare("
            INSERT INTO question (id_demande, id_auteur, contenu_question)
            VALUES (?, ?, ?)
        ");
        $insert->execute([$id_demande, $id_utilisateur, $contenu]);
    }

    // Rafraîchissement pour éviter double envoi
    header("Location: question.php?id=".$id_demande);
    exit();
}


//  RÉCUPÉRATION DES QUESTIONS 
$qstmt = $conn->prepare("
    SELECT q.*, u.nom
    FROM question q
    JOIN utilisateur u ON q.id_auteur = u.id_utilisateur
    WHERE q.id_demande = ?
    ORDER BY q.date_question ASC
");
$qstmt->execute([$id_demande]);
$questions = $qstmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Discussion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1a75cf;">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="logoEM.png" alt="Logo" width="40" class="me-2">
            ESIG'MOVING
        </a>
    </div>
</nav>

<div class="container-fluid py-4">
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Discussion</h2>
                    <p><strong>Description :</strong> <?= htmlspecialchars($demande['description']) ?></p>
                    <p><strong>Date :</strong> <?= htmlspecialchars($demande['date_demande']) ?></p>
                    <hr>

                    <?php if (!empty($questions)): ?>
                        <?php foreach ($questions as $q): ?>
                            <div class="mb-3">
                                <strong><?= htmlspecialchars($q['nom']) ?> :</strong><br>
                                <span><?= nl2br(htmlspecialchars($q['contenu_question'])) ?></span><br>
                                <small class="text-muted"><?= htmlspecialchars($q['date_question']) ?></small>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert alert-info">Aucune question pour le moment.</div>
                    <?php endif; ?>

                    <form method="post" class="mt-4">
                        <div class="mb-3">
                            <textarea name="contenu" rows="3" class="form-control" placeholder="Votre question ou réponse..."></textarea>
                        </div>
                        <button type="submit" class="btn text-white" style="background-color: #1a75cf;">Envoyer</button>
                    </form>

                    <div class="mt-4 text-center">
                        <?php if ($role === 'client'): ?>
                            <a href="client.php" class="btn btn-outline-secondary">Retour</a>
                        <?php elseif ($role === 'demenageur'): ?>
                            <a href="demenageur.php" class="btn btn-outline-secondary">Retour</a>
                        <?php else: ?>
                            <a href="index.php" class="btn btn-outline-secondary">Retour</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
