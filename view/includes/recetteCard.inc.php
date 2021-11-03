<?php
// This file can be included when we need a small card for a cocktail
if (
    isset($recetteIndex)
    && isset($Recettes[$recetteIndex])
) {
    $recette = $Recettes[$recetteIndex];
?>
    <article class="recette-card" id="recette-card-<?= $recetteIndex ?>">
        <div>
            <div class="recette-card-fav">
                <a onclick="toggleFavRecette(<?= $recetteIndex ?>);">
                    <?php
                    if (isRecipeFavorite($recetteIndex)) {
                        echo '<i class="fas fa-heart"></i>';
                    } else {
                        echo '<i class="far fa-heart"></i>';
                    }
                    ?>
                </a>
            </div>
            <h2>
                <a href="index.php?route=detail&detail=<?= urlencode($recette["titre"]) ?>" target="_blank">
                    <?= $recette["titre"] ?>
                </a>
            </h2>
        </div>

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