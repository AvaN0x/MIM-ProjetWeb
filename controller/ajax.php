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
                $_SESSION['user']['favorite_recipes'][] = intval($id);
                $added = true;
            }

            // save modifications to file
            saveFavoriteRecipes();
        } else {
            // else user is not connected, then we use $_SESSION['favorite_recipes']

            // if $_SESSION['favorite_recipes'] do not exist, we init the array
            if (!isset($_SESSION['favorite_recipes']))
                $_SESSION['favorite_recipes'] = [];

            // if the recipe is already in the array, we remove it
            $key = array_search($id, $_SESSION['favorite_recipes']);
            if ($key !== false) {
                unset($_SESSION['favorite_recipes'][$key]);
            } else {
                // else we add it
                $_SESSION['favorite_recipes'][] = intval($id);
                $added = true;
            }
        }
        $jsonResult['success'] = true;
        $jsonResult['data'] = ["id" => $id, "added" => $added];

        break;
    case 'connectuser':
        require_once(__DIR__ . "/../model/user.inc.php");

        // Check if user is already connected
        if (isset($_SESSION['connected']) && $_SESSION['connected'] === true) {
            $jsonResult['message'] = "User already connected";
            break;
        }
        $jsonResult['data']['errors'] = [];

        // Verification for `login`
        if (!isset($_POST['login']))
            $jsonResult['data']['errors']['login'] = "Le login n'a pas été fourni";
        elseif (empty($_POST['login']))
            $jsonResult['data']['errors']['login'] = 'Le login donné est vide';
        elseif (!preg_match('/^(?=.{3,64}$)(?:[a-z0-9]+)$/i', $_POST['login']))
            $jsonResult['data']['errors']['login'] = 'Le login donnée ne respecte pas les conditions';


        // Verification for `password`
        if (!isset($_POST['password']))
            $jsonResult['data']['errors']['password'] = "Le mot de passe n'a pas été fourni";
        elseif (empty($_POST['password']))
            $jsonResult['data']['errors']['password'] = 'Le mot de passe fourni est vide';
        elseif (!preg_match('/^.+$/', $_POST['password']))
            $jsonResult['data']['errors']['password'] = 'Le mot de passe fourni ne respecte pas les conditions';

        // If each field is correctly filled
        if (empty($jsonResult['data']['errors'])) {
            $login = (isset($_POST['login']) ? strtolower(trim(htmlspecialchars($_POST['login']))) : "");
            $result = userExists($login);

            // User's login exist and passwords match
            if ($result !== false && password_verify($_POST["password"], $result['profil']['password'])) {
                // User can be logged, ajax success
                $user = new User($result['profil']);
                logUser($user);
                $jsonResult['success'] = true;
                unset($jsonResult['data']['errors']);
            } else {
                // User do not exist, or passwords do not match
                $jsonResult['data']['errors']['password'] = "Le mot de passe ne correspond pas";
            }
        }


        break;
    case "disconnectuser":
        // Check if user is already connected
        if (!isset($_SESSION['connected']) || $_SESSION['connected'] !== true) {
            $jsonResult['message'] = "User not connected";
            break;
        }
        $jsonResult['success'] = true;
        unset($_SESSION['connected']);
        unset($_SESSION['user']);

        break;
    default:
        $jsonResult['message'] = "Ajax route not found";
        break;
}

// Echo json content to the page
echo json_encode($jsonResult);
