<?php

include "connection.php";

$type = $_POST["t"];

if (empty($type)) {
    echo ("Please Enter Your Type Name");
} else if (strlen($type) > 45) {
    echo ("Your Type Name Should be less than 45 Characters");
} else {

    $type_rs = Database::search("SELECT * FROM `type` WHERE `type`='".$type."'");
    $type_num = $type_rs->num_rows;

    if ($type_num > 0) {
        echo("Your Type Name Already Exists");
    } else {
        Database::iud("INSERT INTO `type` (`type`) VALUES ('".$type."')");
        echo ("success");
    }
    
}
?>