<!-- FIXME this file may not be needed ? need more informations from the teacher -->

<main>
    <h1>Liste des cocktails après navigation</h1>
    <!-- <h1>Liste des cocktails par recherche</h1> -->
    <div class="cocktails-list">
        <?php
        if (isset($RecettesToDisplay)) :
            foreach ($RecettesToDisplay as $recette) :
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
        <?php
            endforeach;
        endif;
        ?>
    </div>
</main>