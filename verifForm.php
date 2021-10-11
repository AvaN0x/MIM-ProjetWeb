<?php
    session_start();
    $_SESSION['errors'] = [];
    $fields= ["login", "pwd", "name", "fname", "gender", "mail", "date", "address", "postcode", "city"];
    $optionlFields= ["name", "fname", "gender", "mail", "date", "address", "postcode", "city"];
    $toJson = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // print_r($_POST);
        
        // Verification for `login`
        if (!isset($_POST['login']) || 
            empty($_POST['login']) || 
            !preg_match('/^[a-zA-Z0-9]{6,}$/', $_POST['login'])
        ) 
        {
            $_SESSION['errors']['login'] = 'login';
        }

        // Verification for `password`
        if (!isset($_POST['pwd']) || 
            empty($_POST['pwd']) || 
            !preg_match('/^.{8,}$/', $_POST['pwd'])
        ) 
        {
            $_SESSION['errors']['pwd'] = 'pwd';
        }

        if ($_POST['type'] === 'inscription') {
            // Verification for `name`
            if (isset($_POST['name']) && 
                !empty($_POST['name'] ) &&
                !preg_match('/^[A-Z][A-Z-\s]*[A-Z]$/', $_POST['fname'])
            ) 
            {
                $_SESSION['errors']['name'] = 'name';
            }

            // Verification for `fname`
            if (isset($_POST['fname']) && 
                !empty($_POST['fname']) && 
                !preg_match('/^[A-Z][a-z-\s]*[a-z]$/', $_POST['fname'])
            ) 
            {
                $_SESSION['errors']['fname'] = 'fname';
            }

            // Verification for `gender`
            if (isset($_POST['gender']) && 
                !empty($_POST['gender']) &&
                !preg_match('/^[hf]$/', $_POST['gender'])
            ) 
            {
                $_SESSION['errors']['gender'] = 'gender';
            }

            // Verification for `mail`
            if (isset($_POST['mail']) && 
                !empty($_POST['mail']) &&
                !preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD', $_POST['mail'])
            ) 
            {
                $_SESSION['errors']['mail'] = 'mail';
            }

            $date = explode('-', $_POST['date']);
            // Verification for `date`
            if (isset($_POST['date']) && 
                !empty($_POST['date']) &&
                checkdate($date[1], $date[2], $date[0])
            ) 
            {
                $_SESSION['errors']['date'] = 'date';
            }

            // Verification for `address`
            if (isset($_POST['address']) && 
                !empty($_POST['address']) &&
                !preg_match('/^[0-9]{1,2}[a-z\s]+$/i', $_POST['address'])
            ) 
            {
                $_SESSION['errors']['address'] = 'address';
            }

            // Verification for `postcode`
            if (isset($_POST['postcode']) && 
                !empty($_POST['postcode']) &&
                !preg_match('/^[0-9]{5}$/', $_POST['postcode'])
            ) 
            {
                $_SESSION['errors']['postcode'] = 'postcode';
            }

            // Verification for `city`
            if (isset($_POST['city']) && 
                !empty($_POST['city']) &&
                !preg_match('/^[A-Z][a-z-]*[a-z]$/i', $_POST['city'])
            ) 
            {
                $_SESSION['errors']['city'] = 'city';
            }
        }

        

        // if (!empty($_SESSION['errors'])) {print_r($_SESSION['errors']);}

        // If no errors, save new infos in JSON file
        if ($_POST['type'] == 'inscription' && empty($_SESSION['errors'])) {
            foreach ($fields as $key => $value) {
                $toJson[$value] = (isset($_POST[$value]) ? $_POST[$value] : "");
            }
        }
        else {
            //TODO
        }

        // print_r($toJson);
        //TODO
        file_put_contents("data.json", json_encode($toJson), FILE_APPEND);

        $link = (empty($_SESSION['errors'])) ? 'index.php' : $_POST['type'] . '.php';
        
        header("Location: $link");
    }