<?php
include "connection.php";
session_start();
$user = $_SESSION["u"];

if (isset($_POST["payment"])) {

    $payment = json_decode($_POST["payment"], true);

    $date = new DateTime();
    $date->setTimezone(new DateTimeZone("Asia/Colombo"));
    $time = $date->format("Y-m-d H-i-s");

    Database::iud("INSERT INTO `order`(`order_id`,`order_date`,`amount`,`history_status`,`delivery_status_d_id`,`user_email`) 
    VALUES('" . $payment["order_id"] . "','" . $time . "','" . $payment["amount"] . "','1','1','" . $user["email"] . "')");

    $orderHistoryId = Database::$connection->insert_id;

    Database::iud("INSERT INTO `invoice`(`qty`,`order_oid`,`product_id`) 
    VALUES('" . $payment["qty"] . "','" . $orderHistoryId . "','" . $payment["product_id"] . "')");

    $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $payment["product_id"] . "'");
    $product_data = $product_rs->fetch_assoc();

    $current_qty = $product_data["qty_available"];
    $sold_qty = $product_data["qty_sold"];
    $new_qty = $current_qty - $payment["qty"];
    $qty_sold = $sold_qty + $payment["qty"];

    if ($product_data["availability_availability_id"] == 1) {
        Database::iud("UPDATE `product` SET `qty_available`='" . $new_qty . "' WHERE `id`='" . $payment["product_id"] . "'");
        Database::iud("UPDATE `product` SET `qty_sold`='" . $qty_sold . "' WHERE `id`='" . $payment["product_id"] . "'");
    } else {
        Database::iud("UPDATE `product` SET `qty_sold`='" . $qty_sold . "' WHERE `id`='" . $payment["product_id"] . "'");
    }

    echo ("Success");
}
?>
