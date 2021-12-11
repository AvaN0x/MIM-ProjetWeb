<?php
require_once(__DIR__ . "/../res/Donnees.inc.php");
require_once(__DIR__ . "/../model/recette.inc.php");
require_once(__DIR__ . "/../model/user.inc.php");

abstract class SearchType
{
    const ARIANE = 0;
    const RESEARCHBAR = 1;
}
$searchType = SearchType::ARIANE;

// Array used for research and display to the user
$researchBarResult = [];
// This array is used only for processing the research bar
// It is used to store "sous-categorie" aliments for the process, but not for the display
$_researchBarResult = [];

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
        array_key_exists(urldecode($aliment), $Hierarchie)
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
            $path = urlencode($aliment);
        } else {
            $path = $actualPath . '/' . urlencode($aliment);
        }

        // add new aliment to ariane
        $ariane[] = [
            "label" => urldecode($aliment),
            "path" => $path
        ];

        $actualPath = $path;
        $actualAliment = urldecode($aliment);
    } else {
        $ariane_has_error = true;
        break;
    }
}
unset($isFirst);
unset($get_ariane);
//#endregion aside


//#endregion research

/**
 * Get all aliments name and if they are wanted or not, this will also get sub categorie elements
 * @param hierarchie array of all aliments
 * @param allAliments array containing all aliments name in lowercase as key and with caps as value 
 * @param processAlimentsArray array to fill with wanted and unwanted aliments
 * @param alimentName aliment we are looking for
 * @param wanted boolean to know if the aliment is wanted or not
 * @return location where the aliment got stored : wanted, unwanted or unknown
 */
function getAlimentsFromAliment(&$hierarchie, &$allAliments, &$processAlimentsArray, $alimentName, $wanted)
{
    $location = "unknown";
    // if aliment exist
    if (isset($allAliments[$alimentName])) {
        // get new location depending on wanted or not 
        $location = $wanted ? "wanted" : "unwanted";

        $processAlimentsArray[$location][$alimentName] = $allAliments[$alimentName];

        // Get all aliments from sub categories
        if (isset($hierarchie[$allAliments[$alimentName]]["sous-categorie"])) {
            foreach ($hierarchie[$allAliments[$alimentName]]["sous-categorie"] as $aliment)
                getAlimentsFromAliment($hierarchie, $allAliments, $processAlimentsArray, mb_strtolower($aliment), $wanted);
        }
    }
    return $location;
}

if (isset($_GET["research"]) && !empty($_GET["research"])) {
    $searchType = SearchType::RESEARCHBAR;
    if (substr_count($_GET["research"], '"') % 2 == 1) {
        $researchBarResult["error"] = "count_of_guillemet";
    } else {
        // init arrays, each array contain the lowered string as key, and original as value
        $researchBarResult["wanted"] = [];
        $researchBarResult["unwanted"] = [];
        $researchBarResult["unknown"] = [];
        // init array for process, each array contain the lowered string as key, and original as value
        $_researchBarResult["wanted"] = [];
        $_researchBarResult["unwanted"] = [];
        // get elements from research
        $matches;
        preg_match_all('/(?<type>[+-]?)(?<aliment>"[^"]+"|[^\s]+)/', $_GET["research"], $matches);

        // All aliments in lower case, array contain lowered string as key, and original as value
        $existingAliments = [];
        foreach ($Hierarchie as $key => $value)
            $existingAliments[mb_strtolower($key)] = $key;

        // sort elements from research to an array
        foreach ($matches["aliment"] as $index => $value) {
            // format $value to a readable string
            $value = mb_strtolower(str_replace('"', '', $value));

            // get the location for the $value aliment, will add all "sous-categorie" aliments to $_researchBarResult
            $location = getAlimentsFromAliment($Hierarchie, $existingAliments, $_researchBarResult, $value, $matches["type"][$index] != "-");
            $researchBarResult[$location][$value] = $location == "unknown" ? $value : $existingAliments[$value];
        }
    }
}
//#endregion research


//#region fill RecettesToDisplay
// $RecettesToDisplay contains keys of each recipes (and score if research)
$RecettesToDisplay = [];

/**
 * Get all recettes which contains an aliment or a sub category of the aliment
 * @param recettes array of all recipes
 * @param hierarchie array of all aliments
 * @param recettesToDisplay array to fill
 * @param alimentName name of the argument
 */
function getRecettesFromAliment(&$recettes, &$hierarchie, &$recettesToDisplay, $alimentName)
{
    // Get all recettes from this aliment
    foreach ($recettes as $key => $recette) {
        // Using $key to remove duplicates
        if (isset($recette["index"]) && in_array($alimentName, $recette["index"]) && !isset($recettesToDisplay[$key])) {
            // We add the element to recettesToDisplay if it is not already in
            $recettesToDisplay[$key] = ["key" => $key];
        }
    }

    // get all recettes from sub categories
    if (isset($hierarchie[$alimentName]["sous-categorie"])) {
        foreach ($hierarchie[$alimentName]["sous-categorie"] as $aliment)
            getRecettesFromAliment($recettes, $hierarchie, $recettesToDisplay, $aliment);
    }
}

if ($searchType == SearchType::ARIANE) {
    getRecettesFromAliment($Recettes, $Hierarchie, $RecettesToDisplay, $actualAliment);

    // Sort based on title
    usort($RecettesToDisplay, function ($a, $b) use ($Recettes) {
        return $Recettes[$a["key"]]["titre"] > $Recettes[$b["key"]]["titre"];
    });
} elseif ($searchType == SearchType::RESEARCHBAR) {
    if (!isset($researchBarResult["error"])) {
        // We calculate the score of each recipes
        foreach ($Recettes as $key => $recette) {
            // Get score value
            $score = 0;
            if (isset($recette["index"])) {
                foreach ($recette["index"] as $alimentName) {
                    // Here we are using the processing array
                    if (in_array($alimentName, $_researchBarResult["wanted"]))
                        $score++;
                    if (in_array($alimentName, $_researchBarResult["unwanted"]))
                        $score--;
                }
            }

            // If score is negative or zero, then we will not display this recipe
            if ($score <= 0) {
                continue;
            }

            // Add recipe to be displayed
            $RecettesToDisplay[] = [
                "key" => $key,
                "score" => $score
            ];
        }

        // Sort based on score
        usort($RecettesToDisplay, function ($a, $b) {
            return $a["score"] < $b["score"];
        });
    }
}
//#endregion fill RecettesToDisplay


//#region set img_file_name
foreach ($RecettesToDisplay as $key => $recette) {
    // Init all img files names from needed recipes to be able to use them later
    $Recettes[$recette["key"]]["img_file_name"] = getImageFileName($Recettes[$recette["key"]]["titre"]);
}
unset($key);
unset($recette);
//#endregion set img_file_name

// Include the view
include_once("view/accueil.php");
