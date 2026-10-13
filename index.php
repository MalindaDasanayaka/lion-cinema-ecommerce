<?php

include "connection.php";

?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Home | Lion Cinema</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resource/logos/logo1.png" />

</head>

<body class="body">

    <div class="container-fluid">
        <div class="row">

            <?php include "header.php"; ?>

            <div class="col-12 justify-content-center bg-black">
                <div class="row mb-2">

                    <div class="col-12 col-sm-6 offset-sm-2">

                        <div class="input-group mt-3 mb-3">
                            <input type="text" class="form-control bg-light" placeholder="Search what you want..." aria-label="Text input with dropdown button" id="basic_search_txt">

                            <select class="form-select bg-light" style="max-width: 250px;" id="basic_search_select">
                                <option value="0">All Categories</option>
                                <?php

                                $category_rs = Database::search("SELECT * FROM `category`");
                                $category_num = $category_rs->num_rows;

                                for ($x = 0; $x < $category_num; $x++) {
                                    $category_data = $category_rs->fetch_assoc();
                                ?>
                                    <option value="<?php echo $category_data["category_id"]; ?>">
                                        <?php echo $category_data["category_name"]; ?>
                                    </option>
                                <?php
                                }

                                ?>
                            </select>

                        </div>

                    </div>

                    <div class="col-12 col-sm-2 d-grid">
                        <button class="btn btn-warning fw-bold mt-3 mb-3" onclick="basicSearch(0);"><i class="bi bi-search"></i>&nbsp;Search</button>
                    </div>

                    <div class="col-12 col-sm-2 mt-2 mt-sm-4 text-center text-sm-start">
                        <a href="advancedSearch.php" class="text-decoration-none fw-bold" style="color: rgb(255, 132, 0);">Filter&nbsp;<i class="bi bi-funnel-fill"></i></a>
                    </div>

                </div>
            </div>

            <div class="col-12 bg-secondary" id="basicSearchResult">
                <div class="row">

                    <!-- Carousel -->

                    <div class="col-12 mb-3 mt-3">
                        <div class="row">

                            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="5" aria-label="Slide 6"></button>
                                </div>

                                <div class="carousel-inner">

                                    <div class="carousel-item active">
                                        <img src="resource/carousal/guardians of the galaxy.jpg" class="d-block w-100" />
                                    </div>

                                    <div class="carousel-item">
                                        <img src="resource/carousal/stranger things.jpg" class="d-block w-100" />
                                    </div>

                                    <div class="carousel-item">
                                        <img src="resource/carousal/harry poter.jpg" class="d-block w-100" />
                                    </div>

                                    <div class="carousel-item">
                                        <img src="resource/carousal/manderlorian.jpg" class="d-block w-100" />
                                    </div>

                                    <div class="carousel-item">
                                        <img src="resource/carousal/lord of the rings.jpg" class="d-block w-100" />
                                    </div>

                                    <div class="carousel-item">
                                        <img src="resource/carousal/game of thrones.jpg" class="d-block w-100" />
                                    </div>

                                </div>

                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>

                            </div>

                        </div>
                    </div>

                    <!-- Carousel -->

                    <!-- Pre Order -->
                    <div class="col-12 mt-3 mb-3">
                        <span class="text-black fs-3 fw-bold">Pre-Order</span>
                        &nbsp;&nbsp;
                        <a href="#" class="text-decoration-none text-black fs-5" onclick="preOrder(0);">See All &nbsp;&rarr;</a>
                    </div>

                    <div class="col-12 mb-3">
                        <div class="row border border-dark">

                            <div class="col-12">
                                <div class="row justify-content-center gap-1">

                                    <?php

                                    $product_rs = Database::search("SELECT * FROM `product` WHERE `availability_availability_id`='2'
                                    AND `status_status_id`='1' ORDER BY `datetime_added` DESC LIMIT 6 OFFSET 0");

                                    $product_num = $product_rs->num_rows;

                                    for ($z = 0; $z < $product_num; $z++) {
                                        $product_data = $product_rs->fetch_assoc();
                                    ?>

                                        <div class="card bg-light mt-1 mb-1" style="max-width: 450px; ">
                                            <div class="row g-0">
                                                <div class="col-4 py-2">

                                                    <?php
                                                    $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $product_data["id"] . "'");
                                                    $img_data = $img_rs->fetch_assoc();
                                                    ?>

                                                    <img src="<?php echo $img_data["img_path"]; ?>" class="img-fluid" style="cursor:pointer" onclick='singleProductViewHome(<?php echo $product_data["id"]; ?>);' />
                                                </div>
                                                <div class="col-8">
                                                    <div class="card-body text-center">
                                                        <h5 class="card-title text-primary fw-bold fs-5"><?php echo $product_data["title"]; ?></h5>
                                                        <span class="badge rounded-pill text-bg-warning">Coming Soon</span><br />

                                                        <?php
                                                        $details_rs = Database::search("SELECT * FROM `product` INNER JOIN `type` ON 
                                                        product.type_type_id=type.type_id INNER JOIN `category` ON product.category_category_id=category.category_id INNER JOIN `language` ON 
                                                        product.language_language_id=language.language_id WHERE `id`='" . $product_data["id"] . "'");
                                                        $details_data = $details_rs->fetch_assoc();

                                                        ?>

                                                        <span class="fw-bold text-danger"><?php echo $details_data["category_name"]; ?></span><br />
                                                        <span class="fw-bold"><?php echo $details_data["type"]; ?> - <?php echo $details_data["language_name"]; ?></span><br />
                                                        <span class="fw-bold text-success">Rs. <?php echo $product_data["price"]; ?> .00</span><br /><br />

                                                        <a href='<?php echo "singleProductView.php?id=" . ($product_data["id"]); ?>' class="col-5 btn btn-info fw-bold">
                                                            Pre-Order
                                                        </a>
                                                        <button class="col-3 btn btn-dark" onclick='addToCart(<?php echo $product_data["id"]; ?>);'>
                                                            <i class="bi bi-cart-plus-fill text-white"></i>
                                                        </button>

                                                        <?php

                                                        if (isset($_SESSION["u"])) {

                                                            $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `user_email`='" . $_SESSION["u"]["email"] . "' AND
                                                            `product_id`='" . $product_data["id"] . "'");
                                                            $watchlist_num = $watchlist_rs->num_rows;

                                                            if ($watchlist_num == 1) {
                                                        ?>
                                                                <button class="col-3 btn" style="background-color: wheat;" onclick='addToWatchlist(<?php echo $product_data["id"]; ?>);'>
                                                                    <i class="bi bi-heart-fill text-danger" id="heart<?php echo $product_data["id"]; ?>"></i>
                                                                </button>
                                                            <?php

                                                            } else {
                                                            ?>
                                                                <button class="col-3 btn" style="background-color: wheat;" onclick='addToWatchlist(<?php echo $product_data["id"]; ?>);'>
                                                                    <i class="bi bi-heart-fill text-dark" id="heart<?php echo $product_data["id"]; ?>"></i>
                                                                </button>
                                                        <?php

                                                            }
                                                        }

                                                        ?>

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
                    </div>
                    <!--  Pre Order -->

                    <!-- New Release -->
                    <div class="col-12 mt-3 mb-3">
                        <span class="text-black fs-3 fw-bold">New Release</span>
                        &nbsp;&nbsp;
                        <a href="#" class="text-decoration-none text-black fs-5" onclick="newRelease(0);">See All &nbsp;&rarr;</a>
                    </div>

                    <div class="col-12 mb-3">
                        <div class="row border border-dark">

                            <div class="col-12">
                                <div class="row justify-content-center gap-1">

                                    <?php

                                    $product_rs1 = Database::search("SELECT * FROM `product` WHERE `availability_availability_id`='1'
                                    AND `status_status_id`='1' ORDER BY `released_date` DESC LIMIT 6 OFFSET 0");

                                    $product_num1 = $product_rs1->num_rows;

                                    for ($z = 0; $z < $product_num1; $z++) {
                                        $product_data1 = $product_rs1->fetch_assoc();
                                    ?>

                                        <div class="card bg-light mt-1 mb-1" style="max-width: 450px; ">
                                            <div class="row g-0">
                                                <div class="col-4 py-2">

                                                    <?php
                                                    $img_rs1 = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $product_data1["id"] . "'");
                                                    $img_data1 = $img_rs1->fetch_assoc();
                                                    ?>

                                                    <img src="<?php echo $img_data1["img_path"]; ?>" class="img-fluid" style="cursor:pointer" onclick='singleProductViewHome(<?php echo $product_data1["id"]; ?>);' />
                                                </div>
                                                <div class="col-8">
                                                    <div class="card-body text-center">
                                                        <h5 class="card-title text-primary fw-bold fs-5"><?php echo $product_data1["title"]; ?></h5>
                                                        <span class="badge rounded-pill text-bg-danger">New</span><br />

                                                        <?php
                                                        $details_rs1 = Database::search("SELECT * FROM `product` INNER JOIN `type` ON 
                                                        product.type_type_id=type.type_id INNER JOIN `category` ON product.category_category_id=category.category_id INNER JOIN `language` ON 
                                                        product.language_language_id=language.language_id WHERE `id`='" . $product_data1["id"] . "'");
                                                        $details_data1 = $details_rs1->fetch_assoc();

                                                        ?>

                                                        <span class="fw-bold"><?php echo $details_data1["category_name"]; ?> - <?php echo $details_data1["type"]; ?> - <?php echo $details_data1["language_name"]; ?></span><br />
                                                        <span class="fw-bold"><i class="bi bi-star-fill text-warning"></i>&nbsp;<?php echo $details_data1["imdb_rating"]; ?> <span class="text-black-50">/ 10</span></span><br />
                                                        <span class="fw-bold">Rs. <?php echo $details_data1["price"]; ?> .00</span><br />

                                                        <?php
                                                        if ($product_data1["qty_available"] > 0) {

                                                        ?>
                                                            <span class="fw-bold text-success"><?php echo $details_data1["qty_available"]; ?> Copies Available</span><br /><br>
                                                            <a href='<?php echo "singleProductView.php?id=" . ($product_data1["id"]); ?>' class="col-5 btn btn-success ">
                                                                Buy Now
                                                            </a>
                                                            <button class="col-3 btn btn-dark" onclick='addToCart(<?php echo $product_data1["id"]; ?>);'>
                                                                <i class="bi bi-cart-plus-fill text-white"></i>
                                                            </button>
                                                        <?php

                                                        } else {
                                                        ?>
                                                            <span class="card-text text-danger fw-bold">No Copies Available</span><br /><br />
                                                            <a href='#' class="col-5 btn btn-success disabled">Buy Now</a>
                                                            <button class="col-3 btn btn-dark disabled">
                                                                <i class="bi bi-cart-plus-fill text-white"></i>
                                                            </button>
                                                            <?php
                                                        }

                                                        if (isset($_SESSION["u"])) {

                                                            $watchlist_rs1 = Database::search("SELECT * FROM `watchlist` WHERE `user_email`='" . $_SESSION["u"]["email"] . "' AND
                                                        `product_id`='" . $product_data1["id"] . "'");
                                                            $watchlist_num1 = $watchlist_rs1->num_rows;

                                                            if ($watchlist_num1 == 1) {
                                                            ?>
                                                                <button class="col-3 btn" style="background-color: wheat;" onclick='addToWatchlist(<?php echo $product_data1["id"]; ?>);'>
                                                                    <i class="bi bi-heart-fill text-danger" id="heart<?php echo $product_data1["id"]; ?>"></i>
                                                                </button>
                                                            <?php

                                                            } else {
                                                            ?>
                                                                <button class="col-3 btn" style="background-color: wheat;" onclick='addToWatchlist(<?php echo $product_data1["id"]; ?>);'>
                                                                    <i class="bi bi-heart-fill text-dark" id="heart<?php echo $product_data1["id"]; ?>"></i>
                                                                </button>
                                                        <?php

                                                            }
                                                        }

                                                        ?>

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
                    </div>
                    <!--  New Release -->

                    <!-- Top Selling -->
                    <div class="col-12 mt-3 mb-3">
                        <span class="text-decoration-none text-black fs-3 fw-bold">Top Selling</span>
                        &nbsp;&nbsp;
                        <a href="#" class="text-decoration-none text-black fs-5" onclick="topSelling(0);">See All &nbsp;&rarr;</a>
                    </div>

                    <div class="col-12 mb-3">
                        <div class="row border border-dark">

                            <div class="col-12">
                                <div class="row justify-content-center gap-1">

                                    <?php

                                    $product_rs2 = Database::search("SELECT * FROM `product` WHERE `availability_availability_id`='1'
                                    AND `status_status_id`='1' ORDER BY `qty_sold` DESC LIMIT 6 OFFSET 0");

                                    $product_num2 = $product_rs2->num_rows;

                                    for ($z = 0; $z < $product_num2; $z++) {
                                        $product_data2 = $product_rs2->fetch_assoc();
                                    ?>

                                        <div class="card bg-light mt-1 mb-1" style="max-width: 450px; ">
                                            <div class="row g-0">
                                                <div class="col-4 py-2">

                                                    <?php
                                                    $img_rs2 = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $product_data2["id"] . "'");
                                                    $img_data2 = $img_rs2->fetch_assoc();
                                                    ?>

                                                    <img src="<?php echo $img_data2["img_path"]; ?>" class="img-fluid" style="cursor:pointer" onclick='singleProductViewHome(<?php echo $product_data2["id"]; ?>);' />
                                                </div>
                                                <div class="col-8">
                                                    <div class="card-body text-center">
                                                        <h5 class="card-title text-primary fw-bold fs-5"><?php echo $product_data2["title"]; ?></h5>

                                                        <?php
                                                        $details_rs2 = Database::search("SELECT * FROM `product` INNER JOIN `type` ON 
                                                        product.type_type_id=type.type_id INNER JOIN `category` ON product.category_category_id=category.category_id INNER JOIN `language` ON 
                                                        product.language_language_id=language.language_id WHERE `id`='" . $product_data2["id"] . "'");
                                                        $details_data2 = $details_rs2->fetch_assoc();

                                                        ?>

                                                        <span class="fw-bold"><?php echo $details_data2["category_name"]; ?> - <?php echo $details_data2["type"]; ?> - <?php echo $details_data2["language_name"]; ?></span><br />
                                                        <span class="fw-bold"><i class="bi bi-star-fill text-warning"></i>&nbsp;<?php echo $details_data2["imdb_rating"]; ?> <span class="text-black-50">/ 10</span></span><br />
                                                        <span class="fw-bold">Rs. <?php echo $details_data2["price"]; ?> .00</span><br />
                                                        <span class="fw-bold text-info"><?php echo $details_data2["qty_sold"]; ?> Copies Sold</span><br />

                                                        <?php
                                                        if ($product_data2["qty_available"] > 0) {

                                                        ?>
                                                            <span class="fw-bold text-success"><?php echo $details_data2["qty_available"]; ?> Copies Available</span><br /><br>
                                                            <a href='<?php echo "singleProductView.php?id=" . ($product_data2["id"]); ?>' class="col-5 btn btn-success ">
                                                                Buy Now
                                                            </a>
                                                            <button class="col-3 btn btn-dark" onclick='addToCart(<?php echo $product_data2["id"]; ?>);'>
                                                                <i class="bi bi-cart-plus-fill text-white"></i>
                                                            </button>
                                                        <?php

                                                        } else {
                                                        ?>
                                                            <span class="card-text text-danger fw-bold">No Copies Available</span><br /><br />
                                                            <a href='#' class="col-5 btn btn-success disabled">Buy Now</a>
                                                            <button class="col-3 btn btn-dark disabled">
                                                                <i class="bi bi-cart-plus-fill text-white"></i>
                                                            </button>
                                                            <?php
                                                        }

                                                        if (isset($_SESSION["u"])) {

                                                            $watchlist_rs2 = Database::search("SELECT * FROM `watchlist` WHERE `user_email`='" . $_SESSION["u"]["email"] . "' AND
                                                        `product_id`='" . $product_data2["id"] . "'");
                                                            $watchlist_num2 = $watchlist_rs2->num_rows;

                                                            if ($watchlist_num2 == 1) {
                                                            ?>
                                                                <button class="col-3 btn" style="background-color: wheat;" onclick='addToWatchlist(<?php echo $product_data2["id"]; ?>);'>
                                                                    <i class="bi bi-heart-fill text-danger" id="heart<?php echo $product_data2["id"]; ?>"></i>
                                                                </button>
                                                            <?php

                                                            } else {
                                                            ?>
                                                                <button class="col-3 btn" style="background-color: wheat;" onclick='addToWatchlist(<?php echo $product_data2["id"]; ?>);'>
                                                                    <i class="bi bi-heart-fill text-dark" id="heart<?php echo $product_data2["id"]; ?>"></i>
                                                                </button>
                                                        <?php

                                                            }
                                                        }

                                                        ?>

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
                    </div>
                    <!--  Top Selling -->

                    <!-- Top Rated -->
                    <div class="col-12 mt-3 mb-3">
                        <span class="text-decoration-none text-black fs-3 fw-bold">Top Rated</span>
                        &nbsp;&nbsp;
                        <a href="#" class="text-decoration-none text-black fs-5" onclick="topRated(0);">See All &nbsp;&rarr;</a>
                    </div>

                    <div class="col-12 mb-3">
                        <div class="row border border-dark">

                            <div class="col-12">
                                <div class="row justify-content-center gap-1">

                                    <?php

                                    $product_rs3 = Database::search("SELECT * FROM `product` WHERE `availability_availability_id`='1'
                                    AND `status_status_id`='1' ORDER BY `imdb_rating` DESC LIMIT 6 OFFSET 0");

                                    $product_num3 = $product_rs3->num_rows;

                                    for ($z = 0; $z < $product_num3; $z++) {
                                        $product_data3 = $product_rs3->fetch_assoc();
                                    ?>

                                        <div class="card bg-light mt-1 mb-1" style="max-width: 450px; ">
                                            <div class="row g-0">
                                                <div class="col-4 py-2">

                                                    <?php
                                                    $img_rs3 = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $product_data3["id"] . "'");
                                                    $img_data3 = $img_rs3->fetch_assoc();
                                                    ?>

                                                    <img src="<?php echo $img_data3["img_path"]; ?>" class="img-fluid" style="cursor:pointer" onclick='singleProductViewHome(<?php echo $product_data3["id"]; ?>);' />
                                                </div>
                                                <div class="col-8">
                                                    <div class="card-body text-center">
                                                        <h5 class="card-title text-primary fw-bold fs-5"><?php echo $product_data3["title"]; ?></h5>

                                                        <?php
                                                        $details_rs3 = Database::search("SELECT * FROM `product` INNER JOIN `type` ON 
                                                        product.type_type_id=type.type_id INNER JOIN `category` ON product.category_category_id=category.category_id INNER JOIN `language` ON 
                                                        product.language_language_id=language.language_id WHERE `id`='" . $product_data3["id"] . "'");
                                                        $details_data3 = $details_rs3->fetch_assoc();

                                                        ?>

                                                        <span class="fw-bold"><?php echo $details_data3["category_name"]; ?> - <?php echo $details_data3["type"]; ?> - <?php echo $details_data3["language_name"]; ?></span><br />
                                                        <span class="fw-bold"><i class="bi bi-star-fill text-warning"></i>&nbsp;<?php echo $details_data3["imdb_rating"]; ?> <span class="text-black-50">/ 10</span></span><br />
                                                        <span class="fw-bold">Rs. <?php echo $details_data3["price"]; ?> .00</span><br />

                                                        <?php
                                                        if ($product_data3["qty_available"] > 0) {

                                                        ?>
                                                            <span class="fw-bold text-success"><?php echo $details_data3["qty_available"]; ?> Copies Available</span><br /><br>
                                                            <a href='<?php echo "singleProductView.php?id=" . ($product_data3["id"]); ?>' class="col-5 btn btn-success ">
                                                                Buy Now
                                                            </a>
                                                            <button class="col-3 btn btn-dark" onclick='addToCart(<?php echo $product_data3["id"]; ?>);'>
                                                                <i class="bi bi-cart-plus-fill text-white"></i>
                                                            </button>
                                                        <?php

                                                        } else {
                                                        ?>
                                                            <span class="card-text text-danger fw-bold">No Copies Available</span><br /><br />
                                                            <a href='#' class="col-5 btn btn-success disabled">Buy Now</a>
                                                            <button class="col-3 btn btn-dark disabled">
                                                                <i class="bi bi-cart-plus-fill text-white"></i>
                                                            </button>
                                                            <?php
                                                        }

                                                        if (isset($_SESSION["u"])) {

                                                            $watchlist_rs3 = Database::search("SELECT * FROM `watchlist` WHERE `user_email`='" . $_SESSION["u"]["email"] . "' AND
                                                        `product_id`='" . $product_data3["id"] . "'");
                                                            $watchlist_num3 = $watchlist_rs3->num_rows;

                                                            if ($watchlist_num3 == 1) {
                                                            ?>
                                                                <button class="col-3 btn" style="background-color: wheat;" onclick='addToWatchlist(<?php echo $product_data3["id"]; ?>);'>
                                                                    <i class="bi bi-heart-fill text-danger" id="heart<?php echo $product_data3["id"]; ?>"></i>
                                                                </button>
                                                            <?php

                                                            } else {
                                                            ?>
                                                                <button class="col-3 btn" style="background-color: wheat;" onclick='addToWatchlist(<?php echo $product_data3["id"]; ?>);'>
                                                                    <i class="bi bi-heart-fill text-dark" id="heart<?php echo $product_data3["id"]; ?>"></i>
                                                                </button>
                                                        <?php

                                                            }
                                                        }

                                                        ?>

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
                    </div>
                    <!--  Top Rated -->

                    <?php
                    $category_rs4 = Database::search("SELECT * FROM `category`");
                    $category_num4 = $category_rs4->num_rows;

                    for ($y = 0; $y < $category_num4; $y++) {
                        $category_data4 = $category_rs4->fetch_assoc();
                    ?>

                        <!-- Category Wise -->
                        <div class="col-12 mt-3 mb-3">
                            <span class="text-black fs-3 fw-bold"><?php echo $category_data4["category_name"]; ?></span>
                            &nbsp;&nbsp;
                            <a href="#" class="text-decoration-none text-black fs-5" onclick="categoryWise(<?php echo $category_data4['category_id']; ?>,0);">See All &nbsp;&rarr;</a>
                        </div>


                        <div class="col-12 mb-3">
                            <div class="row border border-dark">

                                <div class="col-12">
                                    <div class="row justify-content-center gap-1">

                                        <?php

                                        $product_rs4 = Database::search("SELECT * FROM `product` WHERE `category_category_id`='" . $category_data4["category_id"] . "'
                                        AND `availability_availability_id`='1'
                                        AND `status_status_id`='1' ORDER BY `datetime_added` DESC LIMIT 6 OFFSET 0");

                                        $product_num4 = $product_rs4->num_rows;

                                        for ($z = 0; $z < $product_num4; $z++) {
                                            $product_data4 = $product_rs4->fetch_assoc();
                                        ?>

                                            <div class="card bg-light mt-1 mb-1" style="max-width: 450px; ">
                                                <div class="row g-0">
                                                    <div class="col-4 py-2">

                                                        <?php
                                                        $img_rs4 = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $product_data4["id"] . "'");
                                                        $img_data4 = $img_rs4->fetch_assoc();
                                                        ?>

                                                        <img src="<?php echo $img_data4["img_path"]; ?>" class="img-fluid" style="cursor:pointer" onclick='singleProductViewHome(<?php echo $product_data4["id"]; ?>);' />
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="card-body text-center">
                                                            <h5 class="card-title text-primary fw-bold fs-5"><?php echo $product_data4["title"]; ?></h5>

                                                            <?php
                                                            $details_rs4 = Database::search("SELECT * FROM `product` INNER JOIN `type` ON 
                                                        product.type_type_id=type.type_id INNER JOIN `language` ON 
                                                        product.language_language_id=language.language_id WHERE `id`='" . $product_data4["id"] . "'");
                                                            $details_data4 = $details_rs4->fetch_assoc();

                                                            ?>

                                                            <span class="fw-bold"><?php echo $details_data4["type"]; ?> - <?php echo $details_data4["language_name"]; ?></span><br />
                                                            <span class="fw-bold"><i class="bi bi-star-fill text-warning"></i>&nbsp;<?php echo $details_data4["imdb_rating"]; ?> <span class="text-black-50">/ 10</span></span><br />
                                                            <span class="fw-bold">Rs. <?php echo $details_data4["price"]; ?> .00</span><br />

                                                            <?php
                                                            if ($product_data4["qty_available"] > 0) {

                                                            ?>
                                                                <span class="fw-bold text-success"><?php echo $details_data4["qty_available"]; ?> Copies Available</span><br /><br>
                                                                <a href='<?php echo "singleProductView.php?id=" . ($product_data4["id"]); ?>' class="col-5 btn btn-success ">
                                                                    Buy Now
                                                                </a>
                                                                <button class="col-3 btn btn-dark" onclick='addToCart(<?php echo $product_data4["id"]; ?>);'>
                                                                    <i class="bi bi-cart-plus-fill text-white"></i>
                                                                </button>
                                                            <?php

                                                            } else {
                                                            ?>
                                                                <span class="card-text text-danger fw-bold">No Copies Available</span><br /><br />
                                                                <a href='#' class="col-5 btn btn-success disabled">Buy Now</a>
                                                                <button class="col-3 btn btn-dark disabled">
                                                                    <i class="bi bi-cart-plus-fill text-white"></i>
                                                                </button>
                                                                <?php
                                                            }

                                                            if (isset($_SESSION["u"])) {

                                                                $watchlist_rs4 = Database::search("SELECT * FROM `watchlist` WHERE `user_email`='" . $_SESSION["u"]["email"] . "' AND
                                                        `product_id`='" . $product_data4["id"] . "'");
                                                                $watchlist_num4 = $watchlist_rs4->num_rows;

                                                                if ($watchlist_num4 == 1) {
                                                                ?>
                                                                    <button class="col-3 btn" style="background-color: wheat;" onclick='addToWatchlist(<?php echo $product_data4["id"]; ?>);'>
                                                                        <i class="bi bi-heart-fill text-danger" id="heart<?php echo $product_data4["id"]; ?>"></i>
                                                                    </button>
                                                                <?php

                                                                } else {
                                                                ?>
                                                                    <button class="col-3 btn" style="background-color: wheat;" onclick='addToWatchlist(<?php echo $product_data4["id"]; ?>);'>
                                                                        <i class="bi bi-heart-fill text-dark" id="heart<?php echo $product_data4["id"]; ?>"></i>
                                                                    </button>
                                                            <?php

                                                                }
                                                            }

                                                            ?>

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
                        </div>
                        <!--  Category Wise -->
                    <?php
                    }

                    ?>

                </div>
            </div>

            <?php include "footer.php"; ?>

        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>