<?php
$servername = 'localhost';
$username = 'grp_7_3';
$password = 'QxYqtVo06SqN7w';
$dbname = 'grp_7_3';
try {
   // Création de la connexion PDO
   
   $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
   // Configuration du mode d'erreur PDO sur Exception
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   echo "Connexion réussie";
} catch (PDOException $e) {
   // Gestion des erreurs
   echo "Erreur de connexion : " . $e->getMessage();
}
?>