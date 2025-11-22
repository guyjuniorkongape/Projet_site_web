<?php
require_once 'connectbase.php';
echo "Connexion réussie ✅";
?>

<?php
session_start();
require_once 'connectbase.php'; 

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

try {
    $sql = "SELECT id_utilisateur, nom, role, mot_de_passe FROM utilisateur WHERE nom = :username";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $password === $user['mot_de_passe']) {
        
        $_SESSION['id_utilisateur'] = $user['id_utilisateur'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['role'] = $user['role'];

        // Redirection selon le rôle
        switch ($user['role']) {
            case 'admin':
                header('Location: administrateur.php');
                break;
            case 'demenageur':
                header('Location: demenageur.php');
                break;
            case 'client':
                header('Location: client.php');
                break;
            default:
                header('Location: connexion.php?erreur=role');
        }
        exit();
    } 
    else {
        header('Location: connexion.php?erreur=1');
        exit();
    }
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

?>
