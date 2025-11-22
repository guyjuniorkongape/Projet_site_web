<?php
session_start();
require_once 'connectbase.php';

// Vérifier rôle
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'client') {
    header('Location: connexion.php');
    exit();
}

if (!isset($_GET['id'])) {
    exit("ID de proposition manquant.");
}

$id_proposition = $_GET['id'];
$id_client = $_SESSION['id_utilisateur'];

// Récupération de la proposition + demande + déménageur
$sql = "
SELECT 
    p.id_proposition,
    p.prix_estime,
    p.statut,
    
    u.nom AS dem_nom,
    u.prenom AS dem_prenom,
    
    d.titre,
    d.description,
    d.date_debut,
    d.ville_depart,
    d.ville_arrivee,
    d.logement_depart,
    d.etage_depart,
    d.ascenseur_depart,
    d.logement_arrivee,
    d.etage_arrivee,
    d.ascenseur_arrivee,
    d.volume,
    d.poids,
    d.nb_demenageurs,
    d.image1,
    d.image2

FROM proposition p
JOIN demande d ON p.id_demande = d.id_demande
JOIN utilisateur u ON p.id_demenageur = u.id_utilisateur
WHERE p.id_proposition = ? AND d.id_client = ?
";

$stmt = $conn->prepare($sql);
$stmt->execute([$id_proposition, $id_client]);
$prop = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$prop) {
    exit("Impossible d'afficher cette proposition.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Proposition du déménageur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <h2 class="text-center mb-4">Proposition du déménageur</h2>

    <div class="card p-4">
        <h4><?= htmlspecialchars($prop['dem_nom'] . " " . $prop['dem_prenom']) ?></h4>
        <p><strong>Prix proposé :</strong> <?= htmlspecialchars($prop['prix_estime']) ?> €</p>
        <p><strong>Statut :</strong> <?= htmlspecialchars($prop['statut']) ?></p>
    </div>

    <hr>

    <h4>📦 Détails de votre demande</h4>
    <ul>
        <li><strong>Titre:</strong> <?= htmlspecialchars($prop['titre']) ?></li>
        <li><strong>Description:</strong> <?= htmlspecialchars($prop['description']) ?></li>
        <li><strong>Date de début:</strong> <?= htmlspecialchars($prop['date_debut']) ?></li>
        <li><strong>Départ:</strong> <?= htmlspecialchars($prop['ville_depart']) ?></li>
        <li><strong>Arrivée:</strong> <?= htmlspecialchars($prop['ville_arrivee']) ?></li>
        <li><strong>Volume:</strong> <?= htmlspecialchars($prop['volume']) ?> m³</li>
        <li><strong>Poids:</strong> <?= htmlspecialchars($prop['poids']) ?> kg</li>
    </ul>

    <div class="row">
        <?php if ($prop['image1']): ?>
        <div class="col-md-4">
            <img src="<?= $prop['image1'] ?>" class="img-fluid rounded shadow">
        </div>
        <?php endif; ?>

        <?php if ($prop['image2']): ?>
        <div class="col-md-4">
            <img src="<?= $prop['image2'] ?>" class="img-fluid rounded shadow">
        </div>
        <?php endif; ?>
    </div>

    <hr>

    <!-- BOUTONS D'ACTION -->
    <div class="d-flex gap-3">
        <a href="AccepterProposition.php?id=<?= $prop['id_proposition'] ?>" class="btn btn-success">
            ✔ Accepter
        </a>
        <a href="RefuserProposition.php?id=<?= $prop['id_proposition'] ?>" class="btn btn-danger">
            ✖ Refuser
        </a>
        <a href="client.php" class="btn btn-secondary">Retour</a>
    </div>

</div>

</body>
</html>
