<?php

include "connection.php";

$fname = $_POST["f"];
$lname = $_POST["l"];
$email = $_POST["e"];
$password = $_POST["p"];
$mobile = $_POST["m"];

if(empty($fname)){
    echo ("Please Enter the First Name.");
}else if(strlen($fname) > 45){
    echo ("First Name Must Contain LOWER THAN 45 characters.");
}else if(empty($lname)){
    echo ("Please Enter the Last Name.");
}else if(strlen($lname) > 45){
    echo ("Last Name Must Contain LOWER THAN 45 characters.");
}else if(empty($email)){
    echo ("Please Enter the Email Address.");
}else if(strlen($email) > 100){
    echo ("Email Address Must Contain LOWER THAN 100 characters.");
}else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    echo ("Invalid Email Address.");
}else if(empty($password)){
    echo ("Please Enter the Password.");
}else if(strlen($password) < 5 || strlen($password) > 20){
    echo ("Password Must Contain 5 to 20 Characters.");
}else if(empty($mobile)){
    echo ("Please Enter the Mobile Number.");
}else if(strlen($mobile) != 10){
    echo ("Mobile Number Must 10 characters.");
}else if(!preg_match("/07[0,1,2,4,5,6,7,8]{1}[0-9]{7}/",$mobile)){
    echo ("Invalid Mobile Number.");
}else{

    $rs = Database::search("SELECT * FROM `admin` WHERE `email` = '".$email."' OR `mobile` = '".$mobile."'");
    $n = $rs->num_rows;

    if($n > 0){
        echo ("Admin with the same Email Address or same Mobile Number already exists.");
    }else{

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        Database::iud("INSERT INTO `admin`
        (`fname`,`lname`,`email`,`password`,`mobile`,`registered_date`,`status_status_id`) VALUES
        ('".$fname."','".$lname."','".$email."','".$password."','".$mobile."','".$date."','1')");

        echo ("success");

    }

}    

?>