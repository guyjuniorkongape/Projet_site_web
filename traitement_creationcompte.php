<?php
session_start();
require_once "connectbase.php";

// Vérification que tous les champs existent
if (
    !isset($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['role'], $_POST['password'], $_POST['confirm'])
) {
    $_SESSION['erreur'] = "Tous les champs doivent être remplis.";
    header("Location: creationcompte.php");
    exit();
}

$nom = trim($_POST['nom']);
$prenom = trim($_POST['prenom']);
$email = trim($_POST['email']);
$role = trim($_POST['role']);
$password = $_POST['password'];
$confirm = $_POST['confirm'];

// Vérification du mot de passe
if ($password !== $confirm) {
    $_SESSION['erreur'] = "❌ Les mots de passe ne correspondent pas.";
    header("Location: creationcompte.php");
    exit();
}

// Vérifier si l'e-mail existe déjà
$sql = "SELECT id_utilisateur FROM utilisateur WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$email]);

if ($stmt->rowCount() > 0) {
    $_SESSION['erreur'] = "⚠️ Cet e-mail existe déjà.";
    header("Location: creationcompte.php");
    exit();
}

// Hash du mot de passe
$hashed = password_hash($password, PASSWORD_DEFAULT);

// Insertion en base
$sql_insert = "
    INSERT INTO utilisateur (nom, prenom, email, role, motdepasse)
    VALUES (?, ?, ?, ?, ?)
";

$stmt = $conn->prepare($sql_insert);
$success = $stmt->execute([$nom, $prenom, $email, $role, $hashed]);

if ($success) {
    $_SESSION['message'] = "✅ Compte créé avec succès ! Vous pouvez vous connecter.";
    header("Location: connexion.php");
    exit();
} else {
    $_SESSION['erreur'] = "❌ Une erreur est survenue lors de la création du compte.";
    header("Location: creationcompte.php");
    exit();
}
?>
