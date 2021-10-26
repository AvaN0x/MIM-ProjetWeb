<?php
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


    // TODO create a model which will work with data.json
    // First get the content of the JSON File
    $jsonData = file_exists("data.json") ? json_decode(file_get_contents("data.json"), true) : [];
    if (empty($jsonData)) {
        $jsonData = [];
    }


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
        !isset($_POST['password'])
        || empty($_POST['password'])
        || !preg_match('/^.{8,}$/', $_POST['password'])
    ) {
        $errors['password'] = 'password';
    }

    if ($_POST['type'] === 'inscription') {
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
        // Verification if we are trying to get a new profil
        if ($_POST['type'] === 'inscription') {

            // Verification if the login doesn't already exists
            foreach ($jsonData as $profil) {
                if (isset($profil['login']) && strtolower($_POST['login']) === $profil['login']) {
                    $errors['login'] = 'login';
                    break;
                }
            }

            // If it doesn't already exists, save the new profil in JSON file
            // And connect him / her with his / her new account
            if (!isset($errors['login'])) {
                foreach ($fields as $value) {
                    if ($value === "password" && isset($_POST["password"])) {
                        $toJson["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
                    } else {
                        $content = (isset($_POST[$value]) ? strtolower(trim(htmlspecialchars($_POST[$value]))) : "");
                        $toJson[$value] = $content;
                    }
                }

                array_push($jsonData, $toJson);
                file_put_contents("data.json", json_encode($jsonData));

                $_SESSION['connected']['login'] = $toJson['login'];
                $_SESSION['connected']['name'] = $toJson['name'];
                $_SESSION['connected']['fname'] = $toJson['fname'];
            }
        }
        // If we are trying to connect
        else {
            // If 1 profil in JSON file match with the login and password given
            // no errors thrown and connect him / her
            $errors['login'] = 'login';
            $errors['password'] = 'password';

            $login = (isset($_POST['login']) ? strtolower(trim(htmlspecialchars($_POST['login']))) : "");

            foreach ($jsonData as $profil) {
                if (
                    isset($profil['login'])
                    && $login === $profil['login']
                    && isset($profil['password'])
                    && isset($_POST['password'])
                    && password_verify($_POST["password"], $profil['password'])
                ) {
                    unset($errors['login']);
                    unset($errors['password']);

                    $_SESSION['connected']['login'] = $profil['login'];
                    $_SESSION['connected']['name'] = $profil['name'];
                    $_SESSION['connected']['fname'] = $profil['fname'];
                    break;
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
