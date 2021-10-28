<?php
require_once("res/Donnees.inc.php");
require_once("model/recette.inc.php");

$recette;
if (isset($_GET["detail"])) {
    foreach ($Recettes as $value) {
        if ($value["titre"] === $_GET["detail"]) {
            $recette = $value;
            break;
        }
    }
}

if (!isset($recette) || empty($recette)) {
    unset($recette);
} else {
    $recette["img_file_name"] = getImageFileName($recette["titre"]);
}

include_once("view/detail.php");
