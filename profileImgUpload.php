<?php

session_start();
$user = $_SESSION["u"];

include "connection.php";

if (empty($_FILES["i"])) {
    echo ("empty");
} else {

    $rs = Database::search("SELECT * from `profile_img` WHERE `user_email`='" . $user["email"] . "'");
    $d = $rs->fetch_assoc();

    if (!empty($d["path"])) {
        unlink($d["path"]);
    }

    $path = "resource//profile_images//" . uniqid() . ".png";
    move_uploaded_file($_FILES["i"]["tmp_name"], $path);

    Database::iud("UPDATE `profile_img` SET `path`='" . $path . "' WHERE `user_email`='" . $user["email"] . "'");
    echo ($path);
}

?>