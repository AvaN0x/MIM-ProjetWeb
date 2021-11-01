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
        <?php
        if (isset($recette)) {
        ?>
            <div class="detail">
                <div class="fav">
                    <!-- TODO fav recette -->
                    <a href="#">
                        <?php
                        if (isRecipeFavorite($recetteIndex)) {
                            echo '<i class="fas fa-heart"></i>';
                        } else {
                            echo '<i class="far fa-heart"></i>';
                        }
                        ?>
                    </a>
                </div>

                <h1>
                    <?= $recette['titre'] ?>
                </h1>
                <img class="img" src="res/Photos/<?= $recette["img_file_name"] ?>" alt="<?= $recette["img_file_name"] ?>" title="<?= $recette['titre'] ?>">

                <div class="characteristics">
                    <?php
                    if (isset($recette['ingredients'])) {
                    ?>
                        <h3>Ingrédients</h3>
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
                        <h3>Préparation</h3>
                        <p><?= $recette['preparation'] ?></p>
                    <?php
                    }
                    ?>
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
    // TODO remake this page style because the footer is not at the bottom
    include("includes/footer.inc.php");
    ?>
</body>

</html>