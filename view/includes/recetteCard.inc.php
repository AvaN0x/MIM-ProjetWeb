<?php
// This file can be included when we need a small card for a cocktail
if (
    isset($recette)
    && isset($recette["titre"])
    && isset($recette["img_file_name"])
    && isset($recette["index"])
) :
?>
    <article class="recette-card">
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
        <a href="index.php?route=detail&detail=<?= urlencode($recette["titre"]) ?>">
            <img src="res/Photos/<?= $recette["img_file_name"] ?>" alt="<?= $recette["img_file_name"] ?>" title="<?= $recette["titre"] ?>">
        </a>
        <ul>
            <?php foreach ($recette["index"] as $value) : ?>
                <li><?= $value ?></li>
            <?php endforeach; ?>
        </ul>
    </article>
<?php endif; ?>