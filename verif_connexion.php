<?php
session_start();
require_once 'connectbase.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// On utilise l'email pour se connecter
$sql = "SELECT id_utilisateur, nom, role, mot_de_passe 
        FROM utilisateur 
        WHERE email = :email";

$stmt = $conn->prepare($sql);
$stmt->execute(['email' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['mot_de_passe'])) {

    $_SESSION['id_utilisateur'] = $user['id_utilisateur'];
    $_SESSION['nom'] = $user['nom'];
    $_SESSION['role'] = $user['role'];

    // Redirection selon le rôle
    if ($user['role'] === 'admin') {
        header('Location: administrateur.php');
    } elseif ($user['role'] === 'demenageur') {
        header('Location: demenageur.php');
    } else {
        header('Location: client.php');
    }
    exit();

} else {
    // Si email ou mot de passe incorrect
    header('Location: connexion.php?erreur=1');
    exit();
}
?>
