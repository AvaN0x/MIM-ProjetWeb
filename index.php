<?php
require_once("config.inc.php");

// Start session for each and every pages
session_start();

// Set timezone for dates
date_default_timezone_set("Europe/Paris");

// Get route from get and explode it
$route = isset($_GET["route"]) ? explode("/", $_GET["route"]) : [];

// The first action from the route
$action = isset($route[0]) ? $route[0] : LANDING_PAGE_NAME;


// Set page title to default value
$pageTitle = "Recktails";


// If user is not connected, change action when needed
if (!isset($_SESSION['connected']) || $_SESSION['connected'] !== true) {
    switch ($action) {
        case 'editProfil':
            $action = LANDING_PAGE_NAME;
            break;
    }
} else {
    // If user is connected, change action when needed
    switch ($action) {
        case 'inscription':
            $action = LANDING_PAGE_NAME;
            break;
    }
}

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

    case 'inscription':
        include_once("controller/inscription.php");
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
