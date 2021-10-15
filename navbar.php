<?php
include_once("res/Donnees.inc.php");

$get_ariane = (isset($_GET["path"]) && !empty($_GET["path"]))
    ? explode("/", $_GET["path"])
    : ["Aliment"];
$ariane_has_error = false;

$ariane = [];
$actualAliment = "";
$actualPath = "";

$isFirst = true;
foreach ($get_ariane as $key => $aliment) {
    if (
        // if the actual aliment exist in $Hierarchie
        array_key_exists($aliment, $Hierarchie)
        // and the element is the first element
        && ($isFirst ||
            (
                // or if the last aliment has "sous-categorie"
                array_key_exists("sous-categorie", $Hierarchie[$actualAliment])
                // and if the last aliment has the actual aliment in "sous-categories
                && in_array($aliment, $Hierarchie[$actualAliment]["sous-categorie"])))
    ) {
        // only add a / if it is not the first element
        if ($isFirst) {
            $isFirst = false;
            $path = "$aliment";
        } else {
            $path = "$actualPath/$aliment";
        }

        // add new aliment to ariane
        $ariane[] = [
            "label" => $aliment,
            "path" => $path
        ];

        $actualPath = $path;
        $actualAliment = $aliment;
    } else {
        $ariane_has_error = true;
        break;
    }
}
unset($isFirst);
unset($get_ariane);


?>

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
                echo "<li><a href=\"index.php?path=$actualPath/$aliment\">$aliment</a></li>";
            }
        }
        ?>
    </ul>
</aside>