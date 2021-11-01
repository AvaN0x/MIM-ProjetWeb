<?php
require_once("res/Donnees.inc.php");
require_once("model/recette.inc.php");
require_once("model/user.inc.php");

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

if (!isset($recette) || empty($recette)) {
    unset($recetteIndex);
    unset($recette);
} else {
    $recette["img_file_name"] = getImageFileName($recette["titre"]);
}

include_once("view/detail.php");
