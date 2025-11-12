<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // 'client' ou 'demenageur'

    require_once("connectbase.php");
    $mysqli = new mysqli($host, $login, $passwd, $dbname);

    if ($mysqli->connect_error) {
        $_SESSION['erreur'] = "Erreur de connexion à la base de données.";
        header("Location: creation_compte.php");
        exit();
    }

    // Vérifier si l'email existe déjà
    $check = $mysqli->prepare("SELECT id_utilisateur FROM utilisateur WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $_SESSION['erreur'] = "Cet email est déjà utilisé.";
        header("Location: creation_compte.php");
        exit();
    }
    $check->close();

    // Hash du mot de passe
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Insertion
    $stmt = $mysqli->prepare("INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nom, $prenom, $email, $password_hash, $role);

    if ($stmt->execute()) {
        $_SESSION['message'] = "✅ Compte créé avec succès !";
        header("Location: connexion.php");
    } else {
        $_SESSION['erreur'] = "Erreur lors de la création du compte.";
        header("Location: creation_compte.php");
    }

    $stmt->close();
    $mysqli->close();
}
?>
