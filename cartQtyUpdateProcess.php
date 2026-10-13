<?php

include "connection.php";

if(isset($_GET["id"]) & isset($_GET["qty"])){

    $cid = $_GET["id"];
    $qty = $_GET["qty"];

    Database::iud("UPDATE `cart` SET `cart_qty`='".$qty."' WHERE `cart_id`='".$cid."'");
    echo ("Updated");

}else{
    echo ("Something went wrong.");
}

?>