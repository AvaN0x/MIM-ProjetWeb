<?php

/**
 * userExists
 *
 * Check if a user with the login given exist
 *
 * @param  mixed $login The login of the user we want to retrieve
 * @return false|Array(Array,idx,value) False if user doesn't exist | Else an array with the list of all users, the index of the user and his value
 */
function userExists($login)
{
    $jsonData = getJsonData();

    foreach ($jsonData as $key => $profil) {
        if ($profil['login'] === $login)
            return array('jsonData' => $jsonData, 'key' => $key, 'profil' => $profil);
    }
    return false;
}


/**
 * addUser
 *
 * Add a user to the json file
 *
 * @param  mixed $user The user to add
 * @return void
 */
function addUser($user)
{
    $jsonData = getJsonData();

    array_push($jsonData, $user);
    file_put_contents(__DIR__ . "/../data.json", json_encode($jsonData));

    logUser($user);
}


/**
 * getJsonData
 *
 * Get the JSON File
 *
 * @return Array The JSON file
 */
function getJsonData()
{
    $jsonData = file_exists(__DIR__ . "/../data.json") ? json_decode(file_get_contents(__DIR__ . "/../data.json"), true) : [];
    if (empty($jsonData)) {
        $jsonData = [];
    }

    return $jsonData;
}

/**
 * setJsonData
 *
 * Replace the JSON file by the given data
 * @param mixed $data The data to convert to JSON
 * @return Array The JSON file
 */
function setJsonData($data)
{
    file_put_contents(__DIR__ . "/../data.json", json_encode($data));
}

// function editUser($user)
// {
//     $jsonData = getJsonData();

//     array_push($jsonData, $user);
//     file_put_contents(__DIR__ . "/../data.json", json_encode($jsonData));
// }


/**
 * logUser
 *
 * Set session variables for the user
 * Only use when the user is confirmed to be logged in and check datas before using this function
 *
 * @param  mixed $user Data of the user to log
 * @return void
 */
function logUser($user)
{
    // Login is the minimum required data
    if (!isset($user['login']))
        return;
    $_SESSION['connected'] = true;
    $_SESSION['user']['login'] = $user['login'];
    $_SESSION['user']['name'] = $user['name'];
    $_SESSION['user']['fname'] = $user['fname'];

    $_SESSION['user']['favorite_recipes'] = $user['favorite_recipes'] ?? [];

    // Add favorites to user favorites
    if (isset($_SESSION['favorite_recipes']) && count($_SESSION['favorite_recipes']) > 0) {
        foreach ($_SESSION['favorite_recipes'] as $value) {
            if (!in_array($value, $_SESSION['user']['favorite_recipes'])) {
                $_SESSION['user']['favorite_recipes'][] = $value;
            }
        }
        unset($_SESSION['favorite_recipes']);
    }
}

/**
 * isRecipeFavorite
 *
 * Set session variables for the user
 * Only use when the user is confirmed to be logged in and check datas before using this function
 *
 * @param  mixed $user Data of the user to log
 * @return void
 */
function isRecipeFavorite($id)
{
    // If connected and user has id in favorites recipes return true, else if favorites_recipes are set and id is in return true, else return false
    return (isset($_SESSION['connected'])
        && $_SESSION['connected'] === true
        && isset($_SESSION['user']['favorite_recipes'])
        && in_array($id, $_SESSION['user']['favorite_recipes']))
        || (isset($_SESSION['favorite_recipes'])
            && in_array($id, $_SESSION['favorite_recipes']));
}
