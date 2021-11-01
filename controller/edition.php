<?php

require_once(__DIR__ . "/../model/user.inc.php");

$errors = [];

if (($result = userExists($_SESSION['user']['login'])) === false) {
    $errors['deletedProfil'] = 'deletedProfil';
} else {
    $fields = ["name", "fname", "gender", "email", "birthdate", "address", "postcode", "city"];
    $toJson = [];

    $postedValues = [];
    foreach ($fields as $key => $value) {
        $postedValues[$value] = "";
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
        //-------------------------------------------------------------------//
        //-------------------------------------------------------------------//
        //                  VERIFICATION OF EACH FIELD                       //
        //-------------------------------------------------------------------//
        //-------------------------------------------------------------------//

        // Verification for `name`
        if (
            isset($_POST['name'])
            && (empty($_POST['name'])
                || !preg_match('/^(?=.{0,64}$)(?:[a-zØ-öø-ÿ](?:-?[[:blank:]]?[a-zØ-öø-ÿ])*)$/i', $_POST['name']))
        ) {
            $errors['name'] = 'Le nom fourni ne respecte pas les conditions';
        }

        // Verification for `fname`
        if (
            isset($_POST['fname'])
            && (empty($_POST['fname'])
                || !preg_match('/^(?=.{0,64}$)(?:[a-zØ-öø-ÿ](?:-?[[:blank:]]?[a-zØ-öø-ÿ])*)$/i', $_POST['fname']))
        ) {
            $errors['fname'] = 'Le prénom fourni ne respecte pas les conditions';
        }

        // Verification for `gender`
        if (
            isset($_POST['gender'])
            && (empty($_POST['gender'])
                || !preg_match('/^[hf]$/', $_POST['gender']))
        ) {
            $errors['gender'] = 'Le sexe fourni ne respecte pas les conditions';
        }

        // Verification for `email`
        if (
            isset($_POST['email'])
            && (empty($_POST['email'])
                || !preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD', $_POST['email']))
        ) {
            $errors['email'] = 'Le mail fourni ne respecte pas les conditions';
        }


        // Verification for `birthdate`
        if (
            isset($_POST['birthdate'])
            && (empty($_POST['birthdate'])
                || !preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", trim($_POST['birthdate']), $matches)
                || !checkdate($matches[2], $matches[3], $matches[1]))
        ) {
            // TODO @AvaN0x support of dd/mm/yyyy
            $errors['birthdate'] = 'La date de naissance fournie ne respecte pas les conditions';
        }

        // Verification for `address`
        if (
            isset($_POST['address'])
            && (empty($_POST['address'])
                || !preg_match('/^(?=.{0,64}$)(?:.{6,})$/i', $_POST['address']))
        ) {
            $errors['address'] = 'L\'adresse fournis ne respecte pas les conditions';
        }

        // Verification for `postcode`
        if (
            isset($_POST['postcode'])
            && (empty($_POST['postcode'])
                || !preg_match('/^[0-9]{5}$/', $_POST['postcode']))
        ) {
            $errors['postcode'] = 'Le code postal fourni ne respecte pas les conditions';
        }

        // Verification for `city`
        if (
            isset($_POST['city'])
            && (empty($_POST['city'])
                || !preg_match('/^(?=.{0,64}$)(?:[a-zØ-öø-ÿ](?:-?[[:blank:]]?[a-zØ-öø-ÿ])*)$/i', $_POST['city']))
        ) {
            $errors['city'] = 'La ville fournie ne respecte pas les conditions';
        }

        // If each field is correctly filled
        if (empty($errors)) {
            $jsonData = $result['jsonData'];
            $key = $result['key'];
            foreach ($fields as $value) {
                $content = (isset($_POST[$value]) ? strtolower(trim(htmlspecialchars($_POST[$value]))) : "");
                $jsonData[$key][$value] = $content;
            }
            setJsonData($jsonData);

            $_SESSION['user']['name'] = $jsonData[$key]['name'];
            $_SESSION['user']['fname'] = $jsonData[$key]['fname'];
        } else {
            foreach ($fields as $value)
                $postedValues[$value] = $result['profil'][$value];
        }
    }
    // Initialize the fields with the profil's values
    else {
        foreach ($fields as $value)
            $postedValues[$value] = $result['profil'][$value];
    }
}

include_once("view/edition.php");
