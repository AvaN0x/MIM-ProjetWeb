<?php
require_once("res/Donnees.inc.php");
require_once("model/utils.inc.php");

abstract class SearchType
{
    const ARIANE = 0;
    const SEARCHBAR = 1;
}

$searchType = SearchType::ARIANE;

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


//#endregion search
if (isset($_GET["search"])) {
    $searchType = SearchType::SEARCHBAR;
    // TODO
}
//#endregion search


//#region fill RecettesToDisplay
$RecettesToDisplay = [];

function getRecettesFromAliment(&$recettes, &$hierarchie, &$recettesToDisplay, $alimentName)
{
    // Get all recettes from this aliment
    foreach ($recettes as $key => $recette) {
        // Using $key to remove duplicates
        if (isset($recette["index"]) && in_array($alimentName, $recette["index"]))
            $recettesToDisplay[$key] = $recette;
    }

    // get all recettes from sub categories
    if (isset($hierarchie[$alimentName]["sous-categorie"])) {
        foreach ($hierarchie[$alimentName]["sous-categorie"] as $aliment)
            getRecettesFromAliment($recettes, $hierarchie, $recettesToDisplay, $aliment);
    }
}

if ($searchType == SearchType::ARIANE) {
    getRecettesFromAliment($Recettes, $Hierarchie, $RecettesToDisplay, $actualAliment);
} elseif ($searchType == SearchType::SEARCHBAR) {
    // TODO add elements based on research
}
//#endregion fill RecettesToDisplay


//#region cocktailslist
// Reindex array
$RecettesToDisplay = array_values($RecettesToDisplay);
foreach ($RecettesToDisplay as $key => $recette) {
    // Remove all accents from the title (titre)
    // Then remove all spaces (` `) for underscores (`_`)
    $img_path = str_replace(" ", "_", removeAccents($recette["titre"])) . '.jpg';

    // If the file do not exist, then we set the default image
    if (!file_exists("res/Photos/$img_path"))
        $img_path = "cocktail.png";

    $RecettesToDisplay[$key]["img_path"] = $img_path;
}
unset($key);
unset($recette);
//#endregion cocktailslist


include_once("view/accueil.php");
