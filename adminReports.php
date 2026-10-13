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

        <title>Reports | Admins | Lion Cinema</title>

        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="style.css" />

        <link rel="icon" href="resource/logos/logo1.png" />

    </head>

    <body class="bg-secondary">

        <div class="container-fluid">
            <div class="row">

                <?php include "adminHeader.php"; ?>

                <div class="row reportsBody">

                    <div class="col-10">

                        <h1 class="form-label fw-bold text-black text-center">Reports <i class="bi bi-printer-fill fs-1"></i></h1>

                        <div class="row mt-5 mb-5">
                            <div class="col-12 col-md-4 mt-5 mb-5">
                                <a href="adminReportSelling.php"><button class="btn btn-warning col-12 fw-bold fs-3">Selling Report</button></a>
                            </div>
                            <div class="col-12 col-md-4 mt-5 mb-5">
                                <a href="adminReportInvoice.php"><button class="btn col-12 fw-bold fs-3" style="background-color: rgb(255, 132, 0);">Invoice Report</button></a>
                            </div>
                            <div class="col-12 col-md-4 mt-5 mb-5">
                                <a href="adminReportDelivery.php"><button class="btn btn-light col-12 fw-bold fs-3">Delivery Report</button></a>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-12 col-md-4 mb-5">
                                <a href="adminReportStock.php"><button class="btn col-12 fw-bold fs-3 text-white" style="background-color: black">Stock Report</button></a>
                            </div>
                            <div class="col-12 col-md-4 mb-5">
                                <a href="adminReportProduct.php"><button class="btn btn-danger col-12 fw-bold fs-3">Product Report</button></a>
                            </div>
                            <div class="col-12 col-md-4 mb-5">
                                <a href="adminReportUser.php"><button class="btn btn-info col-12 fw-bold fs-3">User Report</button></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 text-center text-white mt-3 fixed-bottom">
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