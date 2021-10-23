<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">

<?php
include("view/includes/head.inc.php");
include_once('controller/verifForm.php');
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
            include_once('view/includes/form.inc.php');
        }
        else {
            print_r($_SESSION);
            include_once('view/includes/profil.inc.php');
        }
        ?>
        

        </br>
        <button><a href="index.php">Retour à la page d'accueil</a></button>
    </main>
</body>

</html>