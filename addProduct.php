<?php

session_start();
include "connection.php";

if (isset($_SESSION["au"])) {

?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Add Product | Admins | Lion Cinema</title>
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" />
        <link rel="stylesheet" href="style.css" />

        <link rel="icon" href="resource/logos/logo1.png" />

    </head>

    <body class="bg-secondary">

        <div class="container-fluid">
            <div class="row">

                <?php include "adminHeader.php"; ?>

                <div class="col-12 text-center">
                    <label class="form-label fs-1 fw-bold text-black">Add New Product <i class="bi bi-plus-square-fill fs-1"></i></label>
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
                                    <select class="form-select text-center" id="type">
                                        <option value="0">Select Type</option>

                                        <?php
                                        $type_rs = Database::search("SELECT * FROM `type`");
                                        $type_num = $type_rs->num_rows;

                                        for ($x = 0; $x < $type_num; $x++) {
                                            $type_data = $type_rs->fetch_assoc();
                                        ?>
                                            <option value="<?php echo $type_data["type_id"]; ?>">
                                                <?php echo $type_data["type"]; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>

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
                                    <select class="form-select text-center" id="category">
                                        <option value="0">Select Category</option>

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
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="row">

                                <div class="col-12">
                                    <label class="form-label fw-bold" style="font-size: 20px;">Select Product Language</label>
                                </div>

                                <div class="col-12">
                                    <select class="form-select text-center" id="language">
                                        <option value="0">Select Language</option>

                                        <?php
                                        $language_rs = Database::search("SELECT * FROM `language`");
                                        $language_num = $language_rs->num_rows;

                                        for ($x = 0; $x < $language_num; $x++) {
                                            $language_data = $language_rs->fetch_assoc();
                                        ?>
                                            <option value="<?php echo $language_data["language_id"]; ?>">
                                                <?php echo $language_data["language_name"]; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>

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
                                    <input type="text" class="form-control" id="title" />
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
                                        <div class="col-12">
                                            <div class="form-check form-check-inline mx-5">
                                                <input class="form-check-input" type="radio" name="av" id="re" checked />
                                                <label class="form-check-label fw-bold" for="re">Released</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="av" id="cs" />
                                                <label class="form-check-label fw-bold" for="cs">Coming Soon</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-4 border-end border-dark">
                                    <div class="row">

                                        <div class="col-12">
                                            <label class="form-label fw-bold" style="font-size: 20px;">Add Product IMDb Ratings</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" id="ratings" />
                                        </div>

                                    </div>
                                </div>

                                <div class="col-12 col-lg-4">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label fw-bold" style="font-size: 20px;">Add Product Quantity</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="number" class="form-control" value="0" min="0" id="qty" />
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
                                                <input type="text" class="form-control" id="cost" />
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
                                                <input type="text" class="form-control" id="discount" />
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
                                                <input type="date" class="form-control" id="redate" />
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

                                <div class="col-12 col-lg-6 border-end border-dark">
                                    <div class="row">

                                        <div class="col-12">
                                            <label class="form-label fw-bold" style="font-size: 20px;">Add Product Runtime</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" id="runtime" />
                                        </div>

                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label fw-bold" style="font-size: 20px;">Add Product Trailer Link</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" id="trailer" />
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
                                    <textarea cols="30" rows="10" class="form-control" id="desc"></textarea>
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
                                    <div class="row">
                                        <div class="col-4 border border-dark rounded p-2">
                                            <img src="resource/addproduct.svg" class="img-fluid" style="width: 250px;" id="i0" />
                                        </div>
                                        <div class="col-4 border border-dark rounded p-2">
                                            <img src="resource/addproduct.svg" class="img-fluid" style="width: 250px;" id="i1" />
                                        </div>
                                        <div class="col-4 border border-dark rounded p-2">
                                            <img src="resource/addproduct.svg" class="img-fluid" style="width: 250px;" id="i2" />
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
                            <button class="btn btn-success" onclick="addProduct();">Save Product</button>
                        </div>

                    </div>

                </div>

                <div class="col-12">
                    <hr class="border border-dark" />
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