<?php
include "connection.php";

if (isset($_GET["id"])) {

    $pid = $_GET["id"];

    $product_rs = Database::search("SELECT * FROM `product` INNER JOIN `type` ON 
    product.type_type_id=type.type_id INNER JOIN `category` ON product.category_category_id=category.category_id INNER JOIN `language` ON 
    product.language_language_id=language.language_id WHERE product.id='" . $pid . "'");

    $product_num = $product_rs->num_rows;
    if ($product_num == 1) {

        $product_data = $product_rs->fetch_assoc();

?>

        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <title><?php echo $product_data["title"]; ?> | Lion Cinema</title>

            <link rel="stylesheet" href="bootstrap.css" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
            <link rel="stylesheet" href="style.css" />

            <link rel="icon" href="resource/logos/logo1.png" />
        </head>

        <body>

            <div class="container-fluid">
                <div class="row">
                    <?php include "header.php"; ?>

                    <div class="col-12 pt-2" style="background-color: gainsboro;">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Single Product View</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="col-12 bg-secondary">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">

                                    <!-- image loading -->
                                    <div class="col-12 col-lg-5 p-4">
                                        <div class="row">

                                            <?php
                                            $image_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $pid . "'");
                                            $image_num = $image_rs->num_rows;

                                            if ($image_num != 0) {
                                                $image_data = $image_rs->fetch_assoc();

                                            ?>
                                                <div class="col-12 col-lg-9 align-items-center  d-none d-lg-block">
                                                    <img src="<?php echo $image_data["img_path"]; ?>" class="mainImg" height="100px" id="mainImg" />
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="col-12 col-lg-8 align-items-center  d-none d-lg-block">
                                                    <img src="resource/default_icons/default_image.svg" class="mainImg" id="mainImg" />
                                                </div>
                                            <?php
                                            }
                                            ?>


                                            <div class="col-6 offset-3 offset-lg-0 col-lg-3">
                                                <ul>

                                                    <?php
                                                    $image_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $pid . "'");
                                                    $image_num = $image_rs->num_rows;
                                                    $img = array();

                                                    if ($image_num != 0) {
                                                        for ($x = 0; $x < $image_num; $x++) {
                                                            $image_data = $image_rs->fetch_assoc();
                                                            $img[$x] = $image_data["img_path"];
                                                    ?>

                                                            <li class="d-flex flex-column justify-content-center align-items-center py-1">
                                                                <img src="<?php echo $img[$x]; ?>" class="defaultImg" id="productImg<?php echo $x; ?>" onclick="loadMainImg(<?php echo $x; ?>);" />
                                                            </li>

                                                        <?php
                                                        }
                                                    } else {
                                                        ?>

                                                        <li class="d-flex flex-column justify-content-center align-items-center py-1">
                                                            <img src="resource/default_icons/default_image.svg" class="defaultImg" />
                                                        </li>
                                                        <li class="d-flex flex-column justify-content-center align-items-center py-1">
                                                            <img src="resource/default_icons/default_image.svg" class="defaultImg" />
                                                        </li>
                                                        <li class="d-flex flex-column justify-content-center align-items-center py-1">
                                                            <img src="resource/default_icons/default_image.svg" class="defaultImg" />
                                                        </li>

                                                    <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- image loading -->

                                    <!-- Video Modal -->
                                    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-fullscreen">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-1 fw-bold text-primary" id="exampleModalLabel"><?php echo $product_data["title"]; ?></h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Video -->
                                                    <?php
                                                    $trailer_rs = Database::search("SELECT * From `trailer` WHERE `product_id`='" . $pid . "'");
                                                    $trailer_num = $trailer_rs->num_rows;

                                                    if ($trailer_num == 0) {
                                                    ?>
                                                        <div class="d-flex flex-column justify-content-center text-center mt-5 mb-5">
                                                            <div class="col-12 sadface mb-5"></div>
                                                            <h1 class="fw-bold">We're Sorry</h1>
                                                            <h3>No Trailer is Available for this Product at the Moment</h3>
                                                        </div>
                                                    <?php
                                                    } else {
                                                        $trailer_data = $trailer_rs->fetch_assoc();
                                                    ?>
                                                        <div>
                                                            <iframe src="https://www.youtube.com/embed/<?php echo $trailer_data["trailer_link"]; ?>" allowfullscreen></iframe>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                    <!-- Video -->
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Video Modal -->

                                    <!-- main info -->
                                    <div class="col-12 col-lg-7 p-3 bg-light border border-2 border-dark rounded mt-4">
                                        <div class="row">
                                            <div class="col-12">

                                                <div class="row border-bottom border-dark">
                                                    <div class="col-12 text-center mb-4">
                                                        <span class="fs-1 fw-bold text-primary"><?php echo $product_data["title"]; ?></span>
                                                    </div>
                                                </div>

                                                <?php
                                                if ($product_data["availability_availability_id"] == 1) {
                                                ?>
                                                    <div class="row border-bottom border-dark">
                                                        <div class="col-12 my-2">
                                                            <span>
                                                                <label class="fs-4 text-dark fw-bold">Overall Impression :&nbsp;&nbsp;&nbsp;&nbsp;</label>

                                                                <?php

                                                                $feedback_rs1 = Database::search("SELECT * FROM `feedback` WHERE `product_id`='" . $pid . "'");
                                                                $feedback_num1 = $feedback_rs1->num_rows;

                                                                if ($feedback_num1 != 0) {

                                                                    $positive_rs = Database::search("SELECT COUNT(`type`) AS `positive_count` FROM `feedback` WHERE `type`='1' AND `product_id`='" . $pid . "'");
                                                                    $positive_data = $positive_rs->fetch_assoc();

                                                                    $neutral_rs = Database::search("SELECT COUNT(`type`) `neutral_count` FROM `feedback` WHERE `type`='2' AND `product_id`='" . $pid . "'");
                                                                    $neutral_data = $neutral_rs->fetch_assoc();

                                                                    $negative_rs = Database::search("SELECT COUNT(`type`) `negative_count` FROM `feedback` WHERE `type`='3' AND `product_id`='" . $pid . "'");
                                                                    $negative_data = $negative_rs->fetch_assoc();

                                                                    $positive_count = $positive_data["positive_count"];
                                                                    $neutral_count = $neutral_data["neutral_count"];
                                                                    $negative_count = $negative_data["negative_count"];

                                                                    $positive_score = 1;
                                                                    $neutral_score = 0;
                                                                    $negative_score = -1;

                                                                    $weighted_sum = ($positive_count * $positive_score) + ($neutral_count * $neutral_score) + ($negative_count * $negative_score);

                                                                    if ($weighted_sum > 0) {
                                                                ?>
                                                                        <span class="badge bg-success fs-6">Positive</span>
                                                                    <?php
                                                                    } else if ($weighted_sum < 0) {
                                                                    ?>
                                                                        <span class="badge bg-danger fs-6">Negative</span>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <span class="badge bg-warning text-black fs-6">Neutral</span>
                                                                    <?php

                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <span class="fs-5 text-danger">Not enough Feedbacks</span>
                                                                <?php
                                                                }

                                                                if ($feedback_num1 == 0) {
                                                                ?>
                                                                    <label class="fs-4 text-dark fw-bold">&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;No Feedbacks</label>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <label class="fs-4 text-dark fw-bold">&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo $feedback_num1 ?> Feedbacks</label>
                                                                <?php
                                                                }

                                                                ?>

                                                            </span>
                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                                ?>

                                                <?php
                                                $new_price = $product_data["price"];
                                                $adding_price = ($new_price / 100) * $product_data["discount_percentage"];
                                                $old_price = $new_price + $adding_price;
                                                $difference = $old_price - $new_price;
                                                ?>
                                                <div class="row border-bottom border-dark">
                                                    <div class="col-12 my-2">
                                                        <span class="fs-3 text-danger fw-bold text-decoration-line-through">Rs. <?php echo $old_price; ?> .00</span>
                                                        &nbsp;&nbsp; | &nbsp;&nbsp;
                                                        <span class="fs-3 text-dark fw-bold">Rs. <?php echo $new_price; ?> .00</span>
                                                        &nbsp;&nbsp; | &nbsp;&nbsp;
                                                        <span class="fs-3 fw-bold text-secondary">Save Rs. <?php echo $difference; ?> .00 (<?php echo $product_data["discount_percentage"]; ?>%)</span>
                                                    </div>
                                                </div>

                                                <div class="row border-bottom border-dark">
                                                    <div class="col-12 my-2">
                                                        <span class="fs-5">Return Policy :&nbsp;&nbsp;&nbsp;</span><span class="fs-5 fw-bold">1 Week Return Policy</span><br />

                                                        <?php

                                                        if ($product_data["availability_availability_id"] == 1) {

                                                        ?>
                                                            <span class="fs-5">Availability :&nbsp;&nbsp;&nbsp;</span><span class="badge bg-primary fs-6">Released</span>
                                                        <?php

                                                        } else {

                                                        ?>
                                                            <span class="fs-5">Availability :&nbsp;&nbsp;&nbsp;</span><span class="badge bg-warning fs-6 text-black">Coming Soon</span>
                                                        <?php

                                                        }

                                                        ?>


                                                    </div>
                                                </div>

                                                <?php
                                                if ($product_data["availability_availability_id"] == 1) {
                                                ?>
                                                    <div class="row border-bottom border-dark">
                                                        <div class="col-12 my-2">
                                                            <div class="row">
                                                                <div class="col-12 col-lg-6">

                                                                    <?php
                                                                    if ($product_data["qty_available"] > 0) {
                                                                    ?>
                                                                        <span class="fs-5">Copies Remaining : </span><span class="fs-5 fw-bold"><?php echo $product_data["qty_available"]; ?> Copies</span>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <span class="fs-5">Copies Remaining : </span><span class="fs-5 fw-bold text-danger">No Copies Available</span>
                                                                    <?php
                                                                    }
                                                                    ?>

                                                                </div>
                                                                <div class="col-12 col-lg-6">
                                                                    <span class="fs-5">Copies Sold : </span><span class="fs-5 fw-bold"><?php echo $product_data["qty_sold"]; ?> Copies</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                                ?>

                                                <div class="row border-bottom border-dark">
                                                    <div class="col-12 my-2">

                                                        <?php


                                                        $d = new DateTime();
                                                        $tz = new DateTimeZone("Asia/Colombo");
                                                        $d->setTimezone($tz);

                                                        $d->modify("+8 days");
                                                        $delivery_date = $d->format("Y-m-d");

                                                        if (isset($_SESSION["u"])) {

                                                            $delivery_rs = Database::search("SELECT * FROM `user_has_address` INNER JOIN `district` ON 
                                                                user_has_address.district_district_id=district.district_id WHERE `user_email`='" . $_SESSION["u"]["email"] . "'");

                                                            $delivery_data = $delivery_rs->fetch_assoc();

                                                            if (empty($delivery_data["district_district_id"])) {
                                                        ?>
                                                                <span class="fs-5">Delivery Fee :&nbsp;</span><a href="userProfile.php">
                                                                    Please Enter your Address in My Profile to View Delivery Cost
                                                                </a><br />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <span class="fs-5">Delivery Fee :&nbsp;&nbsp;&nbsp;</span><span class="fs-5 fw-bold">Rs. <?php echo $delivery_data["delivery_cost"]; ?> .00</span><br />
                                                            <?php
                                                            }
                                                        } else {

                                                            ?>
                                                            <span class="fs-5">Delivery Fee :&nbsp;</span><a href="signin.php">
                                                                Please Sign In and Enter your Address in My Profile to View Delivery Cost
                                                            </a><br />
                                                        <?php

                                                        }

                                                        if ($product_data["availability_availability_id"] == 1) {
                                                        ?>
                                                            <span class="fs-5">Delivered Before :&nbsp;&nbsp;&nbsp;</span><span class="fs-5 fw-bold"><?php echo $delivery_date; ?></span><br />
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <span class="text-primary">**Delivered within 7 Days after the Product been Released**</span>
                                                        <?php
                                                        }

                                                        ?>

                                                    </div>
                                                    <div class="my-3 col-12 border border-3 border-warning rounded">
                                                        <div class="row">
                                                            <div class="col-12 text-center">
                                                                <span class="fs-5 text-secondary fw-bold">
                                                                    Buy more than <span class="fs-5 fw-bold text-primary">5</span> items at once to enjoy <span class="fs-5 fw-bold text-success">Free Delivery !!!</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-12 my-2">
                                                                <div class="row g-2">

                                                                    <?php
                                                                    if ($product_data["availability_availability_id"] == 1) {
                                                                    ?>
                                                                        <div class="border border-1 border-dark rounded overflow-hidden float-left mt-3 position-relative product-qty bg-white">
                                                                            <div class="col-12">
                                                                                <span class="fs-5">Quantity : </span>
                                                                                <input onkeyup='check_value(<?php echo $product_data["qty_available"]; ?>);' type="text" class="border-0 fs-5 fw-bold text-start" style="outline: none;" pattern="[0-9]" value="1" id="qty_input" />

                                                                                <div class="position-absolute qty-buttons">
                                                                                    <div class="justify-content-center d-flex flex-column align-items-center border border-1 border-secondary qty-inc">
                                                                                        <i class="bi bi-caret-up-fill text-primary fs-5" onclick='qty_inc(<?php echo $product_data["qty_available"]; ?>);'></i>
                                                                                    </div>
                                                                                    <div class="justify-content-center d-flex flex-column align-items-center border border-1 border-secondary qty-dec">
                                                                                        <i class="bi bi-caret-down-fill text-primary fs-5" onclick='qty_dec();'></i>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <div class="border border-1 border-dark rounded overflow-hidden float-left mt-3 position-relative product-qty bg-white">
                                                                            <div class="col-12">
                                                                                <span class="fs-5">Quantity : </span>
                                                                                <input onkeyup='check_value_cs();' type="text" class="border-0 fs-5 fw-bold text-start" style="outline: none;" pattern="[0-9]" value="1" id="qty_input" />

                                                                                <div class="position-absolute qty-buttons">
                                                                                    <div class="justify-content-center d-flex flex-column align-items-center border border-1 border-secondary qty-inc">
                                                                                        <i class="bi bi-caret-up-fill text-primary fs-5" onclick='qty_inc_cs();'></i>
                                                                                    </div>
                                                                                    <div class="justify-content-center d-flex flex-column align-items-center border border-1 border-secondary qty-dec">
                                                                                        <i class="bi bi-caret-down-fill text-primary fs-5" onclick='qty_dec();'></i>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <div class="row justify-content-center mt-5">
                                                                        <button type="button" class="btn btn-danger col-3 fs-5" data-bs-toggle="modal" data-bs-target="#videoModal">
                                                                            <i class="bi bi-youtube fs-5"></i> Watch Trailer
                                                                        </button>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-12 mt-5">
                                                                            <div class="row">
                                                                                <?php
                                                                                if ($product_data["qty_available"] > 0) {
                                                                                    if ($product_data["availability_availability_id"] == 1) {

                                                                                ?>
                                                                                        <div class="col-4 d-grid">
                                                                                            <button class="btn btn-success fs-5" type="submit" id="payhere-payment" onclick="buyNow(<?php echo $pid; ?>);">Buy Now</button>
                                                                                        </div>
                                                                                    <?php

                                                                                    } else {

                                                                                    ?>
                                                                                        <div class="col-4 d-grid">
                                                                                            <button class="btn btn-info fs-5 fw-bold" type="submit" id="payhere-payment" onclick="buyNow(<?php echo $pid; ?>);">Pre-Order</button>
                                                                                        </div>
                                                                                    <?php

                                                                                    }
                                                                                    ?>

                                                                                    <div class="col-4 d-grid">
                                                                                        <button class="btn btn-dark fs-5" onclick='addToCartFromSPV(<?php echo $product_data["id"]; ?>);'>Add To Cart</button>
                                                                                    </div>
                                                                                <?php
                                                                                } else if ($product_data["availability_availability_id"] == 2) {

                                                                                ?>
                                                                                    <div class="col-4 d-grid">
                                                                                        <button class="btn btn-info fs-5 fw-bold" type="submit" id="payhere-payment" onclick="payNow(<?php echo $pid; ?>);">Pre-Order</button>
                                                                                    </div>
                                                                                    <div class="col-4 d-grid">
                                                                                        <button class="btn btn-dark fs-5" onclick='addToCartFromSPV(<?php echo $product_data["id"]; ?>);'>Add To Cart</button>
                                                                                    </div>
                                                                                <?php

                                                                                } else {
                                                                                ?>
                                                                                    <div class="col-4 d-grid">
                                                                                        <button class="btn btn-success fs-5 disabled">Buy Now</button>
                                                                                    </div>
                                                                                    <div class="col-4 d-grid">
                                                                                        <button class="btn btn-dark fs-5 disabled">Add To Cart</button>
                                                                                    </div>
                                                                                <?php
                                                                                }
                                                                                ?>

                                                                                <div class="col-4 d-grid">
                                                                                    <?php
                                                                                    if (isset($_SESSION["u"])) {

                                                                                        $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `user_email`='" . $_SESSION["u"]["email"] . "' AND
                                                                                                `product_id`='" . $product_data["id"] . "'");
                                                                                        $watchlist_num = $watchlist_rs->num_rows;

                                                                                        if ($watchlist_num == 1) {
                                                                                    ?>
                                                                                            <button class="btn" style="background-color: wheat;" onclick='addToWatchlist(<?php echo $product_data["id"]; ?>);'>
                                                                                                <i class="bi bi-heart-fill fs-5 text-danger" id="heart<?php echo $product_data["id"]; ?>"></i>
                                                                                            </button>
                                                                                        <?php

                                                                                        } else {
                                                                                        ?>
                                                                                            <button class="btn" style="background-color: wheat;" onclick='addToWatchlist(<?php echo $product_data["id"]; ?>);'>
                                                                                                <i class="bi bi-heart-fill fs-5 text-dark" id="heart<?php echo $product_data["id"]; ?>"></i>
                                                                                            </button>
                                                                                    <?php

                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- main info -->
                                </div>

                                <!-- related items -->
                                <div class="col-12">
                                    <div class="row d-block mt-4 mb-3 border-bottom border-2 border-dark">
                                        <div class="col-12">
                                            <span class="fs-3 fw-bold text-black">Related Items</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row justify-content-center gap-1">

                                        <?php

                                        $related_rs = Database::search("SELECT * FROM `product` INNER JOIN `type` ON 
                                        product.type_type_id=type.type_id INNER JOIN `language` ON 
                                        product.language_language_id=language.language_id WHERE
                                        `category_category_id`='" . $product_data["category_category_id"] . "' 
                                        AND `type_type_id`='" . $product_data["type_type_id"] . "' AND `availability_availability_id`='1' 
                                        AND `status_status_id`='1' LIMIT 3");

                                        $related_num = $related_rs->num_rows;
                                        for ($y = 0; $y < $related_num; $y++) {
                                            $related_data = $related_rs->fetch_assoc();
                                        ?>

                                            <div class="card bg-light mt-1 mb-1" style="max-width: 450px; ">
                                                <div class="row g-0">
                                                    <div class="col-4 py-2">

                                                        <?php
                                                        $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $related_data["id"] . "'");
                                                        $img_data = $img_rs->fetch_assoc();
                                                        ?>

                                                        <img src="<?php echo $img_data["img_path"]; ?>" class="img-fluid" style="cursor:pointer" onclick='singleProductViewHome(<?php echo $related_data["id"]; ?>);' />
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="card-body text-center">
                                                            <h5 class="card-title text-primary fw-bold fs-5"><?php echo $related_data["title"]; ?></h5>
                                                            <span class="fw-bold"><?php echo $related_data["type"]; ?> - <?php echo $related_data["language_name"]; ?></span><br />
                                                            <span class="fw-bold"><i class="bi bi-star-fill text-warning"></i>&nbsp;<?php echo $related_data["imdb_rating"]; ?><span class="text-black-50"> / 10</span></span><br />
                                                            <span class="fw-bold">Rs. <?php echo $related_data["price"]; ?> .00</span><br />

                                                            <?php
                                                            if ($related_data["qty_available"] > 0) {

                                                            ?>
                                                                <span class="fw-bold text-success"><?php echo $related_data["qty_available"]; ?> Copies Available</span><br /><br>

                                                            <?php

                                                            } else {
                                                            ?>
                                                                <span class="card-text text-danger fw-bold">No Copies Available</span><br /><br />

                                                            <?php
                                                            }

                                                            ?>

                                                            <a href='<?php echo "singleProductView.php?id=" . ($related_data["id"]); ?>' class="col-12 btn btn-primary">
                                                                See the Product
                                                            </a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php
                                        }

                                        ?>

                                    </div>
                                </div>
                                <!-- related items -->

                                <div class="col-12">
                                    <div class="row g-2">

                                        <!-- product details -->
                                        <div class="col-12 col-lg-6 bg-light mt-4 mb-4 border border-dark rounded">
                                            <div class="row p-3">
                                                <div class="col-12">
                                                    <div class="row d-block mt-4 mb-3 border-bottom border-1 border-dark">
                                                        <div class="col-12">
                                                            <span class="fs-3 fw-bold">Product Details</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="row">
                                                        <span class="fs-4">Type : <span class="fs-4 fw-bold"><?php echo $product_data["type"]; ?></span></span>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="row">
                                                        <span class="fs-4">Category : <span class="fs-4 fw-bold"><?php echo $product_data["category_name"]; ?></span></span>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="row">
                                                        <span class="fs-4">Language : <span class="fs-4 fw-bold"><?php echo $product_data["language_name"]; ?></span></span>
                                                    </div>
                                                </div>

                                                <?php
                                                if ($product_data["availability_availability_id"] == 1) {
                                                ?>
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <span class="fs-4">IMDb Ratings : <span class="fs-4 fw-bold"><i class="bi bi-star-fill text-warning"></i>&nbsp;<?php echo $product_data["imdb_rating"]; ?><span class="text-black-50 fs-4"> / 10</span></span></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="row">
                                                            <span class="fs-4">Released Date : <span class="fs-4 fw-bold"><?php echo $product_data["released_date"]; ?></span></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="row">
                                                            <span class="fs-4">Runtime : <span class="fs-4 fw-bold"><?php echo $product_data["runtime"]; ?></span></span>
                                                        </div>
                                                    </div>

                                                    <div class="my-3 col-12">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <span class="fs-5 text-primary fw-bold">
                                                                    **All items are available in both English and Sinhala Subtitles**</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                } else {
                                                ?>
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <span class="fs-4">IMDb Ratings : <span class="text-danger fs-4 fw-bold">TBA</span></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="row">
                                                            <span class="fs-4">Released Date : <span class="text-danger fs-4 fw-bold">TBA</span></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="row">
                                                            <span class="fs-4">Runtime : <span class="text-danger fs-4 fw-bold">TBA</span></span>
                                                        </div>
                                                    </div>

                                                    <div class="my-3 col-12">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <span class="fs-5 text-primary fw-bold">
                                                                    **The item will be available in both English and Sinhala Subtitles**</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                                ?>

                                                <div class="col-12 mt-2">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="form-label fs-4 fw-bold">Overview : </label>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <textarea cols="60" rows="10" class="form-control" readonly><?php echo $product_data["description"]; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- product details -->

                                        <!-- feedbacks -->
                                        <div class="col-12 col-lg-6 bg-light mt-4 mb-4 border border-dark rounded ">
                                            <div class="col-12 p-3">
                                                <div class="row d-block me-0 mt-4 mb-3 border-bottom border-1 border-dark">
                                                    <div class="col-12">
                                                        <span class="fs-3 fw-bold">Feedbacks</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row border border-1 border-dark rounded overflow-scroll mx-3" style="height: 480px;">

                                                <?php

                                                $feedback_rs = Database::search("SELECT * FROM `feedback` INNER JOIN `user` ON
                                                feedback.user_email=user.email WHERE `product_id`='" . $pid . "'");

                                                $feedback_num = $feedback_rs->num_rows;

                                                if ($feedback_num == 0) {

                                                ?>
                                                    <div class="col-12 align-content-center">
                                                        <div class="row">
                                                            <div class="col-12 text-center">
                                                                <label class="form-label fs-1">
                                                                    No Feedbacks Yet...
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php

                                                } else {

                                                    for ($y = 0; $y < $feedback_num; $y++) {
                                                        $feedback_data = $feedback_rs->fetch_assoc();

                                                    ?>
                                                        <div class="col-12 mt-1 mb-1" style="background-color: gainsboro;">
                                                            <div class="row border border-1 border-dark rounded">

                                                                <div class="col-10 mt-1 mb-1 ms-0"><?php echo $feedback_data["fname"] . " " . $feedback_data["lname"]; ?></div>
                                                                <div class="col-2 mt-1 mb-1 me-0">

                                                                    <?php

                                                                    if ($feedback_data["type"] == 1) {
                                                                    ?><span class="badge bg-success">Positive</span><?php
                                                                                                                } else if ($feedback_data["type"] == 2) {
                                                                                                                    ?><span class="badge bg-warning text-black">Neutral</span><?php
                                                                                                                                                                            } else if ($feedback_data["type"] == 3) {
                                                                                                                                                                                ?><span class="badge bg-danger">Negative</span><?php
                                                                                                                                                                                                                            }

                                                                                                                                                                                                                                ?>

                                                                </div>

                                                                <div class="col-12">
                                                                    <b>
                                                                        <?php echo $feedback_data["feed"]; ?>
                                                                    </b>
                                                                </div>
                                                                <div class="offset-6 col-6 text-end">
                                                                    <label class="form-label fs-6 text-black-50"><?php echo $feedback_data["date"]; ?></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }

                                                    ?>

                                                <?php
                                                }

                                                ?>
                                            </div>
                                        </div>
                                        <!-- feedbacks -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include "footer.php"; ?>
                </div>

                <script src="bootstrap.bundle.js"></script>
                <script src="script.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
        </body>

        </html>

<?php

    } else {
        echo ("Sorry for the inconvenience. Please try again later.");
    }
} else {
    echo ("Something Went Wrong");
}

?>