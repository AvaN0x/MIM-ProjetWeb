<?php
require_once("config.inc.php");


session_start();

// echo $_SERVER["QUERY_STRING"];
$route = isset($_GET["route"]) ? explode("/", $_GET["route"]) : [];
// print_r($route);
$action = isset($route[0]) ? $route[0] : LANDING_PAGE_NAME;


//#region deconnexion
if ($action == "deconnexion") {
    if (isset($_SESSION['connected'])) {
        unset($_SESSION['connected']);
        unset($_SESSION['user']);
    }
}
//#endregion deconnexion


$pageTitle = "Recktails";
switch ($action) {
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
