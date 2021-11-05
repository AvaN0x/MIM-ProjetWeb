<?php
require_once(__DIR__ . "/../model/user.inc.php");

$errors = [];
$fields = ["login", "password", "name", "fname", "gender", "email", "birthdate", "address", "postcode", "city", "phone"];
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


    // Verification for `confirmPassword`
    if (!isset($_POST['confirmPassword']))
        $errors['password'] = 'La confirmation de mot de passe n\'a pas été fournie';
    elseif (empty($_POST['confirmPassword']))
        $errors['password'] = 'La confirmation de mot de passe fournie est vide';
    elseif ($_POST['password'] !== $_POST['confirmPassword'])
        $errors['password'] = 'La confirmation et le mot de passe ne correspondent pas';


    // Verification for `name`
    if (
        isset($_POST['name'])
        && strlen($_POST['name'])
        && !preg_match('/^(?=.{0,64}$)(?:[a-zØ-öø-ÿ](?:-?[[:blank:]]?[a-zØ-öø-ÿ])*)$/i', $_POST['name'])
    ) {
        $errors['name'] = 'Le nom fourni ne respecte pas les conditions';
    }


    // Verification for `fname`
    if (
        isset($_POST['fname'])
        && strlen($_POST['fname'])
        && !preg_match('/^(?=.{0,64}$)(?:[a-zØ-öø-ÿ](?:-?[[:blank:]]?[a-zØ-öø-ÿ])*)$/i', $_POST['fname'])
    ) {
        $errors['fname'] = 'Le prénom fourni ne respecte pas les conditions';
    }


    // Verification for `gender`
    if (
        isset($_POST['gender'])
        && strlen($_POST['gender'])
        && !preg_match('/^[hf]$/', $_POST['gender'])
    ) {
        $errors['gender'] = 'Le sexe fourni ne respecte pas les conditions';
    }


    // Verification for `email`
    if (
        isset($_POST['email'])
        && strlen($_POST['email'])
        && !preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD', $_POST['email'])
    ) {
        $errors['email'] = 'Le mail fourni ne respecte pas les conditions';
    }


    // Verification for `birthdate`
    if (
        isset($_POST['birthdate'])
        && strlen($_POST['birthdate'])
        && (!preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $_POST['birthdate'], $matches)
            || !checkdate($matches[2], $matches[3], $matches[1]))
    ) {
        // TODO @AvaN0x support of dd/mm/yyyy
        $errors['birthdate'] = 'La date de naissance fournie ne respecte pas les conditions';
    }


    // Verification for `address`
    if (
        isset($_POST['address'])
        && strlen($_POST['address'])
        && !preg_match('/^(?=.{0,64}$)(?:.{6,})$/i', $_POST['address'])
    ) {
        $errors['address'] = 'L\'adresse fournis ne respecte pas les conditions';
    }


    // Verification for `postcode`
    if (
        isset($_POST['postcode'])
        && strlen($_POST['postcode'])
        && !preg_match('/^[0-9]{5}$/', $_POST['postcode'])
    ) {
        $errors['postcode'] = 'Le code postal fourni ne respecte pas les conditions';
    }


    // Verification for `city`
    if (
        isset($_POST['city'])
        && strlen($_POST['city'])
        && !preg_match('/^(?=.{0,64}$)(?:[a-zØ-öø-ÿ](?:-?[[:blank:]]?[a-zØ-öø-ÿ])*)$/i', $_POST['city'])
    ) {
        $errors['city'] = 'La ville fournie ne respecte pas les conditions';
    }


    // Verification for `phone`
    if (
        isset($_POST['phone'])
        && strlen($_POST['phone'])
        && !preg_match('/^(?:\+33\s|0)[1-9](?:\s?\d\d){4}$/', $_POST['phone'])
    ) {
        $errors['phone'] = 'Le numéro de téléphone fourni ne respecte pas les conditions';
    }


    // If each field is correctly filled
    if (empty($errors)) {
        $login = (isset($_POST['login']) ? strtolower(trim(htmlspecialchars($_POST['login']))) : "");
        $result = userExists($login);

        // If user's login doesn't already exist
        if ($result === false) {
            $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $user = User::fromArray($_POST);

            // addUser will log the user at the same time
            addUser($user);
        }
        // If user's login already exist
        else {
            // If we are trying to save a new user, generate an error
            $errors['login'] = 'Le login fourni existe déjà';
        }

        $created = 'created';
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


if (!isset($created)) {
    // Include the view
    include_once(__DIR__ . "/../view/inscriptionForm.php");
} else {
    // Include the view
    include_once(__DIR__ . "/../view/confirmationForm.php");
    unset($created);
}
