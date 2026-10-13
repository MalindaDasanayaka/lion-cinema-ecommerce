<?php

session_start();
include "connection.php";

if(isset($_POST["c"])){

    $v = $_POST["c"];

    $sadmin_rs = Database::search("SELECT * FROM `super_admin` WHERE `vcode`='".$v."'");
    $sadmin_num = $sadmin_rs->num_rows;

    if($sadmin_num == 1){

        $sadmin_data = $sadmin_rs->fetch_assoc();
        $_SESSION["su"] = $sadmin_data;
        echo ("success");

    }else{
        echo ("Invalid Verification Code.");
    }

}else{
    echo ("Please enter the verification code.");
}

?>