<?php

require_once(__DIR__ . "/../model/user.inc.php");

$errors = [];

$result = userExists($_SESSION['user']['login']);
if ($result === false) {
    $errors['deletedProfil'] = 'deletedProfil';
    unset($_SESSION['connected']);
    unset($_SESSION['user']);
} else {
    $fields = ["name", "fname", "gender", "email", "birthdate", "address", "postcode", "city", "phone"];
    $toJson = [];

    $postedValues = [];

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
        //-------------------------------------------------------------------//
        //-------------------------------------------------------------------//
        //                  VERIFICATION OF EACH FIELD                       //
        //-------------------------------------------------------------------//
        //-------------------------------------------------------------------//

        // Verification for `name`
        if (
            isset($_POST['name'])
            && strlen($_POST['name'])
            && !preg_match("/^(?=.{0,64}$)(?:[a-zØ-öø-ÿ](?:[ '-]?[a-zØ-öø-ÿ])*)$/i", $_POST['name']) // Max of 64 characters, at least 1 character, only letters, -, ' and spaces
        ) {
            $errors['name'] = 'Le nom fourni ne respecte pas les conditions';
        }

        // Verification for `fname`
        if (
            isset($_POST['fname'])
            && strlen($_POST['fname'])
            && !preg_match("/^(?=.{0,64}$)(?:[a-zØ-öø-ÿ](?:[ '-]?[a-zØ-öø-ÿ])*)$/i", $_POST['fname']) // Max of 64 characters, at least 1 character, only letters, -, ' and spaces
        ) {
            $errors['fname'] = 'Le prénom fourni ne respecte pas les conditions';
        }

        //Verification for passwords
        if (
            isset($_POST['prevPassword'])
            && strlen($_POST['prevPassword'])
        ) {
            if (!isset($_POST['newPassword']) || !strlen($_POST['newPassword'])) {
                $errors['newPassword'] = 'Le nouveau mot de passe n\'est pas fourni';
            }
            if (!isset($_POST['confirmPassword']) || !strlen($_POST['confirmPassword'])) {
                $errors['confirmPassword'] = 'La confirmation de mot de passe n\'est pas fournie';
            }
            if (
                isset($_POST['newPassword'])
                && strlen($_POST['newPassword'])
                && (!preg_match('/^.+$/', $_POST['newPassword']))
            ) {
                $errors['newPassword'] = 'Le nouveau mot de passe ne respecte pas les conditions';
            }
            if (
                isset($_POST['confirmPassword'])
                && strlen($_POST['confirmPassword'])
                && $_POST['newPassword'] !== $_POST['confirmPassword']
            ) {
                $errors['confirmPassword'] = 'La confirmation de mot de passe est différente du nouveau mot de passe';
            }

            $res = userExists($_SESSION['user']['login']);
            if ($res !== false && !password_verify($_POST['prevPassword'], $res['profil']['password'])) {
                $errors['prevPassword'] = 'Le mot de passe est incorrect';
            }
        } else {
            if (isset($_POST['newPassword']) && strlen($_POST['newPassword'])) {
                if (!preg_match('/^.+$/', $_POST['newPassword']))
                    $errors['newPassword'] = 'Le nouveau mot de passe ne respecte pas les conditions';

                if (!isset($_POST['confirmPassword']) || !strlen($_POST['confirmPassword']))
                    $errors['confirmPassword'] = 'La confirmation de mot de passe n\'est pas fournie';

                $errors['prevPassword'] = 'La vérification de l\'ancien mot de passe et manquante';
            }
            if (isset($_POST['confirmPassword']) && strlen($_POST['confirmPassword'])) {
                if (!isset($_POST['newPassword']) || !strlen($_POST['newPassword']))
                    $errors['newPassword'] = 'Le nouveau mot de passe n\'est pas fourni';

                if ($_POST['newPassword'] !== $_POST['confirmPassword'])
                    $errors['confirmPassword'] = 'La confirmation de mot de passe est différente du nouveau mot de passe';

                $errors['prevPassword'] = 'La vérification de l\'ancien mot de passe et manquante';
            }
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
        ) {
            if (preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $_POST['birthdate'], $matches) && checkdate($matches[2], $matches[3], $matches[1])) {
                if (strtotime('-18 years', time()) < strtotime($_POST['birthdate'])) {
                    $errors['birthdate'] = 'Vous devez avoir au minimum 18 ans';
                }
            } else {
                $errors['birthdate'] = 'La date de naissance fournie ne respecte pas les conditions';
            }
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
            && !preg_match('/^0\d(?:\s?\d{2}){4}$/', $_POST['phone']) // Support only french phone numbers (0X XX XX XX XX or 0XXXXXXXXX)
        ) {
            $errors['phone'] = 'Le numéro de téléphone fourni ne respecte pas les conditions';
        }

        // If each field is correctly filled
        if (empty($errors)) {
            // If user didn't change password get the saved one
            if (
                !(isset($_POST['prevPassword'])
                    && strlen($_POST['prevPassword'])
                    && isset($_POST['newPassword'])
                    && strlen($_POST['newPassword'])
                    && isset($_POST['confirmPassword'])
                    && strlen($_POST['confirmPassword']))
            ) {
                $_POST['newPassword'] = $result['profil']['password'];
            }

            // Merge the list of non changing infos and the list of changing values
            $toSend = array_merge(
                [
                    'login' => $result['profil']['login'],
                    'favorite_recipes' => $result['profil']['favorite_recipes']
                ],
                $_POST
            );

            // Create a new user from merged arrays
            try {
                $user = new User($toSend);
                editUser($result['key'], $user);

                $updated = 'updated';
            } catch (Exception $e) {
                echo '<p class="error-field">' . $e->getMessage() . '</p>';
            }
        } else {
            foreach ($fields as $value) {
                if (isset($errors[$value]))
                    $postedValues[$value] = $result['profil'][$value];
                elseif (isset($_POST[$value]))
                    $postedValues[$value] = $_POST[$value];
            }
        }
    }
    // Initialize the fields with the profil's values
    else {
        foreach ($fields as $value)
            if ($value !== 'prevPassword' && $value !== 'newPassword' && $value !== 'confirmPassword')
                $postedValues[$value] = $result['profil'][$value];
    }
}

if (!isset($updated)) {
    // Include the view
    include_once(__DIR__ . "/../view/edition.php");
} else {
    include_once(__DIR__ . "/../view/confirmation.php");
    unset($updated);
}
