<?php
    $errors = [];
    $fields= ["login", "pwd"];
    $optionlFields = ["name", "fname", "gender", "mail", "date", "address", "postcode", "city"];
    $toJson = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // print_r($_POST);
        
        // Verification for `login`
        if (!isset($_POST['login']) || 
            empty($_POST['login']) || 
            !preg_match('/^[a-zA-Z0-9]{6,}$/', $_POST['login'])
        ) 
        {
            $errors[] = 'login';
        }

        // Verification for `password`
        if (!isset($_POST['pwd']) || 
            empty($_POST['pwd']) || 
            !preg_match('/^.{8,}$/', $_POST['pwd'])
        ) 
        {
            $errors[] = 'pwd';
        }

        // if (!empty($errors)) {print_r($errors);}

        // If no errors, save new infos in JSON file
        if ($_POST['type'] === 'inscription' && empty($errors)) {
            foreach ($fields as $key => $value) {
                $toJson[$value] = (isset($_POST[$value]) ? $_POST[$value] : "");
            }
            foreach ($optionlFields as $key => $value) {
                $toJson[$value] = (isset($_POST[$value]) ? $_POST[$value] : "");
            }
        }
        else {
            //TODO
        }

        // print_r($toJson);
        //TODO
        if (file_put_contents("data.json", json_encode($toJson), FILE_APPEND))
            echo "Vous compte a été créé avec succès !";
        else 
            echo "Une erreur est survenue lors de l'enregistrement de vos données";
    }