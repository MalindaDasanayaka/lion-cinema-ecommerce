<?php

session_start();
include "connection.php";

if (isset($_SESSION["au"])) {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Manage Details | Admins | Lion Cinema</title>

        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="style.css" />

        <link rel="icon" href="resource/logos/logo1.png" />

    </head>

    <body class="bg-secondary">

        <div class="container-fluid">
            <div class="row">

                <?php include "adminHeader.php"; ?>

                <div class="col-12 text-center">
                    <label class="form-label fs-1 fw-bold text-black">Manage Details <i class="bi bi-table fs-1"></i></label>
                </div>

                <div class="col-12">
                    <hr class="border border-dark" />
                </div>

                <div class="col-12 col-lg-10 offset-lg-1">
                    <div class="row">

                        <div class="col-12 col-lg-6">
                            <!-- Type Register -->
                            <div class="col-10 offset-1 mt-2 mb-5 bg-light p-4 rounded border">

                                <div class="text-center">
                                    <label for="form-label" class="fs-3 fw-bold mb-3">Type</label>
                                </div>
                                <input type="text" class="form-control mb-3 fs-5" id="ty" />

                                <div class="d-none" id="msgDiv1" onclick="window.location.reload();">
                                    <div class="alert alert-danger" id="msg1"></div>
                                </div>

                                <div class="mt-4">
                                    <button class="btn btn-success col-12 fs-5" onclick="typeReg();">Register Type</button>
                                </div>

                            </div>
                            <!-- Type Register -->

                            <!-- Category Register -->
                            <div class="col-10 offset-1 mt-5 mb-5 bg-light p-4 rounded border">

                                <div class="text-center">
                                    <label for="form-label" class="fs-3 fw-bold mb-3">Category</label>
                                </div>
                                <input type="text" class="form-control mb-3 fs-5" id="cat" />

                                <div class="d-none" id="msgDiv2" onclick="window.location.reload();">
                                    <div class="alert alert-danger" id="msg2"></div>
                                </div>

                                <div class="mt-4">
                                    <button class="btn btn-success col-12 fs-5" onclick="categoryReg();">Register Category</button>
                                </div>

                            </div>
                            <!-- Category Register -->

                            <!-- Language Register -->
                            <div class="col-10 offset-1 mt-5 mb-5 bg-light p-4 rounded border">

                                <div class="text-center">
                                    <label for="form-label" class="fs-3 fw-bold mb-3">Language</label>
                                </div>
                                <input type="text" class="form-control mb-3 fs-5" id="lan" />

                                <div class="d-none" id="msgDiv3" onclick="window.location.reload();">
                                    <div class="alert alert-danger" id="msg3"></div>
                                </div>

                                <div class="mt-4">
                                    <button class="btn btn-success col-12 fs-5" onclick="languageReg();">Register Language</button>
                                </div>

                            </div>
                            <!-- Language Register -->

                            <!-- Set Discount All -->
                            <div class="col-10 offset-1 mt-5 mb-5 bg-light p-4 rounded border">

                                <div class="text-center">
                                    <label for="form-label" class="fs-3 fw-bold mb-3">Set Discount For All Products</label>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control fs-5" id="dis" />
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>

                                <div class="d-none" id="msgDiv4" onclick="window.location.reload();">
                                    <div class="alert alert-danger" id="msg4"></div>
                                </div>

                                <div class="mt-4">
                                    <button class="btn btn-success col-12 fs-5" onclick="setDiscount();">Set Discount</button>
                                </div>

                            </div>
                            <!-- Set Discount All -->
                        </div>

                        <div class="col-12 col-lg-6">
                            <!-- Deliver Cost Update  -->
                            <div class="col-10 offset-1 mt-2 bg-light p-4 rounded border">

                                <div class="text-center">
                                    <label for="form-label" class="fs-3 fw-bold mb-3">Delivery Cost</label>
                                </div>
                                <div class="d-none" id="msgDiv5" onclick="window.location.reload();">
                                    <div class="alert alert-danger" id="msg5"></div>
                                </div>

                                <?php
                                $delivery_rs = Database::search("SELECT * FROM `district`");
                                $delivery_num = $delivery_rs->num_rows;
                                for ($x = 0; $x < $delivery_num; $x++) {
                                    $delivery_data = $delivery_rs->fetch_assoc();
                                ?>

                                    <div class="input-group mt-2 mb-2">
                                        <span class="input-group-text bg-warning fw-bold"><?php echo $delivery_data["district_name"]; ?></span>
                                        <span class="input-group-text">Rs.</span>
                                        <input type="text" class="form-control" value="<?php echo $delivery_data["delivery_cost"]; ?>" id="delivery<?php echo $delivery_data["district_id"] ?>" />
                                        <span class="input-group-text">.00</span>
                                        <button class="btn btn-dark" onclick="deliveryUpdate(<?php echo $delivery_data['district_id'] ?>);">Update</button>
                                    </div>

                                <?php
                                }
                                ?>

                            </div>
                            <!-- Deliver Cost Update -->
                        </div>

                    </div>



                </div>

            </div>
        </div>

        <div class="col-12 text-center text-white mt-3">
            <p>&copy; 2024 lioncinema.lk | All Rights Reserved</p>
        </div>

        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>

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