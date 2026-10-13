<?php
session_start();
include "connection.php";

$txt = $_POST["t"];
$user = $_SESSION["u"]["email"];

$query = "SELECT * FROM `cart` INNER JOIN `product` ON
cart.product_id=product.id INNER JOIN `type` ON 
product.type_type_id=type.type_id INNER JOIN `category` ON 
product.category_category_id=category.category_id INNER JOIN `language` ON 
product.language_language_id=language.language_id WHERE cart.user_email='" . $user . "'";

if (!empty($txt)) {
    $query .= "AND `title` LIKE '%" . $txt . "%'";
}

?>

<?php

$cart_rs = Database::search($query);
$cart_num = $cart_rs->num_rows;

if ($cart_num == 0) {
?>
    <div class="d-flex flex-column justify-content-center text-center mt-5 mb-5">
        <div class="col-12 sadface mb-5"></div>
        <h1 class="fw-bold text-black">Search No Result</h1>
        <h3 class="fw-bold text-black">We're Sorry, We cannot find any matches for your search term..</h3>
    </div>
<?php

} else {

    $total = 0;
    $subtotal = 0;
    $delivery = 0;

?>

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
                $delivery_data = $delivery_rs->fetch_assoc();


                if ($cart_data["cart_qty"] > 5) {
                    $delivery = 0;
                } else {
                    $delivery = $delivery_data["delivery_cost"];
                }

            ?>

                <div class="card mx-0 col-12 border border-1 border-dark bg-light">
                    <div class="row g-0">
                        <div class="col-md-12 mt-3 mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <span class="fs-5">Receive by :</span>&nbsp;
                                    <span class="fw-bold fs-5">15 May - 16 May</span>&nbsp;
                                </div>
                            </div>
                        </div>

                        <hr />

                        <div class="col-md-4">

                            <span class="d-inline-block mb-3 px-3" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="<?php echo $cart_data["description"]; ?>" title="Overview">
                                <img src="<?php echo $img_data["img_path"]; ?>" class="img-fluid rounded" style="max-width: 200px;">
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
                                <span class="fs-5 fw-bold"><i class="bi bi-star-fill text-warning"></i>&nbsp;<?php echo $cart_data["imdb_rating"]; ?><span class="text-black-50 fs-5"> / 10</span></span>
                                <br />
                                <span class="fs-5">Price :</span>&nbsp;&nbsp;
                                <span class="fs-5 fw-bold">Rs. <?php echo $cart_data["price"]; ?> .00</span>
                                <br />
                                <span class="fs-5">Quantity :</span>&nbsp;
                                <input onkeyup='check_qty(<?php echo $cart_data["qty"]; ?>);' type="number" class="mt-3 border border-2 border-secondary fs-4 fw-bold px-3 cardqtytext" value="<?php echo $cart_data["cart_qty"]; ?>" onchange="changeQTY(<?php echo $cart_data['cart_id']; ?>);" id="qty_num">
                                <br><br>
                                <span class="fs-5">Delivery Fee :</span>&nbsp;
                                <span class="fw-bold fs-5">Rs. <?php echo $delivery; ?> .00</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card-body d-grid">
                                <a class="btn btn-success mb-2">Buy Now</a>
                                <a class="btn btn-danger mb-2" onclick='confirmDeleteFromCart(<?php echo $cart_data["cart_id"]; ?>);'>Remove</a>
                            </div>
                        </div>

                        <!-- modal -->
                        <div class="modal fade" id="deleteFromCartModal<?php echo $cart_data["cart_id"]; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Are you sure you want to DELETE <?php echo $cart_data["title"]; ?> from cart ?</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success" onclick="deleteFromCart('<?php echo $cart_data['cart_id']; ?>');">Yes</button>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- modal -->

                        <hr>

                        <div class="col-md-12 mt-3 mb-3">
                            <div class="row">
                                <div class="col-6 col-md-6">
                                    <span class="fs-5">Requested Total <i class="bi bi-info-circle"></i></span>
                                </div>
                                <div class="col-6 col-md-6 text-end">
                                    <span class="fw-bold fs-5">Rs. <?php echo ($cart_data["price"] * $cart_data["cart_qty"]) + $delivery; ?> .00</span>
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

<?php

}

?>