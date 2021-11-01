<?php
require_once(__DIR__ . "/../model/user.php");
$errors = [];
$fields = ["login", "password", "name", "fname", "gender", "email", "birthdate", "address", "postcode", "city"];
$toJson = [];

$postedValues = [];
foreach ($fields as $key => $value) {
    $postedValues[$value] = "";
}

if (
    $_SERVER["REQUEST_METHOD"] === "POST"
    && isset($_POST["submit"])
) {

    ///////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////
    //                  VERIFICATION OF EACH FIELD                       //
    ///////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////

    // Verification for `login`
    if (
        !isset($_POST['login'])
        || empty($_POST['login'])
        || !preg_match('/^(?=.{3,64}$)(?:[a-z0-9]+)$/i', $_POST['login'])
    ) {
        $errors['login'] = 'login';
    }

    // Verification for `password`
    if (
        // if first field respect all exepctations
        !isset($_POST['password'])
        || empty($_POST['password'])
        || !preg_match('/^.{8,}$/', $_POST['password'])

        // If we want an inscription and the field `confirmPassword` doesn't respect all expectations
        || ($action === 'inscription'
            && (!isset($_POST['confirmPassword'])
                || empty($_POST['confirmPassword'])
                || $_POST['password'] !== $_POST['confirmPassword']))
    ) {
        $errors['password'] = 'password';
    }

    if ($action === 'inscription') {
        // Verification for `name`
        if (
            isset($_POST['name'])
            && !empty($_POST['name'])
            && !preg_match('/^(?=.{0,64}$)(?:[a-zØ-öø-ÿ](?:-?[[:blank:]]?[a-zØ-öø-ÿ])*)$/i', $_POST['name'])
        ) {
            $errors['name'] = 'name';
        }

        // Verification for `fname`
        if (
            isset($_POST['fname'])
            && !empty($_POST['fname'])
            && !preg_match('/^(?=.{0,64}$)(?:[a-zØ-öø-ÿ](?:-?[[:blank:]]?[a-zØ-öø-ÿ])*)$/i', $_POST['fname'])
        ) {
            $errors['fname'] = 'fname';
        }

        // Verification for `gender`
        if (
            isset($_POST['gender'])
            && !empty($_POST['gender'])
            && !preg_match('/^[hf]$/', $_POST['gender'])
        ) {
            $errors['gender'] = 'gender';
        }

        // Verification for `email`
        if (
            isset($_POST['email'])
            && !empty($_POST['email'])
            && !preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD', $_POST['email'])
        ) {
            $errors['email'] = 'email';
        }


        // Verification for `birthdate`
        if (
            isset($_POST['birthdate'])
            && !empty($_POST['birthdate'])
            && (!preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", trim($_POST['birthdate']), $matches)
                || !checkdate($matches[2], $matches[3], $matches[1]))
        ) {
            // TODO @AvaN0x support of dd/mm/yyyy
            $errors['birthdate'] = 'birthdate';
        }

        // Verification for `address`
        if (
            isset($_POST['address'])
            && !empty($_POST['address'])
            && !preg_match('/^(?=.{0,64}$)(?:.{6,})$/i', $_POST['address'])
        ) {
            $errors['address'] = 'address';
        }

        // Verification for `postcode`
        if (
            isset($_POST['postcode'])
            && !empty($_POST['postcode'])
            && !preg_match('/^[0-9]{5}$/', $_POST['postcode'])
        ) {
            $errors['postcode'] = 'postcode';
        }

        // Verification for `city`
        if (
            isset($_POST['city'])
            && !empty($_POST['city'])
            && !preg_match('/^(?=.{0,64}$)(?:[a-zØ-öø-ÿ](?:-?[[:blank:]]?[a-zØ-öø-ÿ])*)$/i', $_POST['city'])
        ) {
            $errors['city'] = 'city';
        }
    }

    // If each field is correctly filled
    if (empty($errors)) {

        $login = (isset($_POST['login']) ? strtolower(trim(htmlspecialchars($_POST['login']))) : "");
        $result = userExists($login);

        // If user's login doesn't already exist
        if ($result === false) {
            // If we are trying to connect, generate an error
            if ($action === 'connexion') {
                $errors['login'] = 'login';
                $errors['password'] = 'password';
            } else {
                // If we are trying to save a new user, save the new values
                foreach ($fields as $value) {
                    if ($value === "password") {
                        $toJson["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
                    } else {
                        $content = (isset($_POST[$value]) ? strtolower(trim(htmlspecialchars($_POST[$value]))) : "");
                        $toJson[$value] = $content;
                    }
                }

                // addUser will log the user at the same time
                addUser($toJson);
            }
        }
        // If user's login already exist
        else {
            // If we are trying to save a new user, generate an error
            if ($action === 'inscription') {
                $errors['login'] = 'login';
            } else {
                if (password_verify($_POST["password"], $result['profil']['password'])) {
                    logUser($result['profil']);
                } else {
                    $errors['login'] = 'login';
                    $errors['password'] = 'password';
                }
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

include_once("view/connexion.php");
