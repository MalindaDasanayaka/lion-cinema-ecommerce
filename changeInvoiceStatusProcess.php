<?php

include "connection.php";

if(isset($_GET["id"])){

    $oid = $_GET["id"];

    $order_rs = Database::search("SELECT * FROM `order` WHERE `oid`='".$oid."'");
    $order_data = $order_rs->fetch_assoc();

    $status_id = $order_data["delivery_status_d_id"];

    if($status_id == 1){
        Database::iud("UPDATE `order` SET `delivery_status_d_id`='2' WHERE `oid`='".$oid."'");
    }else if($status_id == 2){
        Database::iud("UPDATE `order` SET `delivery_status_d_id`='3' WHERE `oid`='".$oid."'");
    }if($status_id == 3){
        Database::iud("UPDATE `order` SET `delivery_status_d_id`='4' WHERE `oid`='".$oid."'");
    }

    echo ("success");

}

?>