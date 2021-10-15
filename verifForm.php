<?php
    session_start();
    $errors = [];
    $postedValues = [];
    $fields= ["login", "pwd", "name", "fname", "gender", "mail", "date", "address", "postcode", "city"];
    $toJson = [];

    foreach ($fields as $key => $value) {
        $postedValues[$value] = "";
    }

    if (
        $_SERVER["REQUEST_METHOD"] === "POST" && 
        isset($_POST) && 
        isset($_POST["submit"])
    ) {
        // Verification for `login`
        if (!isset($_POST['login']) || 
            empty($_POST['login']) || 
            !preg_match('/^[a-zA-Z0-9]{6,}$/', $_POST['login'])
        ) 
        {
            $errors['login'] = 'login';
        }

        // Verification for `password`
        if (!isset($_POST['pwd']) || 
            empty($_POST['pwd']) || 
            !preg_match('/^.{8,}$/', $_POST['pwd'])
        ) 
        {
            $errors['pwd'] = 'pwd';
        }

        if ($_POST['type'] === 'inscription') {
            // Verification for `name`
            if (isset($_POST['name']) && 
                !empty($_POST['name'] ) &&
                !preg_match('/^[A-Z][A-Z-\s]*[A-Z]$/', $_POST['name'])
            ) 
            {
                $errors['name'] = 'name';
            }

            // Verification for `fname`
            if (isset($_POST['fname']) && 
                !empty($_POST['fname']) && 
                !preg_match('/^[A-Z][a-z-\s]*[a-z]$/', $_POST['fname'])
            ) 
            {
                $errors['fname'] = 'fname';
            }

            // Verification for `gender`
            if (isset($_POST['gender']) && 
                !empty($_POST['gender']) &&
                !preg_match('/^[hf]$/', $_POST['gender'])
            ) 
            {
                $errors['gender'] = 'gender';
            }

            // Verification for `mail`
            if (isset($_POST['mail']) && 
                !empty($_POST['mail']) &&
                !preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD', $_POST['mail'])
            ) 
            {
                $errors['mail'] = 'mail';
            }

            
            // Verification for `date`
            if (isset($_POST['date']) && !empty($_POST['date']) ) {
                $date = explode('-', $_POST['date']);
                if (!checkdate($date[1], $date[2], $date[0]))
                    $errors['date'] = 'date';
            }

            // Verification for `address`
            if (isset($_POST['address']) && 
                !empty($_POST['address']) &&
                !preg_match('/^[0-9]{1,2}[a-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\s]+$/i', $_POST['address'])
            ) 
            {
                $errors['address'] = 'address';
            }

            // Verification for `postcode`
            if (isset($_POST['postcode']) && 
                !empty($_POST['postcode']) &&
                !preg_match('/^[0-9]{5}$/', $_POST['postcode'])
            ) 
            {
                $errors['postcode'] = 'postcode';
            }

            // Verification for `city`
            if (isset($_POST['city']) && 
                !empty($_POST['city']) &&
                !preg_match('/^[A-Z][a-z-]*[a-z]$/i', $_POST['city'])
            ) 
            {
                $errors['city'] = 'city';
            }
        }

        if (empty($errors)) {
            if ($_POST['type'] === 'inscription') {
                // If no errors + onInscription mode, save new infos in JSON file
                // First get the content of the JSON File
                $jsonData = json_decode(file_get_contents("data.json"), true);

                foreach ($fields as $key => $value) {
                    $toJson[$value] = (isset($_POST[$value]) ? $_POST[$value] : "");
                }

                array_push($jsonData, $toJson);
                file_put_contents("data.json", json_encode($jsonData));
            }

            $_SESSION['connected']['login'] = $_POST['login'];
            $_SESSION['connected']['pwd'] = $_POST['pwd'];
        }
        else {
            foreach ($fields as $key => $value) {
                $postedValues[$value] = isset($_POST[$value]) ? $_POST[$value] : "";
            }
        }
    }