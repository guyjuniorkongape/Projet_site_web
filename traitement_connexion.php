<?php
  $titre = "Connexion";

  include('header.inc.php');
  
?>
<h2>Connexion</h2>
        <?php
                $message = '';
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $username = $_POST['username'] ?? '';
                    $password = $_POST['password'] ?? '';

                    $valid_username = 'admin';
                    $valid_password = '1234';

                    if ($username === $valid_username && $password === $valid_password) {
                        $message = '<div class="alert alert-success">Connexion réussie !</div>';
                    } else {
                        $message = '<div class="alert alert-danger">Nom d\'utilisateur ou mot de passe incorrect.</div>';
                    }
                }
            ?>
                

            <?php if ($message) echo $message; ?>
<?php
  include('footer.inc.php');
?>