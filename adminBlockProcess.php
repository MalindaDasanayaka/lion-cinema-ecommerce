<?php

include "connection.php";

if(isset($_GET["email"])){

    $admin_email = $_GET["email"];

    $admin_rs = Database::search("SELECT * FROM `admin` WHERE `email`='".$admin_email."'");
    $admin_num = $admin_rs->num_rows;

    if($admin_num == 1){

        $admin_data = $admin_rs->fetch_assoc();

        if($admin_data["status_status_id"] == 1){
            Database::iud("UPDATE `admin` SET `status_status_id`='2' WHERE `email`='".$admin_email."'");
            echo ($admin_data["fname"]." ". $admin_data["lname"]." blocked.");
        }else if($admin_data["status_status_id"] == 2){
            Database::iud("UPDATE `admin` SET `status_status_id`='1' WHERE `email`='".$admin_email."'");
            echo ($admin_data["fname"]." ". $admin_data["lname"]." unblocked.");
        }

    }else{
        echo ("Cannot find the user. Please try again later.");
    }

}else{
    echo ("Something went wrong.");
}

?>