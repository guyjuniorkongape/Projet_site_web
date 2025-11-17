
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une demande | ESIG'MOVING</title>
    <link rel="stylesheet" href="style2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<header>
    <img src="logoEM.png" class="logo">
    <h1>Créer une demande</h1>
</header>

<div class="container mt-4">
<form action="traitement_demande.php" method="POST" enctype="multipart/form-data" class="form-box">

    <h3 class="text-center">Nouvelle demande de déménagement</h3>
    <hr>

    <!-- TITRE -->
    <div class="mb-3">
        <label class="form-label">Titre de la demande</label>
        <input type="text" class="form-control" name="titre" required>
    </div>

    <!-- DESCRIPTION -->
    <div class="mb-3">
        <label class="form-label">Description rapide</label>
        <textarea class="form-control" name="description" rows="3" required></textarea>
    </div>

    <!-- DATE + HEURE -->
    <div class="mb-3">
        <label class="form-label">Date et heure du déménagement</label>
        <input type="datetime-local" class="form-control" name="date_debut" required>
    </div>

    <!-- VILLES -->
    <div class="row mb-3">
        <div class="col">
            <label class="form-label">Ville de départ</label>
            <input type="text" class="form-control" name="ville_depart" required>
        </div>
        <div class="col">
            <label class="form-label">Ville d’arrivée</label>
            <input type="text" class="form-control" name="ville_arrivee" required>
        </div>
    </div>

    <!-- LOGEMENT DÉPART -->
    <h5 class="mt-4">Logement de départ</h5>
    <div class="row mb-3">
        <div class="col">
            <label>Type</label>
            <select class="form-select" name="logement_depart">
                <option value="maison">Maison</option>
                <option value="appartement">Appartement</option>
            </select>
        </div>
        <div class="col">
            <label>Étage</label>
            <input type="number" class="form-control" name="etage_depart">
        </div>
        <div class="col text-center">
            <label>Ascenseur</label><br>
            <input type="checkbox" name="ascenseur_depart" value="1">
        </div>
    </div>

    <!-- LOGEMENT ARRIVÉE -->
    <h5 class="mt-4">Logement d’arrivée</h5>
    <div class="row mb-3">
        <div class="col">
            <label>Type</label>
            <select class="form-select" name="logement_arrivee">
                <option value="maison">Maison</option>
                <option value="appartement">Appartement</option>
            </select>
        </div>
        <div class="col">
            <label>Étage</label>
            <input type="number" class="form-control" name="etage_arrivee">
        </div>
        <div class="col text-center">
            <label>Ascenseur</label><br>
            <input type="checkbox" name="ascenseur_arrivee" value="1">
        </div>
    </div>

    <!-- VOLUME / POIDS -->
    <div class="row mb-3">
        <div class="col">
            <label>Volume total (m³)</label>
            <input type="number" step="0.1" class="form-control" name="volume">
        </div>
        <div class="col">
            <label>Poids total (kg)</label>
            <input type="number" class="form-control" name="poids">
        </div>
    </div>

    <!-- NOMBRE DEMENAGEURS -->
    <div class="mb-3">
        <label>Nombre de déménageurs souhaités</label>
        <input type="number" class="form-control" name="nb_demenageurs" required>
    </div>

    <!-- IMAGES -->
    <div class="mb-3">
        <label>Images du logement</label>
        <input type="file" class="form-control" name="image1">
        <input type="file" class="form-control mt-2" name="image2">
    </div>

    <button type="submit" class="btn btn-dark w-100 mt-3">Envoyer la demande</button>
    <a href="client.php" class="btn btn-outline-dark w-100 mt-2">Retour</a>

</form>
</div>

</body>
</html
