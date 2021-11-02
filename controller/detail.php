<?php
require_once("res/Donnees.inc.php");
require_once("model/recette.inc.php");
require_once("model/user.inc.php");

// Get data about the recipe specified
$recette;
$recetteIndex;
if (isset($_GET["detail"])) {
    foreach ($Recettes as $key => $value) {
        if ($value["titre"] === $_GET["detail"]) {
            $recetteIndex = $key;
            $recette = $value;
            break;
        }
    }
}

// If no recipe were found, then we unset vars
if (!isset($recette) || empty($recette)) {
    unset($recetteIndex);
    unset($recette);
} else {
    // Else, we get the needed file name
    $recette["img_file_name"] = getImageFileName($recette["titre"]);
}

// Include the view
include_once("view/detail.php");
