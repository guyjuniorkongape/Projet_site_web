<?php
session_start();
require_once 'connectbase.php';

if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: connexion.php");
    exit();
}

$id_client = $_SESSION['id_utilisateur'];

$titre = $_POST['titre'];
$description = $_POST['description'];
$date_debut = $_POST['date_debut'];
$ville_depart = $_POST['ville_depart'];
$ville_arrivee = $_POST['ville_arrivee'];

$logement_depart = $_POST['logement_depart'];
$etage_depart = $_POST['etage_depart'];
$ascenseur_depart = isset($_POST['ascenseur_depart']) ? 1 : 0;

$logement_arrivee = $_POST['logement_arrivee'];
$etage_arrivee = $_POST['etage_arrivee'];
$ascenseur_arrivee = isset($_POST['ascenseur_arrivee']) ? 1 : 0;

$volume = $_POST['volume'];
$poids = $_POST['poids'];
$nb_dem = $_POST['nb_demenageurs'];

$image1 = null;
$image2 = null;

if (!empty($_FILES['image1']['name'])) {
    $image1 = "uploads/" . time() . "_" . $_FILES['image1']['name'];
    move_uploaded_file($_FILES['image1']['tmp_name'], $image1);
}

if (!empty($_FILES['image2']['name'])) {
    $image2 = "uploads/" . time() . "_" . $_FILES['image2']['name'];
    move_uploaded_file($_FILES['image2']['tmp_name'], $image2);
}

$sql = "INSERT INTO demande (
    id_client, titre, description, date_debut, 
    ville_depart, ville_arrivee,
    logement_depart, etage_depart, ascenseur_depart,
    logement_arrivee, etage_arrivee, ascenseur_arrivee,
    volume, poids, nb_demenageurs, image1, image2
) VALUES (
    :id_client, :titre, :description, :date_debut,
    :ville_depart, :ville_arrivee,
    :log_d, :et_d, :asc_d,
    :log_a, :et_a, :asc_a,
    :volume, :poids, :nb_dem, :img1, :img2
)";

$stmt = $conn->prepare($sql);

$ok = $stmt->execute([
    'id_client' => $id_client,
    'titre' => $titre,
    'description' => $description,
    'date_debut' => $date_debut,
    'ville_depart' => $ville_depart,
    'ville_arrivee' => $ville_arrivee,
    'log_d' => $logement_depart,
    'et_d' => $etage_depart,
    'asc_d' => $ascenseur_depart,
    'log_a' => $logement_arrivee,
    'et_a' => $etage_arrivee,
    'asc_a' => $ascenseur_arrivee,
    'volume' => $volume,
    'poids' => $poids,
    'nb_dem' => $nb_dem,
    'img1' => $image1,
    'img2' => $image2
]);

if ($ok) {
    header("Location: client.php?success=1");
    exit();
} else {
    echo "Erreur lors de l'insertion.";
}
?>
