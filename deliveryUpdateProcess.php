<?php

include "connection.php";

if (isset($_GET["id"]) & isset($_GET["cost"])) {

    $did = $_GET["id"];
    $delivery = $_GET["cost"];

    if (empty($delivery)) {
        echo ("Please Enter Your Delivery Cost");
    } else if (!is_numeric($delivery)) {
        echo ("Only Numbers can be Entered for Cost");
    } else if (strlen($delivery) > 10) {
        echo ("Your Cost cannot be Greater than 10 Characters");
    } else {

        Database::iud("UPDATE `district` SET `delivery_cost`='" . $delivery . "' WHERE `district_id`='".$did."'");
        echo ("success");
    }

}else{
    echo ("Something went wrong.");
}
?>