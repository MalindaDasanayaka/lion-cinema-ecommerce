<?php

include "connection.php";

if(isset($_GET["id"])){

    $oid = $_GET["id"];

    Database::iud("UPDATE `order` SET `history_status`='0' WHERE `oid`='".$oid."'");
    echo ("success");

}else{
    echo ("Something Went Wrong.");
}

?>