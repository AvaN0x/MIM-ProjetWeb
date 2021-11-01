<!DOCTYPE html>
<html lang="fr">

<?php
include("includes/head.inc.php");
?>

<body>
    <script language="javascript" type="text/javascript" src="js/favorite.js"></script>

    <?php
    include("includes/header.inc.php");
    ?>

    <main id="favorite">
        <h1>Liste de vos recettes favorites</h1>
        <div class="cocktails-list">
            <?php
            if (isset($RecettesToDisplay) && count($RecettesToDisplay) > 0) {
                foreach ($RecettesToDisplay as $key => $value) {
                    $recetteIndex = $value["key"];
                    include("includes/recetteCard.inc.php");
                }
            } else if (isset($_SESSION['connected'])) {
            ?>
                <p>Vous n'avez aucune recettes favorites.</p>
            <?php
            } else {
            ?>
                <p>Vous devez être connecté pour voir vos recettes favorites.<br />Vous pouvez commencer à mettre certaines recettes en favoris, elles seront associées à votre compte lors de votre connexion.</p>
            <?php
            }
            ?>
        </div>
    </main>

    <?php
    include("includes/footer.inc.php");
    ?>
</body>

</html>