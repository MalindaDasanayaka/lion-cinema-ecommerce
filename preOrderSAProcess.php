<?php
include "connection.php";
session_start();

$query = "SELECT * FROM `product` WHERE `availability_availability_id`='2'
AND `status_status_id`='1' ORDER BY `datetime_added` DESC";

?>

<!-- Pre Order -->
<div class="col-12 mt-3 mb-3 text-center">
    <span class="text-black fs-1 fw-bold">Pre-Order</span>
</div>

<div class="col-12 mb-3">
    <div class="row border border-dark">

        <div class="col-12">
            <div class="row justify-content-center gap-1">

                <?php

                $pageno;

                if ("0" != ($_GET["page"])) {
                    $pageno = $_GET["page"];
                } else {
                    $pageno = 1;
                }

                $product_rs = Database::search($query);
                $product_num = $product_rs->num_rows;

                $results_per_page = 30;
                $number_of_pages = ceil($product_num / $results_per_page);

                $page_results = ($pageno - 1) * $results_per_page;
                $selected_rs = Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

                $selected_num = $selected_rs->num_rows;
                for ($x = 0; $x < $selected_num; $x++) {
                    $selected_data = $selected_rs->fetch_assoc();
                ?>

                    <div class="card bg-light mt-1 mb-1" style="max-width: 450px; ">
                        <div class="row g-0">
                            <div class="col-4 py-2">

                                <?php
                                $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $selected_data["id"] . "'");
                                $img_data = $img_rs->fetch_assoc();
                                ?>

                                <img src="<?php echo $img_data["img_path"]; ?>" class="img-fluid" style="cursor:pointer" onclick='singleProductViewHome(<?php echo $selected_data["id"]; ?>);' />
                            </div>
                            <div class="col-8">
                                <div class="card-body text-center">
                                    <h5 class="card-title text-primary fw-bold fs-5"><?php echo $selected_data["title"]; ?></h5>
                                    <span class="badge rounded-pill text-bg-warning">Coming Soon</span><br />

                                    <?php
                                    $details_rs = Database::search("SELECT * FROM `product` INNER JOIN `type` ON 
                                    product.type_type_id=type.type_id INNER JOIN `category` ON product.category_category_id=category.category_id INNER JOIN `language` ON 
                                    product.language_language_id=language.language_id WHERE `id`='" . $selected_data["id"] . "'");
                                    $details_data = $details_rs->fetch_assoc();

                                    ?>

                                    <span class="fw-bold text-danger"><?php echo $details_data["category_name"]; ?></span><br />
                                    <span class="fw-bold"><?php echo $details_data["type"]; ?> - <?php echo $details_data["language_name"]; ?></span><br />
                                    <span class="fw-bold text-success">Rs. <?php echo $selected_data["price"]; ?> .00</span><br /><br />

                                    <a href='<?php echo "singleProductView.php?id=" . ($selected_data["id"]); ?>' class="col-5 btn btn-info fw-bold">
                                        Pre-Order
                                    </a>
                                    <button class="col-3 btn btn-dark" onclick='addToCart(<?php echo $selected_data["id"]; ?>);'>
                                        <i class="bi bi-cart-plus-fill text-white"></i>
                                    </button>

                                    <?php

                                    if (isset($_SESSION["u"])) {

                                        $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `user_email`='" . $_SESSION["u"]["email"] . "' AND
                                        `product_id`='" . $selected_data["id"] . "'");
                                        $watchlist_num = $watchlist_rs->num_rows;

                                        if ($watchlist_num == 1) {
                                    ?>
                                            <button class="col-3 btn" style="background-color: wheat;" onclick='addToWatchlist(<?php echo $selected_data["id"]; ?>);'>
                                                <i class="bi bi-heart-fill text-danger" id="heart<?php echo $selected_data["id"]; ?>"></i>
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
                                                        ?> onclick="preOrder(<?php echo ($pageno - 1); ?>);" ; <?php
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
                                        <a class="page-link" onclick="preOrder(<?php echo $x; ?>);"><?php echo $x; ?></a>
                                    </li>
                                <?php
                                } else {
                                ?>
                                    <li class="page-item">
                                        <a class="page-link" onclick="preOrder(<?php echo $x; ?>);"><?php echo $x; ?></a>
                                    </li>
                            <?php
                                }
                            }
                            ?>

                            <li class="page-item">
                                <a class="page-link" <?php if ($pageno >= $number_of_pages) {
                                                            echo ("#");
                                                        } else {
                                                        ?> onclick="preOrder(<?php echo ($pageno + 1); ?>);" ; <?php
                                                                                                                    }
                                                                                                                        ?> aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>

    </div>
</div>
<!--  Pre Order -->