<?php
include "connection.php";

if(isset($_GET["id"]) && isset($_GET["qty"])){

    $oid = $_GET["id"];
    $qty = $_GET["qty"];

    $pid_rs = Database::search("SELECT * FROM `order` INNER JOIN `invoice` ON order.oid=invoice.order_oid WHERE `oid`='" . $oid . "'");
    $pid_num = $pid_rs->num_rows;

    for ($x = 0; $x < $pid_num; $x++) {
        $pid_data = $pid_rs->fetch_assoc();

        $pid = $pid_data["product_id"];

        $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $pid . "'");
        $product_data = $product_rs->fetch_assoc();

        $current_qty = $product_data["qty_available"];
        $sold_qty = $product_data["qty_sold"];
        $new_qty = $current_qty - $qty;
        $qty_sold = $sold_qty + $qty;

        if ($product_data["availability_availability_id"] == 1) {
            Database::iud("UPDATE `product` SET `qty_available`='" . $new_qty . "' WHERE `id`='" . $pid . "'");
            Database::iud("UPDATE `product` SET `qty_sold`='" . $qty_sold . "' WHERE `id`='" . $pid . "'");
        } else {
            Database::iud("UPDATE `product` SET `qty_sold`='" . $qty_sold . "' WHERE `id`='" . $pid . "'");
        }
    }

    Database::iud("UPDATE `order` SET `delivery_status_d_id`='1' WHERE `oid`='".$oid."'");
    
    echo ("success");
}else{
    echo("something went wrong");
}
?>