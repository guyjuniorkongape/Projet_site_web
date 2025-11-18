<?php
session_start();
require_once 'connectbase.php'; // garde PDO

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password_user = $_POST['password'];
    $role = $_POST['role']; // client ou demenageur

    // 1. Vérifier si email existe déjà
    $check = $conn->prepare("SELECT id_utilisateur FROM utilisateur WHERE email = ?");
    $check->execute([$email]);

    if ($check->rowCount() > 0) {
        $_SESSION['erreur'] = "Cet email est déjà utilisé.";
        header("Location: creation_compte.php");
        exit();
    }

    // 2. Hash du mot de passe
    $password_hash = password_hash($password_user, PASSWORD_BCRYPT);

    // 3. Insertion en PDO
    $stmt = $conn->prepare("
        INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, role)
        VALUES (?, ?, ?, ?, ?)
    ");

    if ($stmt->execute([$nom, $prenom, $email, $password_hash, $role])) {
        $_SESSION['message'] = "Compte créé avec succès !";
        header("Location: connexion.php");
        exit();
    } else {
        $_SESSION['erreur'] = "Erreur lors de la création du compte.";
        header("Location: creation_compte.php");
        exit();
    }
}
?>
