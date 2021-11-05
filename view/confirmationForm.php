<!DOCTYPE html>
<html lang="fr">

<?php
include(__DIR__ . "/includes/head.inc.php");
?>

<body>
    <p>Votre profil a bien été <?= isset($created) ? 'créé' : 'modifié' ?></p>

    <a href="index.php?route=accueil">Retour à l'accueil</a>

    <?php
    include(__DIR__ . "/includes/footer.inc.php");
    ?>
</body>

</html>