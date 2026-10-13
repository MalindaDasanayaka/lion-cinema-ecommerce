<?php

session_start();
include "connection.php";

if (isset($_SESSION["au"])) {

    $rs = Database::search("SELECT * FROM `product`  ORDER BY `qty_sold` DESC");
    $num = $rs->num_rows;

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Selling Report | Admins | Lion Cinema</title>

        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="style.css" />

        <link rel="icon" href="resource/logos/logo1.png" />

    </head>

    <body class="bg-secondary">

        <div class="container-fluid">

            <div class="row mt-3">
                <div class="col-6 d-flex justify-content-start">
                    <button class="btn btn-dark col-3" onclick="back();"><i class="bi bi-arrow-left"></i> Back</button>
                </div>
                <div class="col-6 d-flex justify-content-end">
                    <button class="btn btn-danger col-3" onclick="printReport();"><i class="bi bi-printer-fill"></i> Print</button>
                </div>
            </div>

            <div class="container-fluid mt-3 bg-light rounded py-3" id="printArea">
                <h2 class="text-center fw-bold text-black mt-4">Selling Report</h2>
                <table class="table table-hover bg-light mt-4 rounded">
                    <thead>
                        <tr>
                            <th scope="col">Product ID</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Qty Sold</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($x = 0; $x < $num; $x++) {
                            $d = $rs->fetch_assoc();
                        ?>
                            <tr>
                                <th scope="row"><?php echo $d["id"]; ?></th>
                                <td><?php echo $d["title"]; ?></td>
                                <td><?php echo $d["qty_sold"]; ?></td>
                                <td>Rs. <?php echo $d["price"]; ?> .00</td>
                                <?php
                                    $total = ($d["qty_sold"] * $d["price"]);
                                ?>
                                <td>Rs. <?php echo $total; ?> .00</td>
                            </tr>
                        <?php
                        }
                        ?>

                    </tbody>
                </table>
            </div>
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