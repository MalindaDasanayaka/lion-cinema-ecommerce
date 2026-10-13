<?php
include "connection.php";

if(isset($_GET["id"])){

    $pid = $_GET["id"];

    $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='".$pid."'");
    $product_num = $product_rs->num_rows;

    if($product_num == 1){
        $product_data = $product_rs->fetch_assoc();
        
        if($product_data["availability_availability_id"] == 2){
            Database::iud("UPDATE `product` SET `availability_availability_id`='1' WHERE `id`='".$pid."'");
        }
        echo ("success");
    }else{
        echo ("Cannot find the product. Please try again later.");
    }

}else{
    echo ("Something went wrong.");
}
?>