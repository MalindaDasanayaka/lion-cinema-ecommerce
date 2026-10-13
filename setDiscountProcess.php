<?php

include "connection.php";

$discount = $_POST["di"];

if (empty($discount)) {
    echo ("Please Enter Your Discount");
} else if ((!filter_var($discount, FILTER_VALIDATE_FLOAT) || $discount < 0 || $discount > 100)) {
    echo "Discount Should be Between 0 and 100.";
} else {

    Database::iud("UPDATE `product` SET `discount_percentage`='".$discount."'");
    echo ("success");
    
}

?>