<?php
require_once("res/Donnees.inc.php");
require_once("model/utils.inc.php");

//#region aside
$ariane_has_error = false;
$get_ariane = (isset($_GET["path"]) && !empty($_GET["path"]))
    ? explode("/", $_GET["path"])
    : ["Aliment"]; // temp variable


$ariane = [];
$actualAliment = "";
$actualPath = "";

$isFirst = true; // temp variable
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
//#endregion aside

//#region cocktailslist
$RecettesToDisplay = [];
foreach ($Recettes as $recette) {
    // Remove all accents from the title (titre)
    // Then remove all spaces (` `) for underscores (`_`)
    $recette["img_path"] = str_replace(" ", "_", removeAccents($recette["titre"])) . '.jpg';

    // If the file do not exist, then we set the default image
    if (!file_exists("res/Photos/" . $recette["img_path"]))
        $recette["img_path"] = "cocktail.png";

    $RecettesToDisplay[] = $recette;
}
//#endregion cocktailslist


include_once("view/accueil.php");
