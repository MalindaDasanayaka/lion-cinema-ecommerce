<?php
session_start();
include "connection.php";

$email = $_SESSION["u"]["email"];

$fname = $_POST["f"];
$lname = $_POST["l"];
$mobile = $_POST["m"];
$line1 = $_POST["l1"];
$line2 = $_POST["l2"];
$province = $_POST["p"];
$district = $_POST["d"];
$city = $_POST["c"];
$pcode = $_POST["pc"];

if (empty($fname)) {
    echo ("Please Enter Your First Name.");
} else if (strlen($fname) > 45) {
    echo ("First Name Must Contain LOWER THAN 45 characters.");
} else if (empty($lname)) {
    echo ("Please Enter Your Last Name.");
} else if (strlen($lname) > 45) {
    echo ("Last Name Must Contain LOWER THAN 45 characters.");
} else if (empty($mobile)) {
    echo ("Please Enter Your Mobile Number.");
} else if (strlen($mobile) != 10) {
    echo ("Mobile Number Must 10 characters.");
} else if (!preg_match("/07[0,1,2,4,5,6,7,8]{1}[0-9]{7}/", $mobile)) {
    echo ("Invalid Mobile Number.");
} else if (empty($line1)) {
    echo ("Please Enter Your Address Line 1.");
} else if (strlen($line1) > 100) {
    echo ("Address Line 1 Must Contain LOWER THAN 100 characters.");
} else if (empty($line2)) {
    echo ("Please Enter Your Address Line 2.");
} else if (strlen($line2) > 100) {
    echo ("Address Line 2 Must Contain LOWER THAN 100 characters.");
} else if (empty($city)) {
    echo ("Please Enter Your City Name.");
} else if (strlen($city) > 50) {
    echo ("City Name Must Contain LOWER THAN 50 characters.");
} else if (empty($pcode)) {
    echo ("Please Enter Your Postal Code.");
} else if (!is_numeric($pcode)) {
    echo ("Postal Code Should be in Numbers.");
} else if (strlen($pcode) > 5) {
    echo ("Postal Code Must Contain LOWER THAN 5 numbers.");
} else if ($district == 0) {
    echo ("Please Select Your District.");
} else if ($province == 0) {
    echo ("Please Select Your Province.");
} else {

    $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "'");

    if ($user_rs->num_rows == 1) {

        Database::iud("UPDATE `user` SET `fname`='" . $fname . "',`lname`='" . $lname . "',`mobile`='" . $mobile . "' WHERE 
        `email`='" . $email . "'");

        $rs = Database::search("SELECT * FROM `user` WHERE `email` = '". $email. "'");
        $d = $rs->fetch_assoc();
        $_SESSION["u"] = $d;

        $address_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email`='" . $email . "'");

        if ($address_rs->num_rows == 1) {

            Database::iud("UPDATE `user_has_address` SET `line1`='" . $line1 . "',`line2`='" . $line2 . "',
        `city`='" . $city . "',`postal_code`='" . $pcode . "',`district_district_id`='" . $district . "' WHERE `user_email`='" . $email . "'");
        } else {

            Database::iud("INSERT INTO `user_has_address`(`line1`,`line2`,`city`,`postal_code`,`district_district_id`,`user_email`) 
        VALUES ('" . $line1 . "','" . $line2 . "','" . $city . "','" . $pcode . "','" . $district . "','" . $email . "')");
        }

        echo ("Updated");
    } else {
        echo ("Invalid user.");
    }
}
?>