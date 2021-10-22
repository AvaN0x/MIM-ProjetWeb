<?php
// This file can be included when we need a small card for a cocktail
if (
    isset($recette)
    && isset($recette["titre"])
    && isset($recette["img_path"])
    && isset($recette["index"])
) :
?>
    <article class="recette-card">
        <div>
            <i class="fas fa-heart"></i>
            <i class="far fa-heart"></i>
        </div>
        <h2><?= $recette["titre"] ?></h2>
        <img src="res/Photos/<?= $recette["img_path"] ?>" alt="<?= $recette["img_path"] ?>" title="<?= $recette["titre"] ?>">
        <ul>
            <?php foreach ($recette["index"] as $value) : ?>
                <li><?= $value ?></li>
            <?php endforeach; ?>
        </ul>
    </article>
<?php endif; ?>