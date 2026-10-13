<?php
session_start();
include "connection.php";

if (isset($_SESSION["p"])) {

    $pid = $_SESSION["p"]["id"];

    $title = $_POST["ti"];
    $ratings = $_POST["ra"];
    $qty = $_POST["q"];
    $cost = $_POST["co"];
    $discount = $_POST["di"];
    $redate = $_POST["rd"];
    $runtime = $_POST["rt"];
    $trailer = $_POST["tr"];
    $desc = $_POST["d"];

    if (empty($title)) {
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

        Database::iud("UPDATE `product` SET `title`='" . $title . "',`description`='" . $desc . "',`imdb_rating`='" . $ratings . "',`qty_available`='" . $qty . "',`price`='" . $cost . "',
        `discount_percentage`='".$discount."',`released_date`='" . $redate . "',`runtime`='" . $runtime . "' WHERE `id`='" . $pid . "'");

        if (!empty($trailer)) {
            Database::iud("UPDATE `trailer` SET `trailer_link`='".$trailer."' WHERE `product_id`='" . $pid . "'");
        }
        
        echo ("Product has been Updated.");

        $length = sizeof($_FILES);

        if ($length <= 3 && $length > 0) {

            $allowed_image_extensions = array("image/jpeg", "image/png", "image/svg+xml");

            $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $pid . "'");
            $img_num = $img_rs->num_rows;

            for ($y = 0; $y < $img_num; $y++) {
                $img_data = $img_rs->fetch_assoc();

                unlink($img_data["img_path"]);
                Database::iud("DELETE FROM `product_img` WHERE `product_id`='" . $pid . "'");
            }

            for ($x = 0; $x < $length; $x++) {
                if (isset($_FILES["i" . $x])) {

                    $image_file = $_FILES["i" . $x];
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
                        ('" . $file_name . "','" . $pid . "')");
                    } else {
                        echo ("Invalid image type.");
                    }
                }
            }

        } else {
            echo ("Invalid Image Count.");
        }
    }
}
?>