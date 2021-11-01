<?php
require_once("res/Donnees.inc.php");
require_once("model/recette.inc.php");
require_once("model/user.inc.php");


//#region fill RecettesToDisplay
// $RecettesToDisplay contains keys of each recipes (and score if research)
$RecettesToDisplay = [];

$list;
if ((isset($_SESSION['connected']) && isset($_SESSION['user']) && isset($_SESSION['user']['favorite_recipes']))) {
    $list = $_SESSION['user']['favorite_recipes'];
} else if (isset($_SESSION['favorite_recipes'])) {
    $list = $_SESSION['favorite_recipes'];
} else {
    $list = [];
}

if (count($list) > 0) {
    // Get all recipes from favorite
    foreach ($list as $id) {
        if (isset($Recettes[$id])) {
            // We add the element to recettesToDisplay
            $RecettesToDisplay[] = ["key" => $id];
        }
    }
}
unset($list);

// Sort based on title
usort($RecettesToDisplay, function ($a, $b) use ($Recettes) {
    return $Recettes[$a["key"]]["titre"] > $Recettes[$b["key"]]["titre"];
});
//#endregion fill RecettesToDisplay

//#region set img_file_name
foreach ($RecettesToDisplay as $key => $recette) {
    // Init all img files names from needed recipes to be able to use them later
    $Recettes[$recette["key"]]["img_file_name"] = getImageFileName($Recettes[$recette["key"]]["titre"]);
}
unset($key);
unset($recette);
//#endregion set img_file_name

include_once("view/favorite.php");
