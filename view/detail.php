<!DOCTYPE html>
<html lang="fr">

<?php
include("includes/head.inc.php");
?>

<body>
    <script language="javascript" type="text/javascript" src="js/detail.js"></script>

    <?php
    include("includes/header.inc.php");
    ?>
    <main>
        <?php
        if (isset($recette)) {
        ?>
            <div class="recette-detail">
                <div class="recette-detail-header">
                    <h1>
                        <a href="#" onclick="toggleFavRecette(<?= $recetteIndex ?>);" class="fav">
                            <?php
                            if (isRecipeFavorite($recetteIndex)) {
                            ?>
                                <i class="fas fa-heart" title="Ajouter aux recettes favorites"></i>
                            <?php
                            } else {
                            ?>
                                <i class="far fa-heart" title="Enlever des recettes favorites"></i>
                            <?php
                            }
                            ?>
                        </a><?= $recette['titre'] ?>
                    </h1>
                </div>
                <div class="recette-detail-container">
                    <div class="recette-detail-image">
                        <img src="res/Photos/<?= $recette["img_file_name"] ?>" alt="<?= $recette["img_file_name"] ?>" title="<?= $recette['titre'] ?>">
                    </div>

                    <div class="recette-detail-content">
                        <div class="recette-detail-ingredients">
                            <?php
                            if (isset($recette['ingredients'])) {
                            ?>
                                <h2>Ingrédients</h2>
                                <ul>
                                    <?php
                                    foreach (explode('|', $recette['ingredients']) as $ingredient) {
                                    ?>
                                        <li><?= $ingredient ?></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            <?php
                            }
                            ?>

                            <?php if (isset($recette['preparation'])) { ?>
                                <h2>Préparation</h2>
                                <p><?= $recette['preparation'] ?></p>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        } else {
        ?>
            <p class="error"><i class="fas fa-exclamation-triangle"></i>La recette spécifiée n'existe pas.</p>
        <?php
        }
        ?>
    </main>

    <?php
    include("includes/footer.inc.php");
    ?>
</body>

</html>