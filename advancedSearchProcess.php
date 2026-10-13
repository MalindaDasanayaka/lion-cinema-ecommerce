<?php

include "connection.php";
session_start();

$search_txt = $_POST["txt"];
$type = $_POST["t"];
$category = $_POST["c"];
$rating = $_POST["r"];
$language = $_POST["l"];
$availability = $_POST["a"];
$rel_year = $_POST["y"];
$price_from = $_POST["pf"];
$price_to = $_POST["pt"];
$sort = $_POST["s"];

$query = "SELECT * FROM `product` WHERE `status_status_id`='1'";

if (!empty($search_txt)) {
    $query .= " AND `title` LIKE '%" . $search_txt . "%'";
}

if ($type != 0) {
    $query .= " AND `type_type_id`='" . $type . "'";
}

if ($category != 0) {
    $query .= " AND `category_category_id`='" . $category . "'";
}

if ($language != 0) {
    $query .= " AND `language_language_id`='" . $language . "'";
}

if ($availability != 0) {
    $query .= " AND `availability_availability_id`='" . $availability . "'";
}

if (!empty($rel_year)) {
    $query .= " AND YEAR(`released_date`) = '" . $rel_year . "'";
}

if ($rating == 10) {
    $query .= "AND `imdb_rating` BETWEEN '9' AND '10'";
} else if ($rating == 9) {
    $query .= "AND `imdb_rating` BETWEEN '8' AND '9'";
} else if ($rating == 8) {
    $query .= "AND `imdb_rating` BETWEEN '7' AND '8'";
} else if ($rating == 7) {
    $query .= "AND `imdb_rating` BETWEEN '6' AND '7'";
} else if ($rating == 6) {
    $query .= "AND `imdb_rating` BETWEEN '5' AND '6'";
} else if ($rating == 5) {
    $query .= "AND `imdb_rating` BETWEEN '4' AND '5'";
} else if ($rating == 4) {
    $query .= "AND `imdb_rating` <= '4'";
}

if (!empty($price_from) && empty($price_to)) {
    $query .= " AND `price` >= '" . $price_from . "'";
}

if (empty($price_from) && !empty($price_to)) {
    $query .= " AND `price` <= '" . $price_to . "'";
}

if (!empty($price_from) && !empty($price_to)) {
    $query .= " AND `price` BETWEEN '" . $price_from . "' AND '" . $price_to . "'";
}


if ($sort == 1) {
    $query .= " ORDER BY `price` ASC";
} else if ($sort == 2) {
    $query .= " ORDER BY `price` DESC";
} else if ($sort == 3) {
    $query .= " ORDER BY `qty_sold` ASC";
} else if ($sort == 4) {
    $query .= " ORDER BY `qty_sold` DESC";
} else if ($sort == 5) {
    $query .= " ORDER BY `imdb_rating` ASC";
} else if ($sort == 6) {
    $query .= " ORDER BY `imdb_rating` DESC";
} else if ($sort == 7) {
    $query .= " ORDER BY `released_date` DESC";
} else if ($sort == 8) {
    $query .= " ORDER BY `released_date` ASC";
}

?>

<?php

$pageno;

if ("0" != ($_POST["page"])) {
    $pageno = $_POST["page"];
} else {
    $pageno = 1;
}

$product_rs = Database::search($query);
$product_num = $product_rs->num_rows;

$results_per_page = 21;
$number_of_pages = ceil($product_num / $results_per_page);

$page_results = ($pageno - 1) * $results_per_page;
$selected_rs = Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

$selected_num = $selected_rs->num_rows;

if ($selected_num == 0) {
?>
    <div class="d-flex flex-column justify-content-center text-center mt-5 mb-5">
        <div class="col-12 sadface mb-5"></div>
        <h1 class="fw-bold text-black">Search No Result</h1>
        <h3 class="fw-bold text-black">We're Sorry, We cannot find any matches for your search term..</h3>
    </div>
    <?php
} else {

    for ($x = 0; $x < $selected_num; $x++) {
        $selected_data = $selected_rs->fetch_assoc();
    ?>
        <div class="card bg-light mt-3 mb-1" style="max-width: 450px; ">
            <div class="row g-0">
                <div class="col-4 py-2">

                    <?php
                    $img_rs4 = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $selected_data["id"] . "'");
                    $img_data4 = $img_rs4->fetch_assoc();
                    ?>

                    <img src="<?php echo $img_data4["img_path"]; ?>" class="img-fluid" style="cursor:pointer" onclick='singleProductViewHome(<?php echo $selected_data["id"]; ?>);' />
                </div>
                <div class="col-8">
                    <div class="card-body text-center">
                        <h5 class="card-title text-primary fw-bold fs-5"><?php echo $selected_data["title"]; ?></h5>

                        <?php
                        $details_rs4 = Database::search("SELECT * FROM `product` INNER JOIN `type` ON 
                                            product.type_type_id=type.type_id INNER JOIN `category` ON 
                                            product.category_category_id=category.category_id INNER JOIN `language` ON 
                                            product.language_language_id=language.language_id WHERE `id`='" . $selected_data["id"] . "'");
                        $details_data4 = $details_rs4->fetch_assoc();

                        if ($selected_data["availability_availability_id"] == 2) {
                        ?>
                            <span class="badge rounded-pill text-bg-warning">Coming Soon</span><br />
                        <?php
                        }

                        ?>

                        <?php

                        if ($selected_data["availability_availability_id"] == 1) {
                        ?>
                            <span class="fw-bold"><?php echo $details_data4["category_name"]; ?> - <?php echo $details_data4["type"]; ?> - <?php echo $details_data4["language_name"]; ?></span><br />
                            <span class="fw-bold"><i class="bi bi-star-fill text-warning"></i>&nbsp;<?php echo $details_data4["imdb_rating"]; ?> <span class="text-black-50">/ 10</span></span><br />
                        <?php

                        } else {
                        ?>
                            <span class="fw-bold text-danger"><?php echo $details_data4["category_name"]; ?></span><br />
                            <span class="fw-bold"><?php echo $details_data4["type"]; ?> - <?php echo $details_data4["language_name"]; ?></span><br />
                        <?php

                        }

                        ?>

                        <span class="fw-bold">Rs. <?php echo $details_data4["price"]; ?> .00</span><br />

                        <?php
                        if ($selected_data["availability_availability_id"] == 1) {
                            if ($selected_data["qty_available"] > 0) {

                        ?>
                                <span class="fw-bold text-success"><?php echo $selected_data["qty_available"]; ?> Copies Available</span><br /><br>
                                <a href='<?php echo "singleProductView.php?id=" . ($selected_data["id"]); ?>' class="col-5 btn btn-success ">
                                    Buy Now
                                </a>
                                <button class="col-3 btn btn-dark" onclick='addToCart(<?php echo $selected_data["id"]; ?>);'>
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
                        } else {

                            ?>
                            <br />
                            <a href='<?php echo "singleProductView.php?id=" . ($selected_data["id"]); ?>' class="col-5 btn btn-info fw-bold ">
                                Pre-Order
                            </a>
                            <button class="col-3 btn btn-dark" onclick='addToCart(<?php echo $selected_data["id"]; ?>);'>
                                <i class="bi bi-cart-plus-fill text-white"></i>
                            </button>
                            <?php

                        }

                        if (isset($_SESSION["u"])) {

                            $watchlist_rs4 = Database::search("SELECT * FROM `watchlist` WHERE `user_email`='" . $_SESSION["u"]["email"] . "' AND
                                                `product_id`='" . $selected_data["id"] . "'");
                            $watchlist_num4 = $watchlist_rs4->num_rows;

                            if ($watchlist_num4 == 1) {
                            ?>
                                <button class="col-3 btn" style="background-color: wheat;" onclick='addToWatchlist(<?php echo $selected_data["id"]; ?>);'>
                                    <i class="bi bi-heart-fill text-danger" id="heart<?php echo $product_data4["id"]; ?>"></i>
                                </button>
                            <?php

                            } else {
                            ?>
                                <button class="col-3 btn" style="background-color: wheat;" onclick='addToWatchlist(<?php echo $selected_data["id"]; ?>);'>
                                    <i class="bi bi-heart-fill text-dark" id="heart<?php echo $selected_data["id"]; ?>"></i>
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

    <div class="col-12 text-center mt-3 mb-3">
        <nav aria-label="Page navigation example">
            <ul class="pagination pagination-lg justify-content-center">
                <li class="page-item">
                    <a class="page-link" <?php if ($pageno <= 1) {
                                                echo ("#");
                                            } else {
                                            ?> onclick="advancedSearch(<?php echo ($pageno - 1); ?>);" ; <?php
                                                                                                        }
                                                                                                            ?> aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php
                for ($x = 1; $x <= $number_of_pages; $x++) {
                    if ($x == $pageno) {
                ?>
                        <li class="page-item active">
                            <a class="page-link" onclick="advancedSearch(<?php echo $x; ?>);"><?php echo $x; ?></a>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="page-item">
                            <a class="page-link" onclick="advancedSearch(<?php echo $x; ?>);"><?php echo $x; ?></a>
                        </li>
                <?php
                    }
                }
                ?>

                <li class="page-item">
                    <a class="page-link" <?php if ($pageno >= $number_of_pages) {
                                                echo ("#");
                                            } else {
                                            ?> onclick="advancedSearch(<?php echo ($pageno + 1); ?>);" ; <?php
                                                                                                        }
                                                                                                            ?> aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

<?php

}
?>