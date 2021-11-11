<!DOCTYPE html>
<html lang="fr">

<?php
include("includes/head.inc.php");
?>

<body>
    <?php
    include("includes/header.inc.php");
    ?>

    <main>
        <p>Votre profil a bien été <?= isset($created) ? 'créé' : 'modifié' ?></p>

        <a href="index.php?route=accueil">Retour à l'accueil</a>
    </main>

    <?php
    include("includes/footer.inc.php");
    ?>
</body>

</html>