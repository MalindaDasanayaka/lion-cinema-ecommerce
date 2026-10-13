<?php

include "connection.php";

$category = $_POST["c"];

if (empty($category)) {
    echo ("Please Enter Your Category Name");
} else if (strlen($category) > 45) {
    echo ("Your Category Name Should be less than 45 Characters");
} else {

    $category_rs = Database::search("SELECT * FROM `category` WHERE `category_name`='".$category."'");
    $category_num = $category_rs->num_rows;

    if ($category_num > 0) {
        echo("Your Category Name Already Exists");
    } else {
        Database::iud("INSERT INTO `category` (`category_name`) VALUES ('".$category."')");
        echo ("success");
    }
    
}
?>