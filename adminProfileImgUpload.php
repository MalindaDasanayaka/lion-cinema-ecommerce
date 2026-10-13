<?php

session_start();
$aduser = $_SESSION["au"];

include "connection.php";

if (empty($_FILES["i"])) {
    echo ("empty");
} else {

    $rs = Database::search("SELECT * from `admin_profile_img` WHERE `admin_email`='" . $aduser["email"] . "'");
    $d = $rs->fetch_assoc();

    if (!empty($d["admin_path"])) {
        unlink($d["admin_path"]);
    }

    $path = "resource//profile_images//" . uniqid() . ".png";
    move_uploaded_file($_FILES["i"]["tmp_name"], $path);

    Database::iud("UPDATE `admin_profile_img` SET `admin_path`='" . $path . "' WHERE `admin_email`='" . $aduser["email"] . "'");
    echo ($path);
}

?>