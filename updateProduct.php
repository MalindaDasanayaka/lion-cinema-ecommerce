<?php

session_start();
include "connection.php";

if (isset($_SESSION["au"])) {
    if (isset($_SESSION["p"])) {
        $product = $_SESSION["p"];
?>

        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <title>Update Product | Admins | Lion Cinema</title>
            <link rel="stylesheet" href="bootstrap.css" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" />
            <link rel="stylesheet" href="style.css" />

            <link rel="icon" href="resource/logos/logo1.png" />

        </head>

        <body class="bg-secondary">

            <div class="container-fluid">
                <div class="row">

                    <?php include "adminHeader.php"; ?>

                    <div class="col-12">
                        <div class="row">

                            <div class="col-12 text-center">
                                <label class="form-label fs-1 fw-bold text-black">Update Product</label>
                            </div>

                            <div class="col-12">
                                <hr class="border border-dark" />
                            </div>

                            <div class="col-12 col-lg-10 offset-lg-1 border border-1 rounded border-dark bg-light">
                                <div class="row p-3">

                                    <div class="col-12 col-lg-4 border-end border-dark">
                                        <div class="row">

                                            <div class="col-12">
                                                <label class="form-label fw-bold" style="font-size: 20px;">Select Product Type</label>
                                            </div>

                                            <div class="col-12">
                                                <select class="form-select text-center" disabled>

                                                    <?php
                                                    $type_rs = Database::search("SELECT * FROM `type` WHERE `type_id`='" . $product["type_type_id"] . "'");
                                                    $type_data = $type_rs->fetch_assoc();
                                                    ?>

                                                    <option><?php echo $type_data["type"]; ?></option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-4 border-end border-dark">
                                        <div class="row">

                                            <div class="col-12">
                                                <label class="form-label fw-bold" style="font-size: 20px;">Select Product Category</label>
                                            </div>

                                            <div class="col-12">
                                                <select class="form-select text-center" disabled>

                                                    <?php
                                                    $category_rs = Database::search("SELECT * FROM `category` WHERE `category_id`='" . $product["category_category_id"] . "'");
                                                    $category_data = $category_rs->fetch_assoc();
                                                    ?>

                                                    <option><?php echo $category_data["category_name"]; ?></option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-4">
                                        <div class="row">

                                            <div class="col-12">
                                                <label class="form-label fw-bold" style="font-size: 20px;">Select Product Language</label>
                                            </div>

                                            <div class="col-12">
                                                <select class="form-select text-center" disabled>

                                                    <?php
                                                    $language_rs = Database::search("SELECT * FROM `language` WHERE `language_id`='" . $product["language_language_id"] . "'");
                                                    $language_data = $language_rs->fetch_assoc();
                                                    ?>

                                                    <option><?php echo $language_data["language_name"]; ?></option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <hr class="border-dark" />
                                    </div>

                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12 text-center">
                                                <label class="form-label fw-bold" style="font-size: 20px;">
                                                    Add a Title to your Product
                                                </label>
                                            </div>
                                            <div class="offset-0 offset-lg-2 col-12 col-lg-8">
                                                <input type="text" class="form-control" value="<?php echo $product["title"]; ?>" id="ti" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <hr class="border-dark" />
                                    </div>

                                    <div class="col-12">
                                        <div class="row">

                                            <div class="col-12 col-lg-4 border-end border-dark">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold" style="font-size: 20px;">Select Product Availability</label>
                                                    </div>

                                                    <?php
                                                    if ($product["availability_availability_id"] == 1) {
                                                    ?>

                                                        <div class="col-12">
                                                            <div class="form-check form-check-inline mx-5">
                                                                <input class="form-check-input" type="radio" name="a" checked disabled />
                                                                <label class="form-check-label fw-bold" for="">Released</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="a" disabled />
                                                                <label class="form-check-label fw-bold" for="">Coming Soon</label>
                                                            </div>
                                                        </div>

                                                    <?php
                                                    } else {
                                                    ?>

                                                        <div class="col-12">
                                                            <div class="form-check form-check-inline mx-5">
                                                                <input class="form-check-input" type="radio" name="a" disabled />
                                                                <label class="form-check-label fw-bold" for="">Released</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="a" checked disabled />
                                                                <label class="form-check-label fw-bold" for="">Coming Soon</label>
                                                            </div>
                                                        </div>

                                                    <?php
                                                    }

                                                    ?>

                                                </div>
                                            </div>

                                            <div class="col-12 col-lg-4 border-end border-dark">
                                                <div class="row">

                                                    <div class="col-12">
                                                        <label class="form-label fw-bold" style="font-size: 20px;">Add Product IMDb Ratings</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" class="form-control" value="<?php echo $product["imdb_rating"]; ?>" id="ra" />
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-12 col-lg-4">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold" style="font-size: 20px;">Add Product Quantity</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="number" class="form-control" min="0" value="<?php echo $product["qty_available"]; ?>" id="q" />
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <hr class="border-dark" />
                                    </div>

                                    <div class="col-12">
                                        <div class="row">

                                            <div class="col-12 col-lg-4 border-end border-dark">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold" style="font-size: 20px;">Cost Per Item</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="input-group">
                                                            <span class="input-group-text">Rs.</span>
                                                            <input type="text" class="form-control" value="<?php echo $product["price"]; ?>" id="co" />
                                                            <span class="input-group-text">.00</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-lg-4 border-end border-dark">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold" style="font-size: 20px;">Discount Percentage</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" value="<?php echo $product["discount_percentage"]; ?>" id="dis" />
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-lg-4">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold" style="font-size: 20px;">Add Product Released Date</label>
                                                        <div class="col-12">
                                                            <?php

                                                            if ($product["availability_availability_id"] == 2) {
                                                            ?>
                                                                <input type="date" class="form-control" id="rd" />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <input type="date" class="form-control" value="<?php echo $product["released_date"]; ?>" id="rd" disabled />
                                                            <?php
                                                            }

                                                            ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <hr class="border-dark" />
                                    </div>

                                    <div class="col-12">
                                        <div class="row">

                                            <div class="col-12 col-lg-6">
                                                <div class="row">

                                                    <div class="col-12">
                                                        <label class="form-label fw-bold" style="font-size: 20px;">Add Product Runtime</label>
                                                    </div>
                                                    <div class="col-12">

                                                        <?php

                                                        if ($product["availability_availability_id"] == 2) {
                                                        ?>
                                                            <input type="text" class="form-control" id="rt" />
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <input type="text" class="form-control" value="<?php echo $product["runtime"]; ?>" id="rt" disabled />
                                                        <?php
                                                        }

                                                        ?>

                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-12 col-lg-6">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold" style="font-size: 20px;">Add Product Trailer Link</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <?php
                                                        $trailer_rs = Database::search("SELECT * FROM `trailer` WHERE `product_id`='" . $product["id"] . "'");
                                                        $tariler_num = $trailer_rs->num_rows;
                                                        if ($tariler_num > 0) {
                                                            $trailer_data = $trailer_rs->fetch_assoc();
                                                        ?>
                                                            <input type="text" class="form-control" value="<?php echo $trailer_data["trailer_link"] ?>" id="tra" />
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <input type="text" class="form-control" value="" id="tra" />
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <hr class="border-dark" />
                                    </div>

                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12">
                                                <label class="form-label fw-bold" style="font-size: 20px;">Product Description</label>
                                            </div>
                                            <div class="col-12">
                                                <textarea cols="30" rows="10" class="form-control" id="d"><?php echo $product["description"]; ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <hr class="border-dark" />
                                    </div>

                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12">
                                                <label class="form-label fw-bold" style="font-size: 20px;">Add Product Images</label>
                                            </div>
                                            <div class="offset-lg-3 col-12 col-lg-6">

                                                <?php

                                                $img = array();

                                                $img[0] = "resource/addproductimg.svg";
                                                $img[1] = "resource/addproductimg.svg";
                                                $img[2] = "resource/addproductimg.svg";

                                                $product_img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $product["id"] . "'");
                                                $product_img_num = $product_img_rs->num_rows;

                                                for ($x = 0; $x < $product_img_num; $x++) {
                                                    $product_img_data = $product_img_rs->fetch_assoc();

                                                    $img[$x] = $product_img_data["img_path"];
                                                }

                                                ?>

                                                <div class="row">
                                                    <div class="col-4 border border-dark rounded p-2">
                                                        <img id="i0" src="<?php echo $img[0]; ?>" class="img-fluid" style="width: 250px;" />
                                                    </div>
                                                    <div class="col-4 border border-dark rounded p-2">
                                                        <img id="i1" src="<?php echo $img[1]; ?>" class="img-fluid" style="width: 250px;" />
                                                    </div>
                                                    <div class="col-4 border border-dark rounded p-2">
                                                        <img id="i2" src="<?php echo $img[2]; ?>" class="img-fluid" style="width: 250px;" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="offset-lg-3 col-12 col-lg-6 d-grid mt-3">
                                                <input type="file" class="d-none" id="imageuploader" multiple />
                                                <label for="imageuploader" class="col-12 btn btn-primary" onclick="changeProductImage();">Upload Images</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <hr class="border-dark" />
                                    </div>

                                    <div class="offset-lg-4 col-12 col-lg-4 d-grid mt-3 mb-3">
                                        <button class="btn btn-success" onclick="updateProduct();">Update Product</button>
                                    </div>

                                </div>

                            </div>

                            <div class="col-12">
                                <hr class="border border-dark" />
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <div class="col-12 text-center text-white">
                <p>&copy; 2024 lioncinema.lk | All Rights Reserved</p>
            </div>

            <script src="bootstrap.bundle.js"></script>
            <script src="script.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </body>

        </html>

    <?php

    }
} else {
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'You are not a Valid Admin. Please Sign In.',
            confirmButtonText: 'OK',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then((result) => {
            if (result.isConfirmed || result.isDismissed) {
                window.location = "adminSignin.php";
            }
        });
    </script>
<?php
}

?>