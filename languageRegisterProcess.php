<?php

include "connection.php";

$language = $_POST["l"];

if (empty($language)) {
    echo ("Please Enter Your Language Name");
} else if (strlen($language) > 45) {
    echo ("Your Language Name Should be less than 45 Characters");
} else {

    $language_rs = Database::search("SELECT * FROM `language` WHERE `language_name`='".$language."'");
    $language_num = $language_rs->num_rows;

    if ($language_num > 0) {
        echo("Your Language Name Already Exists");
    } else {
        Database::iud("INSERT INTO `language` (`language_name`) VALUES ('".$language."')");
        echo ("success");
    }
    
}
?>