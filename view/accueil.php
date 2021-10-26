<!DOCTYPE html>
<html lang="fr">

<?php
include("includes/head.inc.php");
?>

<body>
    <?php
    include("includes/header.inc.php");
    ?>
    <div id="accueil">
        <?php
        include("includes/navbar.inc.php");
        ?>
        <main>
            <?php
            if ($searchType == SearchType::ARIANE) {
            ?>
                <h1>Liste des cocktails après navigation</h1>
            <?php
            } else if ($searchType == SearchType::RESEARCHBAR) {
            ?>
                <h1>Liste des cocktails par recherche</h1>
            <?php
            }
            ?>
            <div class="cocktails-list">
                <?php
                if (isset($RecettesToDisplay) && count($RecettesToDisplay) > 0) {
                    foreach ($RecettesToDisplay as $recette)
                        include("includes/recetteCard.inc.php");
                } else {
                ?>
                    <p class="error"><i class="fas fa-exclamation-triangle"></i>Aucun résultats n'ont été trouvés.</p>
                <?php
                }
                ?>
            </div>
        </main>
    </div>
</body>

</html>