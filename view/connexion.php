<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">

<?php
include("includes/head.inc.php");
include_once('../controller/connexion.php');
?>

<body>
    <style>
        .errorField {
            background-color: #F44336;
        }
    </style>
    <main>
        <?php
        if(!isset($_SESSION['connected'])) {
            include_once('includes/form.inc.php');
        }
        else {
            print_r($_SESSION);
            include_once('includes/profil.inc.php');
        }
        ?>
        

        </br>
        <button><a href="../index.php">Retour à la page d'accueil</a></button>
    </main>
</body>

</html>