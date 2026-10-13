<?php

session_start();
include "connection.php";

if (isset($_SESSION["u"])) {
    if (isset($_GET["id"])) {

        $pid = $_GET["id"];
        $qty = $_GET["q"];
        $umail = $_SESSION["u"]["email"];

        if (!is_numeric($qty)) {
            echo ("Please Enter a Number in the Quantity Field");
        } else {

            $cart_rs = Database::search("SELECT * FROM `cart` WHERE `product_id`='" . $pid . "' AND `user_email`='" . $umail . "'");
            $cart_num = $cart_rs->num_rows;

            $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $pid . "'");
            $product_data = $product_rs->fetch_assoc();

            $product_qty = $product_data["qty_available"];
            $available = $product_data["availability_availability_id"];

            if ($cart_num == 1) {

                $cart_data = $cart_rs->fetch_assoc();
                $current_qty = $cart_data["cart_qty"];
                $new_qty = (int)$current_qty + $qty;

                if ($product_qty >= $new_qty) {
                    Database::iud("UPDATE `cart` SET `cart_qty`='" . $new_qty . "' WHERE `cart_id`='" . $cart_data["cart_id"] . "'");
                    echo ("Cart Updated");
                } else if ($available == 2) {
                    Database::iud("UPDATE `cart` SET `cart_qty`='" . $new_qty . "' WHERE `cart_id`='" . $cart_data["cart_id"] . "'");
                    echo ("Cart Updated");
                } else {
                    echo ("Invalid Quantity");
                }
            } else {
                Database::iud("INSERT INTO `cart` (`cart_qty`,`user_email`,`product_id`) VALUES ('$qty','" . $umail . "','" . $pid . "')");
                echo ("New product added to the cart.");
            }
        }
    } else {
        echo ("Something Went Wrong.");
    }
} else {
    echo ("Please Login or Signup first.");
}
