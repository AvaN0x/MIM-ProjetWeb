<!DOCTYPE html>
<html lang="fr">

<?php
include(__DIR__ . "/includes/head.inc.php");
?>

<body>
    <!-- Include js file specific to this page -->
    <script language="javascript" type="text/javascript" src="js/accueil.js"></script>

    <?php
    include(__DIR__ . "/includes/header.inc.php");
    ?>

    <div id="accueil">
        <aside>
            <h2>Aliment courant</h2>
            <?php if ($ariane_has_error) : ?>
                <p class="error"><i class="fas fa-exclamation-triangle"></i>Une erreur est survenue lors de la lecture du fil d'ariane demandé.</p>
            <?php endif; ?>

            <p class="aside-ariane">
                <?php
                foreach ($ariane as $key => $value) {
                    echo '<span><a href="index.php?path=' . $value["path"] . '">' . $value["label"] . '</a></span>';
                }
                ?>
            </p>

            <h2>Sous-catégorie</h2>
            <ul>
                <?php
                if (array_key_exists($actualAliment, $Hierarchie) && array_key_exists("sous-categorie", $Hierarchie[$actualAliment])) {
                    foreach ($Hierarchie[$actualAliment]["sous-categorie"] as $aliment) {
                        echo '<li><a href="index.php?route=' . LANDING_PAGE_NAME . '&path=' . $actualPath . '/' . urlencode($aliment) . '">' . $aliment . '</a></li>';
                    }
                }
                ?>
            </ul>
        </aside>
        <main>
            <?php
            if ($searchType == SearchType::ARIANE) {
            ?>
                <h1>Liste des cocktails après navigation</h1>
                <div class="cocktails-list">
                    <?php
                    if (isset($RecettesToDisplay) && count($RecettesToDisplay) > 0) {
                        foreach ($RecettesToDisplay as $key => $value) {
                            $recetteIndex = $value["key"];
                            include(__DIR__ . "/includes/recetteCard.inc.php");
                        }
                    } else {
                    ?>
                        <p class="error"><i class="fas fa-exclamation-triangle"></i>Aucun résultat n'a été trouvé.</p>
                    <?php
                    }
                    ?>
                </div>
            <?php
            } else if ($searchType == SearchType::RESEARCHBAR) {
            ?>
                <h1>Liste des cocktails par recherche</h1>
                <div class="researchbar-details">

                    <?php
                    if (isset($researchBarResult["error"])) {
                        if ($researchBarResult["error"] == "count_of_guillemet") {
                    ?>
                            <p class="error"><i class="fas fa-exclamation-triangle"></i>Problème de syntaxe dans votre requête : nombre impair de double-quotes.</p>
                        <?php
                        }
                    } else {
                        if (count($researchBarResult["wanted"]) > 0) {
                        ?>
                            <p>Liste des aliments souhaités : <?= implode(", ", $researchBarResult["wanted"]) ?></p>
                        <?php
                        }
                        if (count($researchBarResult["unwanted"]) > 0) {
                        ?>
                            <p>Liste des aliments non souhaités : <?= implode(", ", $researchBarResult["unwanted"]) ?></p>
                        <?php
                        }
                        if (count($researchBarResult["unknown"]) > 0) {
                        ?>
                            <p>Eléments non reconnus dans la requête : <?= implode(", ", $researchBarResult["unknown"]) ?></p>
                    <?php
                        }
                    }
                    ?>
                </div>
                <div class="cocktails-list">
                    <?php
                    if (isset($RecettesToDisplay) && count($RecettesToDisplay) > 0) {
                        foreach ($RecettesToDisplay as $key => $value) {
                            $recetteIndex = $value["key"];
                            include(__DIR__ . "/includes/recetteCard.inc.php");
                        }
                    } else {
                    ?>
                        <p class="error"><i class="fas fa-exclamation-triangle"></i>Problème dans votre requête : recherche impossible.</p>
                    <?php
                    }
                    ?>
                </div>
            <?php
            }
            ?>
        </main>
    </div>

    <?php
    include(__DIR__ . "/includes/footer.inc.php");
    ?>
</body>

</html>