<?php
require_once("model/utils.inc.php");

/**
 * Get image file name based on title
 *
 * @param string image title
 * @return string image file name
 */
function getImageFileName($title)
{
    // Remove all accents from the title (titre)
    // Then remove all spaces (` `) for underscores (`_`)
    $img_file_name = str_replace(" ", "_", removeAccents($title)) . '.jpg';

    // If the file do not exist, then we set the default image
    if (!file_exists(__DIR__ . "/../res/Photos/$img_file_name"))
        $img_file_name = "cocktail.png";

    return $img_file_name;
}
