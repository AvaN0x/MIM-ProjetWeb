<!-- FIXME this file may not be needed ? need more informations from the teacher -->
<aside>
    <h1>Aliment courant</h1>
    <?php if ($ariane_has_error) : ?>
        <p class="error"><i class="fas fa-exclamation-triangle"></i>Une erreur est survenue lors de la lecture du fil d'ariane demandé.</p>
    <?php endif; ?>

    <?php
    $isFirstAriane = true;
    foreach ($ariane as $key => $value) {
        if ($isFirstAriane)
            $isFirstAriane = false;
        else
            echo "/";

        echo '<a href="index.php?path=' . $value["path"] . '">' . $value["label"] . '</a>';
    }
    ?>

    <h2>Sous-catégorie</h2>
    <ul>
        <?php
        if (array_key_exists($actualAliment, $Hierarchie) && array_key_exists("sous-categorie", $Hierarchie[$actualAliment])) {
            foreach ($Hierarchie[$actualAliment]["sous-categorie"] as $aliment) {
                echo "<li><a href=\"index.php?route=" . LANDING_PAGE_NAME . "&path=$actualPath/$aliment\">$aliment</a></li>";
            }
        }
        ?>
    </ul>
</aside>