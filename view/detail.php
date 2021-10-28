<!DOCTYPE html>
<html lang="fr">

<?php
require_once("model/utils.inc.php");
include("includes/head.inc.php");
?>

<body>
    <?php
    include("includes/header.inc.php");
    ?>
    <main>
        <?php
        if (isset($recette)) :
            // TODO better display
            $titre = $recette['titre'];
            $ingredients = $recette['ingredients'];
            $ingredients = explode('|', $ingredients);
            $preparation = $recette['preparation'];

            $img_path = str_replace(" ", "_", removeAccents($recette["titre"])) . '.jpg';
            if (!file_exists("res/Photos/$img_path")){
                $img_path = "cocktail.png";
            }
        ?>
            <article  class="detail">

                <div class="fav">
                <!-- TODO fav recette -->
                    <a href="#">
                    <!-- <i class="far fa-heart"></i> -->
                    <i class="fas fa-heart"></i>
                    </a>
                </div>
                
                <h1><?= $titre ?></h1>
                
                <img class="img" src="res/Photos/<?= $img_path ?>" alt="<?= $img_path ?>" title="<?= $titre ?>"> 
                
                <div class="characteristics">
                    <h3>Ingrédients</h3>
                    <ul>
                    <?php
                    foreach ($ingredients as $value) {
                        echo "<li>$value</li>\n";
                    }
                    ?>
                    </ul>

                    <h3>Préparation</h3>
                    <p><?= $preparation ?></p>
                 
                </div>
                
                
            </article>

        <?php
        else :
        ?>
            <p class="error"><i class="fas fa-exclamation-triangle"></i>La recette spécifiée n'existe pas.</p>
        <?php
        endif;
        ?>
    </main>
</body>

</html>