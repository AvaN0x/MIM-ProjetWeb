<?php
    session_start();
    $errors = [];
    $fields= ["login", "pwd", "name", "fname", "gender", "mail", "date", "address", "postcode", "city"];
    $toJson = [];

    $postedValues = [];
    foreach ($fields as $key => $value) {
        $postedValues[$value] = "";
    }

    if (
        $_SERVER["REQUEST_METHOD"] === "POST" && 
        isset($_POST) && 
        isset($_POST["submit"])
    ) 
    {
        // First get the content of the JSON File
        $jsonData = json_decode(file_get_contents("data.json"), true);
        if (empty($jsonData)) { $jsonData = []; }


        ///////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////
        //                  VERIFICATION OF EACH FIELD                       //
        ///////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////

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

        // If each field is correctly filled
        if (empty($errors)) {
            // Verification if we are trying to get a new profil
            if ($_POST['type'] === 'inscription') {

                // Verification if the login doesn't already exists
                foreach ($jsonData as $key => $profil) {
                    if (isset($profil['login']) && $_POST['login'] === $profil['login'] ) {
                        $errors['login'] = 'login';
                        break;
                    }
                }

                // If it doesn't already exists, save the new profil in JSON file
                // And connect him / her with his / her new account
                if (!isset($errors['login'])) {
                    foreach ($fields as $key => $value) {
                        $toJson[$value] = (isset($_POST[$value]) ? $_POST[$value] : "");
                    }

                    array_push($jsonData, $toJson);
                    file_put_contents("data.json", json_encode($jsonData));

                    $_SESSION['connected']['login'] = $_POST['login'];
                    $_SESSION['connected']['pwd'] = $_POST['pwd'];
                }
            }
            // Or if we are trying to connect
            else {
                // If 1 profil in JSON file match with the login and pwd given
                // no errors thrown and connect him / her
                $errors['login'] = 'login';
                $errors['pwd'] = 'pwd';
                foreach ($jsonData as $key => $profil) {
                    if (isset($profil['login']) &&
                        isset($profil['pwd']) &&
                        $_POST['login'] === $profil['login'] &&
                        $_POST['pwd'] === $profil['pwd']
                    ) {

                        unset($errors['login']);
                        unset($errors['pwd']);

                        $_SESSION['connected']['login'] = $_POST['login'];
                        $_SESSION['connected']['pwd'] = $_POST['pwd'];
                        break;
                    }
                }
            }
        }
        
        // If errors have been thrown, save the posted values
        if (!empty($errors)) {
            foreach ($fields as $key => $value) {
                if (isset($_POST[$value])) {
                    $postedValues[$value] = $_POST[$value];
                }
            }
        }
    }