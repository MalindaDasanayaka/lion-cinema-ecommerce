<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Watchlist | Lion Cinema</title>

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

                $watchlist_rs = Database::search("SELECT * FROM `watchlist` INNER JOIN `product` ON
                watchlist.product_id=product.id INNER JOIN `type` ON 
                product.type_type_id=type.type_id INNER JOIN `category` ON 
                product.category_category_id=category.category_id INNER JOIN `language` ON 
                product.language_language_id=language.language_id WHERE watchlist.user_email='" . $user . "' ORDER BY `watchlist_id` DESC");

                $watchlist_num = $watchlist_rs->num_rows;

            ?>

                <div class="col-12 pt-2" style="background-color: gainsboro;">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Watchlist</li>
                        </ol>
                    </nav>
                </div>

                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">

                                <div class="col-12 text-center">
                                    <label class="form-label fs-1 fw-bold text-black">Watchlist <i class="bi bi-suit-heart-fill fs-1"></i></label>
                                </div>

                                <div class="col-12 bg-black mb-3">
                                    <div class="row">
                                        <div class="offset-sm-2 col-12 col-sm-6 mt-3 mb-3">
                                            <input type="text" class="form-control bg-light" placeholder="Search in Watchlist..." id="watchlist_search" />
                                        </div>
                                        <div class="col-12 col-sm-2 mt-3 mb-3 d-grid">
                                            <button class="btn btn-warning fw-bold" onclick="watchlistSearch();"><i class="bi bi-search"></i>&nbsp;Search</button>
                                        </div>
                                    </div>
                                </div>

                                <?php

                                if ($watchlist_num == 0) {
                                ?>
                                    <!-- empty view -->
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12 defaultWatchlist mt-3 mb-3"></div>
                                            <div class="col-12 text-center">
                                                <label class="form-label fs-1 fw-bold">You have no items in your Watchlist yet.</label>
                                            </div>
                                            <div class="offset-lg-4 col-12 col-lg-4 d-grid mb-3">
                                                <a href="index.php" class="btn fs-3 fw-bold border border-1 border-dark" style="background-color: orange;">Start Shopping</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- empty view -->

                                <?php
                                } else {

                                ?>
                                    <!-- products -->
                                    <div class="offset-2 col-8" id="watchlistSearchResults">
                                        <div class="row">

                                            <?php

                                            for ($x = 0; $x < $watchlist_num; $x++) {
                                                $watchlist_data = $watchlist_rs->fetch_assoc();
                                                $list_id = $watchlist_data["watchlist_id"];
                                            ?>

                                                <div class="card mb-3 mx-0 col-12 border border-1 border-dark bg-light">
                                                    <div class="row g-0">
                                                        <div class="col-md-3 py-2">

                                                            <?php

                                                            $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $watchlist_data["product_id"] . "'");
                                                            $img_data = $img_rs->fetch_assoc();

                                                            ?>

                                                            <img src="<?php echo $img_data["img_path"]; ?>" class="img-fluid rounded" style="height: 270px; cursor:pointer" onclick='singleProductViewHome(<?php echo $watchlist_data["id"]; ?>);' />
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="card-body">
                                                                <h5 class="card-title fs-2 fw-bold text-primary"><?php echo $watchlist_data["title"]; ?></h5>
                                                                <br />
                                                                <span class="fs-5">Type :</span>&nbsp;&nbsp;
                                                                <span class="fs-5 fw-bold"><?php echo $watchlist_data["type"]; ?></span>
                                                                <br />
                                                                <span class="fs-5">Category :</span>&nbsp;&nbsp;
                                                                <span class="fs-5 fw-bold"><?php echo $watchlist_data["category_name"]; ?></span>
                                                                <br />
                                                                <span class="fs-5">Language :</span>&nbsp;&nbsp;
                                                                <span class="fs-5 fw-bold"><?php echo $watchlist_data["language_name"]; ?></span>
                                                                <br />

                                                                <?php
                                                                if ($watchlist_data["availability_availability_id"] == 1) {
                                                                ?>
                                                                    <span class="fs-5">IMDb Ratings :</span>&nbsp;&nbsp;
                                                                    <span class="fs-5 fw-bold"><i class="bi bi-star-fill text-warning"></i>&nbsp;<?php echo $watchlist_data["imdb_rating"]; ?><span class="text-black-50 fs-5"> / 10</span></span>
                                                                    <br />
                                                                    <span class="fs-5">Price :</span>&nbsp;&nbsp;
                                                                    <span class="fs-5 fw-bold">Rs. <?php echo $watchlist_data["price"]; ?> .00</span>
                                                                    <br />
                                                                    <?php
                                                                    if ($watchlist_data["qty_available"] > 0) {
                                                                    ?>
                                                                        <span class="fs-5">Quantity :</span>&nbsp;&nbsp;
                                                                        <span class="fs-5 fw-bold text-success"><?php echo $watchlist_data["qty_available"]; ?> Copies Available</span>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <span class="fs-5">Quantity :</span>&nbsp;&nbsp;
                                                                        <span class="fs-5 fw-bold text-danger">No Copies Available</span>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <span class="fs-5">IMDb Ratings :</span>&nbsp;&nbsp;
                                                                    <span class="fs-5 fw-bold text-danger">TBA</span>
                                                                    <br />
                                                                    <span class="fs-5">Price :</span>&nbsp;&nbsp;
                                                                    <span class="fs-5 fw-bold">Rs. <?php echo $watchlist_data["price"]; ?> .00</span>
                                                                    <br />
                                                                <?php
                                                                }
                                                                ?>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mt-5">
                                                            <div class="card-body d-lg-grid">
                                                                <?php
                                                                if ($watchlist_data["qty_available"] > 0) {
                                                                    if ($watchlist_data["availability_availability_id"] == 1) {
                                                                ?>
                                                                        <button class="btn btn-success mb-2" onclick='singleProductViewHome(<?php echo $watchlist_data["id"]; ?>);'>Buy Now</button>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <button class="btn btn-info mb-2 fw-bold" onclick='singleProductViewHome(<?php echo $watchlist_data["id"]; ?>);'>Pre-Order</button>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <button class="btn btn-dark mb-2" onclick='addToCart(<?php echo $watchlist_data["id"]; ?>);'>Add to Cart</button>
                                                                <?php

                                                                } else if ($watchlist_data["availability_availability_id"] == 2) {

                                                                ?>
                                                                    <button class="btn btn-info mb-2 fw-bold" onclick='singleProductViewHome(<?php echo $watchlist_data["id"]; ?>);'>Pre-Order</button>
                                                                    <button class="btn btn-dark mb-2" onclick='addToCart(<?php echo $watchlist_data["id"]; ?>);'>Add to Cart</button>

                                                                <?php

                                                                } else {
                                                                ?>
                                                                    <button class="btn btn-success mb-2 disabled">Buy Now</button>
                                                                    <button class="btn btn-dark mb-2 disabled">Add to Cart</button>
                                                                <?php
                                                                }
                                                                ?>

                                                                <a href="#" class="btn btn-danger" onclick='removeFromWatchlist(<?php echo $list_id; ?>);'>
                                                                    Remove
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
                                    <!-- products -->
                                <?php

                                }

                                ?>

                            </div>
                        </div>
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
                        text: 'To view the Watchlist, you need to Login or Sign up.',
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
</body>

</html>