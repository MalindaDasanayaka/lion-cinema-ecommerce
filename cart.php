<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cart | Lion Cinema</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resource/logos/logo1.png" />

</head>

<body>

    <div class="container-fluid bg-secondary">
        <div class="row">

            <?php include "header.php";

            include "connection.php";

            if (isset($_SESSION["u"])) {

                $user = $_SESSION["u"]["email"];

                $cart_rs = Database::search("SELECT * FROM `cart` INNER JOIN `product` ON
                cart.product_id=product.id INNER JOIN `type` ON 
                product.type_type_id=type.type_id INNER JOIN `category` ON 
                product.category_category_id=category.category_id INNER JOIN `language` ON 
                product.language_language_id=language.language_id WHERE cart.user_email='" . $user . "' ORDER BY `cart_id` DESC");

                $cart_num = $cart_rs->num_rows;

                $total = 0;
                $subtotal = 0;
                $delivery = 0;

            ?>

                <div class="col-12 pt-2" style="background-color: gainsboro;">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Cart</li>
                        </ol>
                    </nav>
                </div>

                <div class="col-12">
                    <div class="row">

                        <div class="col-12 text-center">
                            <label class="form-label fs-1 fw-bold text-black">Cart <i class="bi bi-cart4 fs-1"></i></label>
                        </div>

                        <div class="col-12 bg-black mb-3">
                            <div class="row">
                                <div class="offset-sm-2 col-12 col-sm-6 mb-3 mt-3">
                                    <input type="text" class="form-control bg-light" placeholder="Search in Cart..." id="cart_search" />
                                </div>
                                <div class="col-12 col-sm-2 mb-3 mt-3 d-grid">
                                    <button class="btn btn-warning fw-bold" onclick="cartSearch();"><i class="bi bi-search"></i>&nbsp;Search</button>
                                </div>
                            </div>
                        </div>

                        <?php

                        if ($cart_num == 0) {
                        ?>
                            <!-- Empty View -->
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 defaultCart"></div>
                                    <div class="col-12 text-center mb-2">
                                        <label class="form-label fs-1 fw-bold">
                                            You have no items in your Cart yet.
                                        </label>
                                    </div>
                                    <div class="offset-lg-4 col-12 col-lg-4 mb-4 d-grid">
                                        <a href="index.php" class="btn fs-3 fw-bold border border-1 border-dark" style="background-color: orange;">
                                            Start Shopping
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- Empty View -->
                        <?php
                        } else {
                        ?>
                            <!-- products -->
                            <div class="col-12 col-lg-9" id="cartSearchResults">
                                <div class="col-12 px-4 py-2">
                                    <div class="row">

                                        <?php

                                        for ($x = 0; $x < $cart_num; $x++) {
                                            $cart_data = $cart_rs->fetch_assoc();

                                            $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $cart_data["product_id"] . "'");
                                            $img_data = $img_rs->fetch_assoc();

                                            $total = $total + ($cart_data["price"] * $cart_data["cart_qty"]);

                                            $delivery_rs = Database::search("SELECT * FROM `user_has_address` INNER JOIN `district` ON 
                                            user_has_address.district_district_id=district.district_id WHERE `user_email`='" . $user . "'");
                                            $delivery_num = $delivery_rs->num_rows;

                                            if ($delivery_num == 0) {
                                            } else {
                                                $delivery_data = $delivery_rs->fetch_assoc();

                                                if ($cart_data["cart_qty"] > 5) {
                                                    $delivery = 0;
                                                } else {
                                                    $delivery = $delivery_data["delivery_cost"];
                                                }
                                            }

                                        ?>

                                            <div class="card mx-0 col-12 border border-1 border-dark bg-light">
                                                <div class="row g-0">
                                                    <div class="col-md-12 mt-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <span class="fs-5">Delivered Before :</span>&nbsp;

                                                                <?php
                                                                $d = new DateTime();
                                                                $tz = new DateTimeZone("Asia/Colombo");
                                                                $d->setTimezone($tz);

                                                                $d->modify("+8 days");
                                                                $delivery_date = $d->format("Y-m-d");

                                                                if ($cart_data["availability_availability_id"] == 1) {
                                                                ?>
                                                                    <span class="fw-bold fs-5"><?php echo $delivery_date; ?></span>&nbsp;
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <span class="fw-bold fs-5 text-danger">7 days after Release</span>&nbsp;
                                                                <?php
                                                                }
                                                                ?>


                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr />

                                                    <div class="col-md-4">

                                                        <span class="d-inline-block mb-3 px-3" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="<?php echo $cart_data["description"]; ?>" title="Overview">
                                                            <img src="<?php echo $img_data["img_path"]; ?>" class="img-fluid rounded" style="max-width: 200px; cursor: pointer;" onclick='singleProductViewHome(<?php echo $cart_data["id"]; ?>);'>
                                                        </span>

                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="card-body">
                                                            <h5 class="card-title fs-3 fw-bold text-primary"><?php echo $cart_data["title"]; ?></h5>
                                                            <br />
                                                            <span class="fs-5">Type :</span>&nbsp;&nbsp;
                                                            <span class="fs-5 fw-bold"><?php echo $cart_data["type"]; ?></span>
                                                            <br />
                                                            <span class="fs-5">Category :</span>&nbsp;&nbsp;
                                                            <span class="fs-5 fw-bold"><?php echo $cart_data["category_name"]; ?></span>
                                                            <br />
                                                            <span class="fs-5">Language :</span>&nbsp;&nbsp;
                                                            <span class="fs-5 fw-bold"><?php echo $cart_data["language_name"]; ?></span>
                                                            <br />
                                                            <span class="fs-5">IMDb Ratings :</span>&nbsp;&nbsp;
                                                            <?php
                                                            if ($cart_data["availability_availability_id"] == 1) {
                                                            ?>
                                                                <span class="fs-5 fw-bold"><i class="bi bi-star-fill text-warning"></i>&nbsp;<?php echo $cart_data["imdb_rating"]; ?><span class="text-black-50 fs-5"> / 10</span></span>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <span class="fs-5 fw-bold text-danger">TBA</span>
                                                            <?php
                                                            }
                                                            ?>

                                                            <br />

                                                            <?php

                                                            if ($cart_data["availability_availability_id"] == 1) {

                                                            ?>
                                                                <div class="border border-1 border-dark rounded overflow-hidden float-left mt-3 position-relative product-qty bg-white">
                                                                    <div class="col-12">
                                                                        <span class="fs-5">Quantity : </span>
                                                                        <input onkeyup='check_value_cart(<?php echo $cart_data["cart_id"]; ?>,<?php echo $cart_data["qty_available"]; ?>);' type="text" class="border-0 fs-5 fw-bold text-start" style="outline: none;" pattern="[0-9]" value="<?php echo $cart_data["cart_qty"]; ?>" onchange="changeQTY(<?php echo $cart_data['cart_id']; ?>);" id="qty_input_<?php echo $cart_data['cart_id']; ?>" />

                                                                        <div class="position-absolute qty-buttons">
                                                                            <div class="justify-content-center d-flex flex-column align-items-center border border-1 border-secondary qty-inc" onclick="changeQTY(<?php echo $cart_data['cart_id']; ?>);">
                                                                                <i class="bi bi-caret-up-fill text-primary fs-5" onclick='cart_qty_inc(<?php echo $cart_data["cart_id"]; ?>,<?php echo $cart_data["qty_available"]; ?>);'></i>
                                                                            </div>
                                                                            <div class="justify-content-center d-flex flex-column align-items-center border border-1 border-secondary qty-dec" onclick="changeQTY(<?php echo $cart_data['cart_id']; ?>);">
                                                                                <i class="bi bi-caret-down-fill text-primary fs-5" onclick='cart_qty_dec(<?php echo $cart_data["cart_id"]; ?>);'></i>
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
                                                                        <input onkeyup='check_value_cart_cs(<?php echo $cart_data["cart_id"]; ?>);' type="text" class="border-0 fs-5 fw-bold text-start" style="outline: none;" pattern="[0-9]" value="<?php echo $cart_data["cart_qty"]; ?>" onchange="changeQTY(<?php echo $cart_data['cart_id']; ?>);" id="qty_input_<?php echo $cart_data['cart_id']; ?>" />

                                                                        <div class="position-absolute qty-buttons">
                                                                            <div class="justify-content-center d-flex flex-column align-items-center border border-1 border-secondary qty-inc">
                                                                                <i class="bi bi-caret-up-fill text-primary fs-5" onclick='cart_qty_inc_cs(<?php echo $cart_data["cart_id"]; ?>); changeQTY(<?php echo $cart_data["cart_id"]; ?>);'></i>
                                                                            </div>
                                                                            <div class="justify-content-center d-flex flex-column align-items-center border border-1 border-secondary qty-dec">
                                                                                <i class="bi bi-caret-down-fill text-primary fs-5" onclick='cart_qty_dec(<?php echo $cart_data["cart_id"]; ?>); changeQTY(<?php echo $cart_data["cart_id"]; ?>);'></i>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            <?php
                                                            }

                                                            ?>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="card-body d-grid">

                                                            <?php

                                                            if (isset($_SESSION["u"])) {

                                                                $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `user_email`='" . $_SESSION["u"]["email"] . "' AND
                                                                `product_id`='" . $cart_data["id"] . "'");
                                                                $watchlist_num = $watchlist_rs->num_rows;

                                                                if ($watchlist_num == 1) {
                                                            ?>
                                                                    <button class="col-12 btn mb-3" style="background-color: wheat;" onclick='addToWatchlist(<?php echo $cart_data["id"]; ?>);'>
                                                                        <i class="bi bi-heart-fill text-danger" id="heart<?php echo $cart_data["id"]; ?>"></i>
                                                                    </button>
                                                                <?php

                                                                } else {
                                                                ?>
                                                                    <button class="col-12 btn mb-3" style="background-color: wheat;" onclick='addToWatchlist(<?php echo $cart_data["id"]; ?>);'>
                                                                        <i class="bi bi-heart-fill text-dark" id="heart<?php echo $cart_data["id"]; ?>"></i>
                                                                    </button>
                                                            <?php

                                                                }
                                                            }

                                                            ?>
                                                            <a class="btn btn-danger mb-2" onclick='deleteFromCart(<?php echo $cart_data["cart_id"]; ?>);'>Remove</a>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="col-md-12 mt-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-6 col-md-6">
                                                                <span class="fs-5">Requested Total <i class="bi bi-info-circle"></i></span>
                                                            </div>
                                                            <div class="col-6 col-md-6 text-end">
                                                                <span class="fw-bold fs-5">Rs. <?php echo ($cart_data["price"] * $cart_data["cart_qty"]); ?> .00</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php

                                        }

                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- products -->


                            <div class="col-12 col-lg-3">

                                <!-- billing details -->
                                <div class="col-12 px-4 py-4 py-lg-2">
                                    <div class="row">

                                        <div class="card mx-0 col-12 border border-1 border-dark" style="background-color: wheat;">
                                            <div class="row g-0">

                                                <?php

                                                $address_rs = Database::search("SELECT * FROM `user` INNER JOIN `user_has_address` ON 
                                                user.email=user_has_address.user_email INNER JOIN `district` ON 
                                                user_has_address.district_district_id=district.district_id INNER JOIN `province` ON 
                                                district.province_province_id=province.province_id WHERE `user_email`='" . $user . "'");

                                                $address_num = $address_rs->num_rows;

                                                if ($address_num == 0) {
                                                ?>
                                                    <div class="col-12 mt-3">
                                                        <span class="fs-5">Please Update Your User Profile</span>
                                                    </div>
                                                    <div class="col-12 mt-3 mb-3 d-grid">
                                                        <a href="userProfile.php" class="btn btn-info fw-bold">Edit Details</a>
                                                    </div>
                                                <?php

                                                } else {
                                                    $address_data = $address_rs->fetch_assoc();
                                                ?>
                                                    <div class="col-12 mt-3">
                                                        <span class="fs-5">Deliver to :</span>&nbsp;
                                                        <span class="fw-bold fs-5"><?php echo $address_data["fname"]; ?> <?php echo $address_data["lname"]; ?></span>&nbsp;
                                                    </div>

                                                    <div class="col-12">
                                                        <hr />
                                                    </div>

                                                    <div class="col-12">
                                                        <span class="fs-6 fw-bold"><?php echo $address_data["line1"]; ?>,</span>
                                                    </div>

                                                    <div class="col-12">
                                                        <span class="fs-6 fw-bold"><?php echo $address_data["line2"]; ?>,</span>
                                                    </div>

                                                    <div class="col-12">
                                                        <span class="fs-6 fw-bold"><?php echo $address_data["city"]; ?>,</span>
                                                    </div>

                                                    <div class="col-12">
                                                        <span class="fs-6 fw-bold"><?php echo $address_data["district_name"]; ?>,</span>
                                                    </div>

                                                    <div class="col-12">
                                                        <span class="fs-6 fw-bold"><?php echo $address_data["province_name"]; ?>.</span>
                                                    </div>

                                                    <div class="col-12">
                                                        <span class="fs-6 fw-bold"><?php echo $address_data["postal_code"]; ?></span>
                                                    </div>

                                                    <div class="col-12">
                                                        <hr />
                                                    </div>

                                                    <div class="col-12 mb-3">
                                                        <span>Contact No :</span>&nbsp;
                                                        <span class="fw-bold"><?php echo $address_data["mobile"]; ?></span><br />
                                                        <span>Email :</span>&nbsp;
                                                        <span class="fw-bold"><?php echo $address_data["email"]; ?></span>
                                                    </div>

                                                    <div class="col-12 mt-3 mb-3 d-grid">
                                                        <a href="userProfile.php" class="btn btn-info fw-bold">Edit Details</a>
                                                    </div>

                                                <?php
                                                }
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- billing details -->

                                <!-- summary -->
                                <div class="col-12 p-4">
                                    <div class="row">

                                        <div class="card mb-3 mx-0 col-12 border border-1 border-dark" style="background-color: gainsboro;">
                                            <div class="row g-0">

                                                <div class="col-12">
                                                    <label class="form-label fs-3 fw-bold">Summary</label>
                                                </div>

                                                <div class="col-12">
                                                    <hr />
                                                </div>

                                                <div class="col-6 mb-3">
                                                    <span class="fs-6 fw-bold">items (<?php echo $cart_num; ?>)</span>
                                                </div>

                                                <?php
                                                if ($address_num == 0) {
                                                ?>
                                                    <div class="col-12">
                                                        <label class="form-label fs-5">Please Update Your User Profile</label>
                                                    </div>
                                                <?php
                                                } else {
                                                ?>
                                                    <div class="col-6 text-end mb-3">
                                                        <span class="fs-6 fw-bold">Rs. <?php echo $total; ?> .00</span>
                                                    </div>

                                                    <?php

                                                    $cqty_tot_rs = Database::search("SELECT SUM(`cart_qty`) AS total_qty FROM `cart` WHERE `user_email`='" . $user . "'");
                                                    $cqty_tot_data = $cqty_tot_rs->fetch_assoc();
                                                    $cqty_total = (int)$cqty_tot_data['total_qty'];

                                                    if ($cqty_total > 5) {
                                                        $deliver = 0;
                                                        $delivery = 0;
                                                    } else {
                                                        $deliver = $delivery_data["delivery_cost"];
                                                    }

                                                    ?>

                                                    <div class="col-6">
                                                        <span class="fs-6 fw-bold">Delivery</span>
                                                    </div>

                                                    <div class="col-6 text-end">
                                                        <span class="fs-6 fw-bold">Rs. <?php echo $deliver; ?> .00</span>
                                                    </div>

                                                    <div class="col-12 mt-3">
                                                        <hr />
                                                    </div>

                                                    <div class="col-6 mt-2">
                                                        <span class="fs-4 fw-bold">Total</span>
                                                    </div>

                                                    <div class="col-6 mt-2 text-end">
                                                        <span class="fs-4 fw-bold">Rs. <?php echo $total + $deliver; ?> .00</span>
                                                    </div>

                                                    <div class="col-12 mt-3 mb-3 d-grid">
                                                        <button class="btn fs-5 fw-bold" style="background-color: rgb(255, 132, 0);" onclick="checkOut();">CHECKOUT</button>
                                                    </div>

                                                <?php
                                                }
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- summary -->

                            </div>

                        <?php
                        }

                        ?>

                    </div>
                </div>

            <?php

            } else {
            ?>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    Swal.fire({
                        icon: 'info',
                        title: 'Please Login or Sign Up',
                        text: 'To view the Cart, you need to Login or Sign up.',
                        confirmButtonText: 'OK',
                        allowOutsideClick: false, 
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed || result.isDismissed) {
                            window.location = "signin.php";
                        }
                    });
                </script>
            <?php
            }

            ?>

            <?php include "footer.php"; ?>

        </div>
    </div>


    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>

    <script>
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })
    </script>
</body>

</html>