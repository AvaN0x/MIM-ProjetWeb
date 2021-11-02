<?php
require_once("res/Donnees.inc.php");
require_once(__DIR__ . "/../model/user.inc.php");

// Set header content-type as json
header('Content-Type: application/json; charset=utf-8');

// Prepare json result variable
$jsonResult = [
    'success' => false,
    'message' => '',
    'data' => []
];

// Get ajax route from url (ajax/ajaxRoute)
$ajaxRoute = isset($route[1]) ? $route[1] : "";

switch ($ajaxRoute) {
    case 'toggle_favorite':
        // Check id from args
        if (!isset($route[2])) {
            $jsonResult['message'] = "Id not specified";
            break;
        }
        $id = $route[2];
        if (!isset($Recettes[$id])) {
            $jsonResult['message'] = "Recipe do not exist";
            break;
        }

        $added = false;
        // If user is connected
        if (
            isset($_SESSION['connected'])
            && $_SESSION['connected'] === true
        ) {
            $key = array_search($id, $_SESSION['user']['favorite_recipes']);
            // if the recipe is already in the favorite list, we remove it
            if ($key !== false) {
                unset($_SESSION['user']['favorite_recipes'][$key]);
            } else {
                // else we add it
                $_SESSION['user']['favorite_recipes'][] = $id;
                $added = true;
            }

            // save modifications to file
            editFavoriteRecipes($id);
        } else {
            // else user is not connected, then we use $_SESSION['favorite_recipes']

            // TODO use cookies ?

            // if $_SESSION['favorite_recipes'] do not exist, we init the array
            if (!isset($_SESSION['favorite_recipes']))
                $_SESSION['favorite_recipes'] = [];

            // if the recipe is already in the array, we remove it
            $key = array_search($id, $_SESSION['favorite_recipes']);
            if ($key !== false) {
                unset($_SESSION['favorite_recipes'][$key]);
            } else {
                // else we add it
                $_SESSION['favorite_recipes'][] = $id;
                $added = true;
            }
        }
        $jsonResult['success'] = true;
        $jsonResult['data'] = ["id" => $id, "added" => $added];

        break;
    default:
        $jsonResult['message'] = "Ajax route not found";
        break;
}

// Echo json content to the page
echo json_encode($jsonResult);
