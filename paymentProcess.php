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
$productList = [];
$qtyList = [];

if (isset($_POST["cart"]) && $_POST["cart"] === "true") {
    // Add your cart logic here
    // Populate $productList and $qtyList arrays
} else {
    $productList[] = $_POST["id"];
    $qtyList[] = $_POST["qty"];
    $umail = $user["email"];
    $qty = $_POST["qty"];

    if (!is_numeric($qty)) {
        echo json_encode([
            "status" => "error",
            "message" => "Please enter a numeric quantity."
        ]);
        exit();
    }

    $address_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email`='" . $umail . "'");
    if ($address_rs->num_rows != 1) {
        echo json_encode([
            "status" => "error",
            "message" => "Please enter your address in 'My Profile'."
        ]);
        exit();
    }

    $address_data = $address_rs->fetch_assoc();
    $district_id = $address_data["district_district_id"];
    $address = $address_data["line1"] . ", " . $address_data["line2"] . "," . $address_data["city"] . ".";

    $district_rs = Database::search("SELECT * FROM `district` WHERE `district_id`='" . $district_id . "'");
    $district_data = $district_rs->fetch_assoc();

    $delivery = ($qty > 5) ? 0 : $district_data["delivery_cost"];
}

$merchantId = "1225034";
$merchantSecret = "MTUyOTk3MTU3MjE5NzI0NzQwNjIyNjUyNzIwNTQxNTE2ODEzMDY4";
$items = "";
$netTotal = 0;
$currency = "LKR";
$orderId = uniqid();

for ($i = 0; $i < sizeof($productList); $i++) {
    $rs2 = Database::search("SELECT * FROM `product` WHERE `id`='" . $productList[$i] . "'");
    $d2 = $rs2->fetch_assoc();

    if ($d2["qty_available"] < $qtyList[$i]) {
        echo json_encode([
            "status" => "error",
            "message" => "Sorry! The requested quantity is not available."
        ]);
        exit();
    }

    $items .= $d2["title"];
    if ($i != sizeof($productList) - 1) {
        $items .= ", ";
    }

    $netTotal += (intval($d2["price"]) * intval($qtyList[$i]));
}

$netTotal += $delivery;

$hash = strtoupper(md5(
    $merchantId .
    $orderId .
    number_format($netTotal, 2, '.', '') .
    $currency .
    strtoupper(md5($merchantSecret))
));

$payment = [
    "status" => "success",
    "sandbox" => true,
    "merchant_id" => $merchantId,
    "first_name" => $user["fname"],
    "last_name" => $user["lname"],
    "email" => $user["email"],
    "phone" => $user["mobile"],
    "address" => $address,
    "city" => $address_data["city"],
    "country" => "Sri Lanka",
    "order_id" => $orderId,
    "items" => $items,
    "currency" => $currency,
    "amount" => number_format($netTotal, 2, '.', ''),
    "hash" => $hash,
    "return_url" => "",
    "cancel_url" => "",
    "notify_url" => ""
];

echo json_encode($payment);
?>