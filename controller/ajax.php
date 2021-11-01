<?php
require_once("res/Donnees.inc.php");
header('Content-Type: application/json; charset=utf-8');

$jsonResult = [
    'success' => false,
    'message' => '',
    'data' => []
];

$ajaxRoute = isset($route[1]) ? $route[1] : "";

switch ($ajaxRoute) {
    case 'toggle_favorite':
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
            // if the recipe is already in the favorite list, we remove it
            if (in_array($id, $_SESSION['user']['favorite_recipes'])) {
                $key = array_search($id, $_SESSION['user']['favorite_recipes']);
                unset($_SESSION['user']['favorite_recipes'][$key]);
            } else {
                // else we add it
                $_SESSION['user']['favorite_recipes'][] = $id;
                $added = true;
            }
            // TODO save to file
        } else {
            // else user is not connected, then we use $_SESSION['favorite_recipes']

            // TODO use cookies ?

            // if $_SESSION['favorite_recipes'] do not exist, we init the array
            if (!isset($_SESSION['favorite_recipes']))
                $_SESSION['favorite_recipes'] = [];

            // if the recipe is already in the array, we remove it
            if (in_array($id, $_SESSION['favorite_recipes'])) {
                $key = array_search($id, $_SESSION['favorite_recipes']);
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

echo json_encode($jsonResult);
