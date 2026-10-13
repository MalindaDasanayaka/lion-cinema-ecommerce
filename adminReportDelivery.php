<?php

session_start();
include "connection.php";

if (isset($_SESSION["au"])) {

    $rs = Database::search("SELECT * FROM `order` INNER JOIN `user` ON order.user_email=user.email INNER JOIN `user_has_address` ORDER BY `order_date` ASC");
    $num = $rs->num_rows;

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Delivery Report | Admins | Lion Cinema</title>

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
                <h2 class="text-center fw-bold text-black mt-4">Delivery Report</h2>
                <table class="table table-hover bg-light mt-4 rounded">
                    <thead>
                        <tr>
                            <th scope="col">Order ID</th>
                            <th scope="col">Order Date</th>
                            <th scope="col">Total</th>
                            <th scope="col">Buyer</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($x = 0; $x < $num; $x++) {
                            $d = $rs->fetch_assoc();
                        ?>
                            <tr>
                                <th scope="row">#<?php echo $d["order_id"]; ?></th>
                                <?php
                                    $date = $d["order_date"];
                                    $splitDate = explode(" ", $date);
                                    $pdate = $splitDate["0"];
                                ?>
                                <td><?php echo $pdate; ?></td>
                                <td>Rs. <?php echo $d["amount"]; ?> .00</td>
                                <td><?php echo $d["fname"]." ".$d["lname"]; ?></td>
                                <td><?php echo $d["mobile"]; ?></td>
                                <td>
                                    <?php echo $d["line1"].", ".$d["line2"].", ".$d["city"].". "; ?>
                                </td>
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