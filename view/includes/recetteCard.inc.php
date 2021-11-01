<?php
// This file can be included when we need a small card for a cocktail
if (
    isset($recetteIndex)
    && isset($Recettes[$recetteIndex])
) {
    $recette = $Recettes[$recetteIndex];
?>
    <article class="recette-card" id="recette-card-<?= $recetteIndex ?>">
        <!--
        <?php
        if (isset($recette["score"])) echo $recette["score"]; // TODO remove this (debug)
        ?>
        -->
        <div class="recette-card-fav">
            <!-- TODO fav recette -->
            <a href="index.php">
                <!-- <i class="far fa-heart"></i> -->
                <i class="fas fa-heart"></i>
            </a>
        </div>
        <h2>
            <a href="index.php?route=detail&detail=<?= urlencode($recette["titre"]) ?>">
                <?= $recette["titre"] ?>
            </a>
        </h2>
        <?php
        // Display the image if the file name exists
        if (isset($recette["img_file_name"])) {
        ?>
            <img src="res/Photos/<?= $recette["img_file_name"] ?>" alt="<?= $recette["img_file_name"] ?>" title="<?= $recette["titre"] ?>">
        <?php
        }
        ?>
        <ul>
            <?php foreach ($recette["index"] as $value) : ?>
                <li><?= $value ?></li>
            <?php endforeach; ?>
        </ul>
    </article>
<?php
}
?>