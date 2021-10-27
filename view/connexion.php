<!DOCTYPE html>
<html lang="fr">

<?php
include("includes/head.inc.php");
?>

<body>
    <main>
        <?php
        if (!isset($_SESSION['connected'])) {
            include_once('includes/form.inc.php');
        } else {
            print_r($_SESSION);
            include_once('includes/profil.inc.php');
        }
        ?>

        <br />
        <a href="index.php">Retour à la page d'accueil</a>
    </main>
</body>

</html>