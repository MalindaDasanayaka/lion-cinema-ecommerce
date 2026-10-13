<?php
session_start();
include "connection.php";

$txt = $_POST["t"];

$query = "SELECT * FROM `watchlist` INNER JOIN `product` ON
watchlist.product_id=product.id INNER JOIN `type` ON 
product.type_type_id=type.type_id INNER JOIN `category` ON 
product.category_category_id=category.category_id INNER JOIN `language` ON 
product.language_language_id=language.language_id WHERE watchlist.user_email='" . $_SESSION["u"]["email"] . "'";

if (!empty($txt)) {
    $query .= "AND `title` LIKE '%" . $txt . "%'";
}

?>

<?php
$watchlist_rs = Database::search($query);
$watchlist_num = $watchlist_rs->num_rows;

if ($watchlist_num == 0) {
?>
    <div class="d-flex flex-column justify-content-center text-center mt-5 mb-5">
        <div class="col-12 sadface mb-5"></div>
        <h1 class="fw-bold text-black">Search No Result</h1>
        <h3 class="fw-bold text-black">We're Sorry, We cannot find any matches for your search term..</h3>
    </div>
<?php
} else {

?>
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

                        <img src="<?php echo $img_data["img_path"]; ?>" class="img-fluid rounded" style="height: 270px; cursor:pointer" onclick='singleProductViewWatchlist(<?php echo $watchlist_data["id"]; ?>);' />
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
                            <span class="fs-5">IMDb Ratings :</span>&nbsp;&nbsp;
                            <span class="fs-5 fw-bold"><i class="bi bi-star-fill text-warning"></i>&nbsp;<?php echo $watchlist_data["imdb_rating"]; ?><span class="text-black-50 fs-5"> / 10</span></span>
                            <br />
                            <span class="fs-5">Price :</span>&nbsp;&nbsp;
                            <span class="fs-5 fw-bold">Rs. <?php echo $watchlist_data["price"]; ?> .00</span>
                            <br />
                            <span class="fs-5">Quantity :</span>&nbsp;&nbsp;
                            <span class="fs-5 fw-bold text-success"><?php echo $watchlist_data["qty_available"]; ?> Copies available</span>
                        </div>
                    </div>
                    <div class="col-md-3 mt-5">
                        <div class="card-body d-lg-grid">
                            <a href="#" class="btn btn-success mb-2">Buy Now</a>
                            <a href="#" class="btn btn-dark mb-2" onclick='addToCart(<?php echo $watchlist_data["id"]; ?>);'>Add to Cart</a>
                            <a href="#" class="btn btn-danger" onclick='confirmRemoveFromWatchlist(<?php echo $list_id; ?>);'>
                                Remove
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- modal -->
            <div class="modal fade" id="removeFromWatchlistModal<?php echo $list_id; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Are you sure you want to REMOVE <?php echo $watchlist_data["title"]; ?> from watchlist ?</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" onclick="removeFromWatchlist('<?php echo $list_id; ?>');">Yes</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal -->

        <?php
        }
        ?>
    </div>
<?php
}
?>