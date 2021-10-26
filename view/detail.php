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
        if (isset($recette)) :
        ?>
            <h1>Recette trouvée</h1> <!-- TODO remove this line -->
            <pre>
                <?php
                print_r($recette);
                ?>
            </pre>
        <?php
        else :
        ?>
            <h1>La recette spécifiée n'existe pas.</h1>
        <?php
        endif;
        ?>
    </main>
</body>

</html>