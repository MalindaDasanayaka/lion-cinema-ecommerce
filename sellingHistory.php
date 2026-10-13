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

        <title>Selling History | Admins | Lion Cinema</title>

        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css" />

        <link rel="icon" href="resource/logos/logo1.png" />
    </head>

    <body class="bg-secondary">

        <div class="container-fluid">
            <div class="row">

                <?php include "adminHeader.php"; ?>

                <div class="col-12 text-center">
                    <label class="form-label fs-1 fw-bold text-black">Selling History <i class="bi bi-list-columns-reverse fs-1"></i></label>
                </div>

                <div class="col-12 bg-black text-white mb-3">
                    <div class="row">
                        <div class="col-12 col-lg-3 mt-3 mb-3">
                            <label class="form-label fs-5">Search by Invoice ID : </label>
                            <input type="text" class="form-control fs-5" id="searchtxt" onkeyup="searchInvoice();" />
                        </div>
                        <div class="col-12 col-lg-2 mt-3 mb-3"></div>
                        <div class="col-12 col-lg-3 mt-3 mb-3">
                            <label class="form-label fs-5">From Date : </label>
                            <input type="date" class="form-control fs-5" id="from" />
                        </div>
                        <div class="col-12 col-lg-3 mt-3 mb-3">
                            <label class="form-label fs-5">To Date : </label>
                            <input type="date" class="form-control fs-5" id="to" />
                        </div>
                        <div class="col-12 col-lg-1 mt-3 mb-3 d-grid">
                            <button class="btn btn-warning fs-5 fw-bold" onclick="findSellings();"><i class="bi bi-search"></i>&nbsp;Find</button>
                        </div>
                    </div>
                </div>

                <div class="col-12" id="viewArea">
                    <!-- invoice table -->
                    <table class="table table-hover table-striped-columns border border-dark border-1 text-center" style="background-color: gainsboro;">
                        <thead style="background-color: wheat;">
                            <tr>
                                <th scope="col" class="fs-4 fw-bold">Order ID</th>
                                <th scope="col" class="fs-4 fw-bold">Buyer</th>
                                <th scope="col" class="fs-4 fw-bold">Amount</th>
                                <th scope="col" class="fs-4 fw-bold">Status</th>
                                <th scope="col" class="fs-4 fw-bold">Ordered Date & Time</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            $query = "SELECT * FROM `order` INNER JOIN `delivery_status` ON order.delivery_status_d_id=delivery_status.d_id  ORDER BY `order_date` DESC";
                            $pageno;

                            if (isset($_GET["page"])) {
                                $pageno = $_GET["page"];
                            } else {
                                $pageno = 1;
                            }

                            $invoice_rs = Database::search($query);
                            $invoice_num = $invoice_rs->num_rows;

                            $results_per_page = 20;
                            $number_of_pages = ceil($invoice_num / $results_per_page);

                            $page_results = ($pageno - 1) * $results_per_page;
                            $selected_rs = Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

                            $selected_num = $selected_rs->num_rows;

                            for ($x = 0; $x < $selected_num; $x++) {
                                $selected_data = $selected_rs->fetch_assoc();

                                $invoice_rs = Database::search("SELECT * FROM `invoice` INNER JOIN `product` ON `invoice`.`product_id`=`product`.`id` WHERE `order_oid`='" . $selected_data["oid"] . "'");
                                $invoice_data = $invoice_rs->fetch_assoc();
                            ?>
                                <tr>
                                    <th scope="row" class="fs-4 text-dark selhis" onclick="viewOrderModal('<?php echo $selected_data['oid']; ?>');">
                                        #<?php echo $selected_data["order_id"]; ?>
                                    </th>

                                    <!-- Order Model -->
                                    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="orderModalLabel">Order Details</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="orderModel">
                                                        
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Order Model -->

                                    <?php
                                    $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $selected_data["user_email"] . "'");
                                    $user_data = $user_rs->fetch_assoc();
                                    ?>
                                    <td class="fs-4 selhis" onclick="viewUserModal('<?php echo $user_data['email']; ?>');"><?php echo $user_data["fname"] . " " . $user_data["lname"]; ?></td>
                                    <td class="fs-4">
                                        Rs. <?php echo $selected_data["amount"]; ?> .00

                                    </td>
                                    <td>
                                        <?php
                                        if ($selected_data["delivery_status_d_id"] == 1) {
                                        ?>
                                            <span class="badge rounded-pill fs-6 text-bg-warning"><?php echo $selected_data["status_name"]; ?></span>
                                        <?php
                                        } else if ($selected_data["delivery_status_d_id"] == 2) {
                                        ?>
                                            <span class="badge rounded-pill fs-6 text-bg-dark"><?php echo $selected_data["status_name"]; ?></span>
                                        <?php
                                        } else if ($selected_data["delivery_status_d_id"] == 3) {
                                        ?>
                                            <span class="badge rounded-pill fs-6 text-bg-info"><?php echo $selected_data["status_name"]; ?></span>
                                        <?php
                                        } else if ($selected_data["delivery_status_d_id"] == 4) {
                                        ?>
                                            <span class="badge rounded-pill fs-6 text-bg-success"><?php echo $selected_data["status_name"]; ?></span>
                                        <?php
                                        } else if ($selected_data["delivery_status_d_id"] == 5) {
                                        ?>
                                            <span class="badge rounded-pill fs-6 text-bg-secondary"><?php echo $selected_data["status_name"]; ?></span>
                                        <?php
                                        } else if ($selected_data["delivery_status_d_id"] == 6) {
                                        ?>
                                            <span class="badge rounded-pill fs-6 text-bg-danger"><?php echo $selected_data["status_name"]; ?></span>
                                        <?php
                                        }
                                        ?>

                                    </td>
                                    <td class="fs-4 "><?php echo $selected_data["order_date"]; ?></td>
                                    <td>

                                        <?php

                                        if ($selected_data["delivery_status_d_id"] == 1) {
                                        ?>
                                            <button class="btn btn-success fw-bold" id="btn<?php echo $selected_data["oid"]; ?>" onclick="changeInvoiceStatus('<?php echo $selected_data['oid']; ?>');">Confirm Order</button>
                                            <button class="btn btn-danger fw-bold" onclick="denyOrder('<?php echo $selected_data['oid']; ?>','<?php echo $invoice_data['qty']; ?>');">Deny Order</button>
                                        <?php
                                        } else if ($selected_data["delivery_status_d_id"] == 2) {
                                        ?>
                                            <button class="btn btn-info fw-bold col-8" id="btn<?php echo $selected_data["oid"]; ?>" onclick="changeInvoiceStatus('<?php echo $selected_data['oid']; ?>');">Dispatch</button>
                                        <?php
                                        } else if ($selected_data["delivery_status_d_id"] == 3) {
                                        ?>
                                            <button class="btn btn-warning fw-bold col-8" id="btn<?php echo $selected_data["oid"]; ?>" onclick="changeInvoiceStatus('<?php echo $selected_data['oid']; ?>');">Deliver</button>
                                        <?php
                                        } else if ($selected_data["delivery_status_d_id"] == 6) {
                                        ?>
                                            <button class="btn btn-dark fw-bold col-8" onclick="undoDenyOrder('<?php echo $selected_data['oid']; ?>','<?php echo $invoice_data['qty']; ?>');">Undo</button>
                                        <?php

                                        }

                                        ?>


                                    </td>
                                </tr>

                                <!-- view user model -->
                                <div class="modal fade" tabindex="-1" id="viewUserModal<?php echo $user_data['email']; ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content bg-light">
                                            <div class="modal-header">
                                                <h2 class="modal-title fw-bold"><?php echo $user_data["fname"] . " " . $user_data["lname"]; ?></h2>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="offset-4 col-4">

                                                    <?php
                                                    $image_rs1 = Database::search("SELECT * FROM `profile_img` WHERE `user_email`='" . $user_data["email"] . "'");
                                                    $image_num1 = $image_rs1->num_rows;

                                                    if ($image_num1 == 0) {
                                                    ?>
                                                        <img src="resource/default_icons/default_user.svg" style="height: 150px;" class="img-fluid" />
                                                    <?php
                                                    } else {
                                                        $image_data1 = $image_rs1->fetch_assoc();
                                                    ?>
                                                        <img src="<?php echo $image_data1["path"]; ?>" style="height: 150px;" class="img-fluid" />
                                                    <?php
                                                    }
                                                    ?>

                                                </div>
                                                <div class="col-12">

                                                    <?php
                                                    $address_rs = Database::search("SELECT * FROM `user_has_address` INNER JOIN `district` ON 
                                                    user_has_address.district_district_id=district.district_id INNER JOIN `province` ON 
                                                    district.province_province_id=province.province_id WHERE `user_email`='" . $user_data["email"] . "'");
                                                    $address_data = $address_rs->fetch_assoc();

                                                    ?>

                                                    <span class="fs-5 fw-bold">Delivery Address :</span><br />

                                                    <?php
                                                    if (empty($address_data["city"])) {

                                                    ?>
                                                        <span class="fs-5 text-danger">This User Has not updated his Profile Yet.</span><br /><br />
                                                    <?php

                                                    } else {

                                                    ?>
                                                        <span class="fs-5"><?php echo $address_data['line1']; ?>,</span><br />
                                                        <span class="fs-5"><?php echo $address_data['line2']; ?>,</span><br />
                                                        <span class="fs-5"><?php echo $address_data['city']; ?>,</span><br />
                                                        <span class="fs-5"><?php echo $address_data['district_name']; ?>,</span><br />
                                                        <span class="fs-5"><?php echo $address_data['province_name']; ?>.</span><br />
                                                        <span class="fs-5"><?php echo $address_data['postal_code']; ?></span><br /><br />
                                                    <?php

                                                    }
                                                    ?>

                                                    <span class="fs-5 fw-bold">Contact No :</span>&nbsp;
                                                    <span class="fs-5"><?php echo $user_data['mobile']; ?></span><br />
                                                    <span class="fs-5 fw-bold">Email :</span>&nbsp;
                                                    <span class="fs-5"><?php echo $user_data['email']; ?></span><br />
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- view user model -->

                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- invoice table -->

                    <!-- pagination -->
                    <div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3 mt-3">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination pagination-lg justify-content-center">
                                <li class="page-item">
                                    <a class="page-link" href="
                            <?php if ($pageno <= 1) {
                                echo ("#");
                            } else {
                                echo "?page=" . ($pageno - 1);
                            }
                            ?>
                            " aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php
                                for ($x = 1; $x <= $number_of_pages; $x++) {
                                    if ($x == $pageno) {
                                ?>
                                        <li class="page-item active">
                                            <a class="page-link" href="<?php echo "?page=" . $x; ?>"><?php echo $x; ?></a>
                                        </li>
                                    <?php
                                    } else {
                                    ?>
                                        <li class="page-item">
                                            <a class="page-link" href="<?php echo "?page=" . $x; ?>"><?php echo $x; ?></a>
                                        </li>
                                <?php
                                    }
                                }
                                ?>

                                <li class="page-item">
                                    <a class="page-link" href="
                            <?php if ($pageno >= $number_of_pages) {
                                echo ("#");
                            } else {
                                echo "?page=" . ($pageno + 1);
                            }
                            ?>
                            " aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <!-- pagination -->
                </div>
            </div>
        </div>

        <div class="col-12 text-center text-white">
            <p>&copy; 2024 lioncinema.lk | All Rights Reserved</p>
        </div>

        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
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