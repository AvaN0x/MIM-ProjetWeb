<!DOCTYPE html>
<html lang="fr">

<?php
include("includes/head.inc.php");
?>

<body>
    <main>
        <?php
        if (isset($errors['deletedProfil'])) {
            echo "<p class='error-field'>Une erreur est survenu : votre profil a été supprimé</p>";
        } else {
            if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"]) && count($errors) === 0) {
                include_once('includes/profil.inc.php');
            } else {
                include_once('includes/editForm.inc.php');
            }
        }
        ?>

        <br />
        <a href="index.php">Retour à la page d'accueil</a>
    </main>
</body>

</html>