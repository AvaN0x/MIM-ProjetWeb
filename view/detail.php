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
            // TODO better display
        ?>
            <pre>
                <?php
                print_r($recette);
                ?>
            </pre>
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