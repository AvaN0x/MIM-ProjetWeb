<?php
require_once(__DIR__ . "/../model/user.inc.php");

$errors = [];
$fields = ["login", "password"];
$toJson = [];

$postedValues = [];

if (
    $_SERVER["REQUEST_METHOD"] === "POST"
    && isset($_POST["submit"])
) {

    //-------------------------------------------------------------------//
    //-------------------------------------------------------------------//
    //                  VERIFICATION OF EACH FIELD                       //
    //-------------------------------------------------------------------//
    //-------------------------------------------------------------------//

    // Verification for `login`
    if (!isset($_POST['login']))
        $errors['login'] = 'Le login n\'a pas été fourni';
    elseif (empty($_POST['login']))
        $errors['login'] = 'Le login donné est vide';
    elseif (!preg_match('/^(?=.{3,64}$)(?:[a-z0-9]+)$/i', $_POST['login']))
        $errors['login'] = 'Le login donnée ne respecte pas les conditions';


    // Verification for `password`
    if (!isset($_POST['password']))
        $errors['password'] = 'Le mot de passe n\'a pas été fourni';
    elseif (empty($_POST['password']))
        $errors['password'] = 'Le mot de passe fourni est vide';
    elseif (!preg_match('/^.{8,}$/', $_POST['password']))
        $errors['password'] = 'Le mot de passe fourni ne respecte pas les conditions';

    // If each field is correctly filled
    if (empty($errors)) {
        $login = (isset($_POST['login']) ? strtolower(trim(htmlspecialchars($_POST['login']))) : "");
        $result = userExists($login);

        // If user's login doesn't already exist
        if ($result === false) {
            // If we are trying to connect, generate an error
            if ($action === 'connexion') {
                $errors['login'] = '';
                $errors['password'] = 'La combinaison login + mot de passe fournie n\'existe pas';
            }
        }
        // If user's login already exist
        else {
            if (password_verify($_POST["password"], $result['profil']['password'])) {
                $user = User::fromArray($result['profil']);
                logUser($user);
            } else {
                $errors['login'] = '';
                $errors['password'] = 'La combinaison login + mot de passe fournie n\'existe pas';
            }
        }
    }

    // If errors have been thrown, save the posted values
    if (!empty($errors)) {
        foreach ($fields as $value) {
            if (isset($_POST[$value]) && ($value !== "password")) {
                $postedValues[$value] = $_POST[$value];
            }
        }
    }
}
