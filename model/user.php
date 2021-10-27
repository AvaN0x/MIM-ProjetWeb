<?php
function userExists($login)
{
    $jsonData = file_exists(__DIR__ . "/../data.json") ? json_decode(file_get_contents(__DIR__ . "/../data.json"), true) : [];
    if (empty($jsonData)) {
        $jsonData = [];
    }

    foreach ($jsonData as $key => $profil) {
        if ($profil['login'] === $login)
            return array('jsonData' => $jsonData, 'key' => $key, 'profil' => $profil);
    }
    return false;
}
