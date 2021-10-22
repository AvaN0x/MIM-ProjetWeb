<?php
require_once("config.inc.php");


session_start();
// TODO @AvaN0x check this
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['type']) && $_POST['type'] === 'deconnexion')
    if (isset($_SESSION['connected'])) unset($_SESSION['connected']);

// echo $_SERVER["QUERY_STRING"];
$route = isset($_GET["route"]) ? explode("/", $_GET["route"]) : [];
// print_r($route);
$action = isset($route[0]) ? $route[0] : LANDING_PAGE_NAME;

switch ($action) {
    case 'accueil':
    case 'list':
        $pageTitle = "Recktails"; // TODO find a name
        include_once("controller/accueil.php");
        break;

    case '404':
    default:
        $pageTitle = "Erreur 404";
        include_once("view/404.php");
        break;
}
