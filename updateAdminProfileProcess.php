<?php
session_start();
include "connection.php";

$email = $_SESSION["au"]["email"];

$fname = $_POST["f"];
$lname = $_POST["l"];
$mobile = $_POST["m"];
$password = $_POST["p"];

if (empty($fname)) {
    echo ("Please Enter Your First Name.");
} else if (strlen($fname) > 45) {
    echo ("First Name Must Contain LOWER THAN 45 characters.");
} else if (empty($lname)) {
    echo ("Please Enter Your Last Name.");
} else if (strlen($lname) > 45) {
    echo ("Last Name Must Contain LOWER THAN 45 characters.");
} else if (empty($password)) {
    echo ("Please Enter Your Password.");
} else if (strlen($password) < 5 || strlen($password) > 20) {
    echo ("Password Must Contain 5 to 20 Characters.");
} else if (empty($mobile)) {
    echo ("Please Enter Your Mobile Number.");
} else if (strlen($mobile) != 10) {
    echo ("Mobile Number Must 10 characters.");
} else if (!preg_match("/07[0,1,2,4,5,6,7,8]{1}[0-9]{7}/", $mobile)) {
    echo ("Invalid Mobile Number.");
} else {

    $admin_rs = Database::search("SELECT * FROM `admin` WHERE `email`='" . $email . "'");

    if ($admin_rs->num_rows == 1) {

        Database::iud("UPDATE `admin` SET `fname`='" . $fname . "',`lname`='" . $lname . "',
        `password`='" . $password . "',`mobile`='" . $mobile . "' WHERE `email`='" . $email . "'");

        $rs = Database::search("SELECT * FROM `admin` WHERE `email` = '". $email. "'");
        $d = $rs->fetch_assoc();
        $_SESSION["au"] = $d;

        echo("Updated");
    } else {
        echo ("Invalid admin.");
    }
}
?>