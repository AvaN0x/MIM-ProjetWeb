<?php
require_once("config.inc.php");

// Start session for each and every pages
session_start();

// Get route from get and explode it
$route = isset($_GET["route"]) ? explode("/", $_GET["route"]) : [];

// The first action from the route
$action = isset($route[0]) ? $route[0] : LANDING_PAGE_NAME;


// Set page title to default value
$pageTitle = "Recktails";

// Switch case to include the right controller
// Each controller will take care of the view
switch ($action) {
    case 'ajax':
        include_once("controller/ajax.php");
        break;

    case 'accueil':
    case 'list':
        include_once("controller/accueil.php");
        break;

    case 'favorite':
        include_once("controller/favorite.php");
        break;

    case 'connexion':
    case 'inscription':
    case 'deconnexion':
    case 'profil':
        include_once("controller/connexion.php");
        break;

    case 'editProfil':
        include_once("controller/edition.php");
        break;

    case 'detail':
        include_once("controller/detail.php");
        break;

    case '404':
    default:
        $pageTitle = "Erreur 404";
        include_once("view/404.php");
        break;
}
