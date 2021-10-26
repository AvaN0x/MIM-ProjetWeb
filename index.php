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
    }
}
//#endregion deconnexion


$pageTitle = "Recktails"; // TODO find a name
switch ($action) {
    case 'accueil':
    case 'list':
        include_once("controller/accueil.php");
        break;

    case 'connexion':
    case 'inscription':
    case 'deconnexion':
    case 'editProfil':
    case 'profil':
        include_once("controller/connexion.php");
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
