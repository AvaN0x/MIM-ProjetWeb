<?php
include_once("res/Donnees.inc.php");
session_start();

// This is a comment for patriot57

$isDefAliment = (isset($_GET["aliment"]) && !empty($_GET["aliment"]));
$actualAliment = $isDefAliment ? $_GET["aliment"] : "Aliment";

// check if we don't have an actual aliment as GET, or if $_SESSION['ariane'] is not set
if (!$isDefAliment || !isset($_SESSION['ariane'])) {
    // TODO if not set, get one of the super-categorie of them to get an ariane
    $_SESSION['ariane'] = ["Aliment"];
} else {
    // get last aliment of the array
    $lastAliment = end((array_values($_SESSION['ariane'])));

    // if the actual aliment is in the ariane, then we go the position of this aliment, and we remove all aliments after it
    if (in_array($actualAliment, $_SESSION['ariane'])) {
        // get index of actual aliment (which is already in the array)
        $index = array_search($actualAliment, $_SESSION['ariane']);
        // we extract a slice of the array from the start to the position of this aliment
        $_SESSION['ariane'] = array_slice($_SESSION['ariane'], 0, $index + 1, true);
    } else if (
        // if the actual aliment exist in $Hierarchie
        array_key_exists($actualAliment, $Hierarchie)
        // and if the last aliment has "sous-categorie"
        && array_key_exists("sous-categorie", $Hierarchie[$lastAliment])
        // and if the last aliment has the actual aliment in "sous-categories
        && in_array($actualAliment, $Hierarchie[$lastAliment]["sous-categorie"])
    ) {
        // then we can add the actual aliment to the ariane
        array_push($_SESSION['ariane'], $actualAliment);
    }
}


?>

<aside>
    <h1>Aliment courant</h1>

    <?php
    $isFirstAriane = false;
    foreach ($_SESSION['ariane'] as $key => $value) {
        if (!$isFirstAriane)
            $isFirstAriane = true;
        else
            echo "/";

        echo "<a href=\"index.php?aliment=$value\">$value</a>";
    }
    ?>

    <h2>Sous-catégorie</h2>
    <ul>
        <?php
        if (array_key_exists($actualAliment, $Hierarchie) && array_key_exists("sous-categorie", $Hierarchie[$actualAliment])) {
            foreach ($Hierarchie[$actualAliment]["sous-categorie"] as $aliment) {
                echo "<li><a href=\"index.php?aliment=$aliment\">$aliment</a></li>";
            }
        }
        ?>
    </ul>
</aside>