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
