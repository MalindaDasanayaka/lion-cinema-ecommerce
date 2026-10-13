<?php
include "connection.php";

$txt = $_POST["t"];

$query = "SELECT * FROM `product`";

if (!empty($txt)) {
    $query .= "WHERE `title` LIKE '%" . $txt . "%'";
}

$pageno;

if ("0" != ($_POST["page"])) {
    $pageno = $_POST["page"];
} else {
    $pageno = 1;
}

$product_rs = Database::search($query);
$product_num = $product_rs->num_rows;

$results_per_page = 10;
$number_of_pages = ceil($product_num / $results_per_page);

$page_results = ($pageno - 1) * $results_per_page;
$selected_rs = Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

$selected_num = $selected_rs->num_rows;

if ($selected_num == 0) {
?>
    <div class="d-flex flex-column justify-content-center text-center mt-5 mb-5">
        <div class="col-12 sadface mb-5"></div>
        <h1 class="fw-bold text-black">Search No Product</h1>
        <h3 class="fw-bold text-black">We're Sorry, We cannot find any Product for your search term..</h3>
    </div>
<?php
} else {

?>
    <!-- product table -->
    <table class="table table-hover table-striped-columns border border-dark border-1 text-center" style="background-color: gainsboro;">
        <thead style="background-color: wheat;">
            <tr>
                <th scope="col" class="fs-4 fw-bold">#</th>
                <th scope="col" class="fs-4 fw-bold">Product Image</th>
                <th scope="col" class="fs-4 fw-bold">Title</th>
                <th scope="col" class="fs-4 fw-bold">Price</th>
                <th scope="col" class="fs-4 fw-bold">Quantity</th>
                <th scope="col" class="fs-4 fw-bold">Availability</th>
                <th scope="col" class="fs-4 fw-bold">Registered Date & Time</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>

            <?php

            for ($x = 0; $x < $selected_num; $x++) {
                $selected_data = $selected_rs->fetch_assoc();

            ?>

                <tr>
                    <th scope="row" class="fs-4 text-dark"><?php echo $selected_data["id"]; ?></th>
                    <td onmouseover="viewProductModal('<?php echo $selected_data['id']; ?>');">

                        <?php
                        $image_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $selected_data["id"] . "'");
                        $image_num = $image_rs->num_rows;

                        if ($image_num == 0) {
                        ?>
                            <img src="resource/default_icons/default_image.svg" style="height: 100px;" />
                        <?php
                        } else {
                            $image_data = $image_rs->fetch_assoc();
                        ?>
                            <img src="<?php echo $image_data["img_path"]; ?>" style="height: 100px;" />
                        <?php
                        }
                        ?>

                    </td>
                    <td class="fs-4"><?php echo $selected_data["title"]; ?></td>
                    <td class="fs-4 ">Rs. <?php echo $selected_data["price"]; ?> .00</td>
                    <?php
                    if ($selected_data["qty_available"] == 0) {
                    ?>
                        <td class="fs-4 text-danger">No Copies</td>
                    <?php

                    } else if ($selected_data["qty_available"] <= 100) {
                    ?>
                        <td class="fs-4 text-danger"><?php echo $selected_data["qty_available"]; ?></td>
                    <?php

                    } else {
                    ?>
                        <td class="fs-4 text-success"><?php echo $selected_data["qty_available"]; ?></td>
                    <?php
                    }
                    ?>

                    <td>
                        <?php
                        if ($selected_data["availability_availability_id"] == 1) {
                        ?>
                            <button id="pa<?php echo $selected_data['id']; ?>" onclick="changeAvailability('<?php echo $selected_data['id']; ?>');" class="btn btn-primary">Released</button>
                        <?php
                        } else {
                        ?>
                            <button id="pa<?php echo $selected_data['id']; ?>" onclick="changeAvailability('<?php echo $selected_data['id']; ?>');" class="btn btn-warning">Coming Soon</button>
                        <?php
                        }
                        ?>
                    </td>

                    <td class="fs-4"><?php echo $selected_data["datetime_added"]; ?></td>
                    <td><button class="btn btn-dark" onclick="sendid(<?php echo $selected_data['id']; ?>);">Update</button></td>
                    <td>

                        <?php
                        if ($selected_data["status_status_id"] == 1) {
                        ?>
                            <button id="pb<?php echo $selected_data['id']; ?>" onclick="blockProduct('<?php echo $selected_data['id']; ?>');" class="btn btn-danger">Deactivate</button>
                        <?php
                        } else {
                        ?>
                            <button id="pb<?php echo $selected_data['id']; ?>" onclick="blockProduct('<?php echo $selected_data['id']; ?>');" class="btn btn-success">Activate</button>
                        <?php
                        }
                        ?>

                    </td>
                </tr>

                <!-- view product modal -->
                <div class="modal fade" tabindex="-1" id="viewProductModal<?php echo $selected_data['id']; ?>">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content bg-light">
                            <div class="modal-header">
                                <h2 class="modal-title fw-bold text-primary"><?php echo $selected_data['title']; ?></h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="offset-4 col-4">

                                    <?php
                                    $image_rs1 = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $selected_data["id"] . "'");
                                    $image_num1 = $image_rs1->num_rows;

                                    if ($image_num1 == 0) {
                                    ?>
                                        <img src="resource/default_icons/default_image.svg" style="height: 220px;" class="img-fluid" />
                                    <?php
                                    } else {
                                        $image_data1 = $image_rs1->fetch_assoc();
                                    ?>
                                        <img src="<?php echo $image_data1["img_path"]; ?>" style="height: 220px;" class="img-fluid" />
                                    <?php
                                    }
                                    ?>

                                </div>
                                <div class="col-12">

                                    <?php
                                    $type_rs = Database::search("SELECT * FROM `type` WHERE `type_id`='" . $selected_data["type_type_id"] . "'");
                                    $type_data = $type_rs->fetch_assoc();
                                    ?>

                                    <?php
                                    $category_rs = Database::search("SELECT * FROM `category` WHERE `category_id`='" . $selected_data["category_category_id"] . "'");
                                    $category_data = $category_rs->fetch_assoc();
                                    ?>

                                    <?php
                                    $language_rs = Database::search("SELECT * FROM `language` WHERE `language_id`='" . $selected_data["language_language_id"] . "'");
                                    $language_data = $language_rs->fetch_assoc();
                                    ?>

                                    <span class="fs-5">Type :</span>&nbsp;
                                    <span class="fs-5 fw-bold"><?php echo $type_data['type']; ?></span><br />
                                    <span class="fs-5">Category :</span>&nbsp;
                                    <span class="fs-5 fw-bold"><?php echo $category_data['category_name']; ?></span><br />
                                    <span class="fs-5">Language :</span>&nbsp;
                                    <span class="fs-5 fw-bold"><?php echo $language_data['language_name']; ?></span><br />
                                    <span class="fs-5">IMDb Ratings :</span>&nbsp;
                                    <span class="fs-5 fw-bold"><i class="bi bi-star-fill text-warning"></i>&nbsp;<?php echo $selected_data['imdb_rating']; ?></span><br />
                                    <span class="fs-5">Price :</span>&nbsp;
                                    <span class="fs-5 fw-bold">Rs. <?php echo $selected_data['price']; ?> .00</span><br />
                                    <span class="fs-5">Quantity Left :</span>&nbsp;
                                    <span class="fs-5 fw-bold text-danger"><?php echo $selected_data['qty_available']; ?> Copies left</span><br />
                                    <span class="fs-5">Quantity Sold :</span>&nbsp;
                                    <span class="fs-5 fw-bold text-success"><?php echo $selected_data['qty_sold']; ?> Copies Sold</span><br /><br />
                                    <span class="fs-5">Description :</span>&nbsp;
                                    <span class="fs-5 fw-bold"><?php echo $selected_data['description']; ?></span><br />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- view product modal -->

            <?php
            }
            ?>

        </tbody>
    </table>
    <!-- product table -->

    <!-- pagination -->
    <div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3">
        <nav aria-label="Page navigation example">
            <ul class="pagination pagination-lg justify-content-center">
                <li class="page-item">
                    <a class="page-link" <?php if ($pageno <= 1) {
                                                echo ("#");
                                            } else {
                                            ?> onclick="searchProduct(<?php echo ($pageno - 1); ?>);" ; <?php
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
                            <a class="page-link" onclick="searchProduct(<?php echo $x; ?>);"><?php echo $x; ?></a>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="page-item">
                            <a class="page-link" onclick="searchProduct(<?php echo $x; ?>);"><?php echo $x; ?></a>
                        </li>
                <?php
                    }
                }
                ?>

                <li class="page-item">
                    <a class="page-link" <?php if ($pageno >= $number_of_pages) {
                                                echo ("#");
                                            } else {
                                            ?> onclick="searchProduct(<?php echo ($pageno + 1); ?>);" ; <?php
                                                                                                }
                                                                                                    ?> aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- pagination -->
<?php

}

?>