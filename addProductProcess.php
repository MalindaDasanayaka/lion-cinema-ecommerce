<?php

session_start();
include "connection.php";

$type = $_POST["ty"];
$category = $_POST["ca"];
$language = $_POST["l"];
$title = $_POST["ti"];
$availability = $_POST["av"];
$ratings = $_POST["ra"];
$qty = $_POST["q"];
$cost = $_POST["co"];
$discount = $_POST["di"];
$redate = $_POST["rd"];
$runtime = $_POST["rt"];
$trailer = $_POST["tr"];
$desc = $_POST["de"];

if ($type == 0) {
    echo "Please Select a Product Type.";
} else if ($category == 0) {
    echo "Please Select a Product Category.";
} else if ($language == 0) {
    echo "Please Select a Product Language.";
} else if (empty($title)) {
    echo "Please Enter A Title For The Product.";
} else if (strlen($title) > 200) {
    echo "Title Name Should be Less Than 200 Characters.";
} else if (!empty($ratings) && (!filter_var($ratings, FILTER_VALIDATE_FLOAT) || $ratings < 0 || $ratings > 10)) {
    echo "Ratings Should be Between 0 and 10.";
} else if (!is_numeric($qty)) {
    echo "Product Quantity Should Only Contain Numbers.";
} else if (strlen($qty) > 10) {
    echo "Product Quantity Should be Less Than 10 Numbers.";
} else if (empty($cost)) {
    echo "Please Enter A Cost For The Product.";
} else if (!is_numeric($cost)) {
    echo "Product Price Should Only Contain Numbers.";
} else if (strlen($cost) > 10) {
    echo "Product Price Should be Less Than 10 Numbers.";
} else if (!empty($discount) && (!filter_var($discount, FILTER_VALIDATE_FLOAT) || $discount < 0 || $discount > 100)) {
    echo "Discount Should be Between 0 and 100.";
} else if (empty($desc)) {
    echo "Please Enter A Description For The Product.";
} else {


    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    $qty_sold = 0;
    $status = 1;

    if (empty($ratings)) {
        $ratings = 0;
    }
    
    if (empty($qty)) {
        $qty = 10000;
    }

    if (empty($discount)) {
        $discount = 0;
    }

    if (empty($redate)) {
        $redate = "2024-01-01 00:00:00";
    }

    if (empty($runtime)) {
        $runtime = "TBA";
    }

    Database::iud("INSERT INTO `product` (`title`,`description`,`imdb_rating`,`qty_available`,`qty_sold`,`price`,`discount_percentage`,`datetime_added`,
    `released_date`,`runtime`,`type_type_id`,`category_category_id`,`language_language_id`,`availability_availability_id`,`status_status_id`) VALUES 
    ('" . $title . "','" . $desc . "','" . $ratings . "','" . $qty . "','" . $qty_sold . "','" . $cost . "','".$discount."','" . $date . "',
    '" . $redate . "','" . $runtime . "','" . $type . "','" . $category . "','" . $language . "','" . $availability . "','" . $status . "')");

    $product_id = Database::$connection->insert_id;

    if (!empty($trailer)) {
        Database::iud("INSERT INTO `trailer` (`trailer_link`,`product_id`) VALUES ('" . $trailer . "','" . $product_id . "')");
    }

    echo ("Product successfully added.");

    $length = sizeof($_FILES);

    if ($length <= 3 && $length > 0) {

        $allowed_image_extensions = array("image/jpeg", "image/png", "image/svg+xml");

        for ($x = 0; $x < $length; $x++) {
            if (isset($_FILES["image" . $x])) {

                $image_file = $_FILES["image" . $x];
                $file_extension = $image_file["type"];

                if (in_array($file_extension, $allowed_image_extensions)) {

                    $new_img_extension;

                    if ($file_extension == "image/jpeg") {
                        $new_img_extension = ".jpeg";
                    } else if ($file_extension == "image/png") {
                        $new_img_extension = ".png";
                    } else if ($file_extension == "image/svg+xml") {
                        $new_img_extension = ".svg";
                    }

                    $file_name = "resource//product_images//" . $title . "_" . $x . "_" . uniqid() . $new_img_extension;
                    move_uploaded_file($image_file["tmp_name"], $file_name);

                    Database::iud("INSERT INTO `product_img` (`img_path`,`product_id`) VALUES 
                    ('" . $file_name . "','" . $product_id . "')");
                } else {
                    echo ("Invalid image type.");
                }
            }
        }

    } else {
        echo ("Invalid Image Count.");
    }
}

?>