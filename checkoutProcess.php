<?php
header('Content-Type: application/json');
ini_set('display_errors', 0);
error_reporting(0);

include "connection.php";
session_start();

if (!isset($_SESSION["u"])) {
    echo json_encode([
        "status" => "error",
        "message" => "Please log in first."
    ]);
    exit();
}

$user = $_SESSION["u"];

if (!isset($_POST["payment"])) {
    echo json_encode([
        "status" => "error",
        "message" => "Payment information could not be retrieved."
    ]);
    exit();
}

$payment = json_decode($_POST["payment"], true);
if (!$payment || !isset($payment["order_id"], $payment["amount"])) {
    echo json_encode([
        "status" => "error",
        "message" => "Valid payment data was not provided."
    ]);
    exit();
}


$date = new DateTime("now", new DateTimeZone("Asia/Colombo"));
$time = $date->format("Y-m-d H:i:s");

// Insert order
Database::iud("INSERT INTO `order` (`order_id`, `order_date`, `amount`, `history_status`, `delivery_status_d_id`, `user_email`) 
VALUES (
    '" . $payment["order_id"] . "',
    '" . $time . "',
    '" . $payment["amount"] . "',
    '1',
    '1',
    '" . $user["email"] . "'
)");

$orderHistoryId = Database::$connection->insert_id;

// Fetch cart items
$rs = Database::search("SELECT * FROM `cart` WHERE `user_email`='" . $user["email"] . "'");
if ($rs->num_rows === 0) {
    echo json_encode([
        "status" => "error",
        "message" => "The cart is empty."
    ]);
    exit();
}

while ($d = $rs->fetch_assoc()) {
    // Insert invoice
    Database::iud("INSERT INTO `invoice` (`qty`, `order_oid`, `product_id`) 
    VALUES (
        '" . $d["cart_qty"] . "',
        '" . $orderHistoryId . "',
        '" . $d["product_id"] . "'
    )");

    // Update product quantities
    $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $d["product_id"] . "'");
    if ($product_rs->num_rows === 1) {
        $product_data = $product_rs->fetch_assoc();
        $new_qty = $product_data["qty_available"] - $d["cart_qty"];
        $qty_sold = $product_data["qty_sold"] + $d["cart_qty"];

        if ($product_data["availability_availability_id"] == 1) {
            Database::iud("UPDATE `product` SET 
                `qty_available`='" . $new_qty . "', 
                `qty_sold`='" . $qty_sold . "' 
                WHERE `id`='" . $d["product_id"] . "'");
        } else {
            Database::iud("UPDATE `product` SET 
                `qty_sold`='" . $qty_sold . "' 
                WHERE `id`='" . $d["product_id"] . "'");
        }
    }
}

// Clear cart
Database::iud("DELETE FROM `cart` WHERE `user_email`='" . $user["email"] . "'");

// Final response
echo json_encode([
    "status" => "success",
    "message" => "Your order has been successfully saved."
]);
?>