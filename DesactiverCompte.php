<?php
session_start();
require_once 'connectbase.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: connexion.php');
    exit();
}

$stmt = $conn->query("SELECT * FROM utilisateur WHERE role IN ('client', 'demenageur')");
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Activer/Désactiver un compte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4">Gestion des comptes utilisateurs</h2>

        <?php foreach ($utilisateurs as $user): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($user['nom']) ?> (<?= $user['role'] ?>)</h5>
                    <p class="card-text"><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
                    <p class="card-text"><strong>Statut :</strong> <?= $user['actif'] ? '✅ Actif' : '❌ Désactivé' ?></p>

                    <form method="post" action="TraitementDesactiver.php" class="d-inline">
                        <input type="hidden" name="id_utilisateur" value="<?= $user['id_utilisateur'] ?>">
                        <input type="hidden" name="action" value="<?= $user['actif'] ? 'desactiver' : 'reactiver' ?>">
                        <button type="submit" class="btn <?= $user['actif'] ? 'btn-danger' : 'btn-success' ?>">
                            <?= $user['actif'] ? 'Désactiver' : 'Réactiver' ?>
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>

        <a href="Administrateur.php" class="btn btn-secondary mt-4">← Retour au tableau de bord</a>
    </div>
</body>
</html>
