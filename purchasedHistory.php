<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Purchased History | Lion Cinema</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resource/logos/logo1.png" />
</head>

<body>

    <div class="container-fluid bg-secondary">
        <div class="row">

            <?php include "header.php";

            include "connection.php";
            if (isset($_SESSION["u"])) {
                $mail = $_SESSION["u"]["email"];

                $order_rs = Database::search("SELECT * FROM `order` INNER JOIN `delivery_status` ON
                order.delivery_status_d_id=delivery_status.d_id WHERE `user_email`='" . $mail . "' AND `history_status`='1' ORDER BY `order_date` ASC");
                $order_num = $order_rs->num_rows;

            ?>

                <div class="col-12 pt-2" style="background-color: gainsboro;">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Purchased History</li>
                        </ol>
                    </nav>
                </div>

                <div class="col-12 text-center mb-3">
                    <label class="form-label fs-1 fw-bold text-black">Purchased History <i class="bi bi-clock-history fs-1"></i></label>
                </div>

                <?php

                if ($order_num == 0) {

                ?>
                    <!-- empty view -->
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 defaultHistory"></div>
                            <div class="col-12 text-center mb-2">
                                <label class="form-label fs-1 fw-bold">
                                    You have not purchased any item yet.
                                </label>
                            </div>
                            <div class="offset-lg-4 col-12 col-lg-4 mb-4 d-grid">
                                <a href="index.php" class="btn fs-3 fw-bold border border-1 border-dark" style="background-color: orange;">
                                    Start Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- empty view -->

                    <?php

                } else {

                    for ($i = 0; $i < $order_num; $i++) {
                        $order_data = $order_rs->fetch_assoc();

                    ?>
                        <!-- order history card -->
                        <div class="p-3 border border-3 border-dark rounded-3 mb-2 col-12 col-lg-10 offset-lg-1 mb-4" style="background-color: gainsboro;">
                            <div class="row">
                                <div class="col-4">
                                    <h2 class="fw-bold">ORDER ID <span class="fw-bold fs-4" style="color: rgb(255, 132, 0);">#<?php echo $order_data["order_id"]; ?></span></h2>
                                    <p class="fs-5"><?php echo $order_data["order_date"]; ?></p>
                                    <?php

                                    $d = $order_data["order_date"];
                                    $splitDate = explode(" ", $d);
                                    $pdate = $splitDate["0"];

                                    $existingDate = $pdate;
                                    $di = new DateTime($existingDate);

                                    $di->modify('+8 days');
                                    $deliveredDate = $di->format('Y-m-d');

                                    ?>
                                    <span class="text-black fs-5">Expected Delivery Date : </span>&nbsp;
                                    <span class="fw-bold text-black fs-5"><?php echo $deliveredDate ?></span>
                                    <?php

                                    ?>
                                </div>

                                <div class="col-2">
                                    <?php
                                    if ($order_data["delivery_status_d_id"] == 1) {

                                    ?>
                                        <span class="badge rounded-pill fs-6 text-bg-warning"><?php echo $order_data["status_name"]; ?></span>

                                    <?php

                                    } else if ($order_data["delivery_status_d_id"] == 2) {

                                    ?>
                                        <span class="badge rounded-pill fs-6 text-bg-dark"><?php echo $order_data["status_name"]; ?></span>
                                    <?php

                                    } else if ($order_data["delivery_status_d_id"] == 3) {

                                    ?>
                                        <span class="badge rounded-pill fs-6 text-bg-info"><?php echo $order_data["status_name"]; ?></span>
                                    <?php

                                    } else if ($order_data["delivery_status_d_id"] == 4) {

                                    ?>
                                        <span class="badge rounded-pill fs-6 text-bg-success"><?php echo $order_data["status_name"]; ?></span>
                                    <?php

                                    } else if ($order_data["delivery_status_d_id"] == 5) {

                                    ?>
                                        <span class="badge rounded-pill fs-6 text-bg-secondary"><?php echo $order_data["status_name"]; ?></span>
                                    <?php

                                    } else if ($order_data["delivery_status_d_id"] == 6) {

                                    ?>
                                        <span class="badge rounded-pill fs-6 text-bg-danger" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Please Contact Us for further inquiries"><?php echo $order_data["status_name"]; ?></span>
                                    <?php

                                    }

                                    ?>
                                </div>

                                <?php
                                if ($order_data["delivery_status_d_id"] == 1) {
                                ?>
                                    <div class="col-6 text-end">
                                        <button class="btn btn-secondary col-4 fs-5 me-2" onclick="cancelOrder('<?php echo $order_data['oid']; ?>','<?php echo $invoice_data['qty']; ?>');" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Order can be Cancelled within 24 hours">
                                            <i class="bi bi-x-lg"></i> Cancel Order?
                                        </button>
                                        <button class="btn btn-danger col-3 fs-5" onclick="deleteFromHistory('<?php echo $order_data['oid']; ?>')">
                                            <i class="bi bi-trash3-fill"></i> Delete
                                        </button>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="col-6 text-end">
                                        <button class="btn btn-danger col-3 fs-5" onclick="deleteFromHistory('<?php echo $order_data['oid']; ?>')">
                                            <i class="bi bi-trash3-fill"></i> Delete
                                        </button>
                                    </div>
                                <?php
                                }
                                ?>

                            </div>
                            <div class="row">
                                <div class="ps-5 pe-5">
                                    <table class="table table-hover table-striped-columns border-dark mt-3 text-center">
                                        <thead style="background-color: wheat;">

                                            <?php
                                            if ($order_data["delivery_status_d_id"] == 4) {
                                            ?>
                                                <tr>
                                                    <th scope="col" class="fs-5">#</th>
                                                    <th scope="col" class="fs-5">Product Name</th>
                                                    <th scope="col" class="fs-5">Qty</th>
                                                    <th scope="col" class="fs-5">Price</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            <?php
                                            } else {
                                            ?>
                                                <tr>
                                                    <th scope="col" class="fs-5">#</th>
                                                    <th scope="col" class="fs-5">Product Name</th>
                                                    <th scope="col" class="fs-5">Qty</th>
                                                    <th scope="col" class="fs-5">Price</th>
                                                </tr>
                                            <?php
                                            }
                                            ?>

                                        </thead>
                                        <tbody>
                                            <?php
                                            $invoice_rs = Database::search("SELECT * FROM `invoice` INNER JOIN `product` ON `invoice`.`product_id`=`product`.`id` WHERE `order_oid`='" . $order_data["oid"] . "'");
                                            $invoice_num = $invoice_rs->num_rows;

                                            for ($x = 0; $x < $invoice_num; $x++) {
                                                $invoice_data = $invoice_rs->fetch_assoc();

                                            ?>
                                                <tr>
                                                    <th scope="row" class="fs-4"><?php echo $x + 1; ?></th>
                                                    <th class="fs-4 selhis" onclick='singleProductViewHome(<?php echo $invoice_data["product_id"]; ?>);' style="cursor: pointer;"><?php echo $invoice_data["title"]; ?></th>
                                                    <td class="fs-4"><?php echo $invoice_data["qty"]; ?></td>
                                                    <td class="fs-4">Rs. <?php echo ($invoice_data["qty"] * $invoice_data["price"]); ?> .00</td>

                                                    <?php
                                                    if ($order_data["delivery_status_d_id"] == 4) {
                                                    ?>
                                                        <td><button class="btn btn-secondary" onclick="addFeedback('<?php echo $invoice_data['product_id']; ?>');">
                                                                <i class="bi bi-info-circle-fill"></i> Feedback
                                                            </button>
                                                        </td>
                                                    <?php
                                                    }
                                                    ?>

                                                </tr>

                                                <!-- feedback model -->
                                                <div class="modal fade" tabindex="-1" id="feedbackmodal<?php echo $invoice_data['product_id']; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title fw-bold">Add New Feedback for <span class="fs-5 fw-bold text-primary"><?php echo $invoice_data["title"]; ?></span></h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="row">
                                                                                <div class="col-3">
                                                                                    <label class="form-label fw-bold">Type</label>
                                                                                </div>
                                                                                <div class="col-3">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input" type="radio" name="type" id="type1_<?php echo $invoice_data['product_id']; ?>" />
                                                                                        <label class="form-check-label text-success fw-bold" for="type1_<?php echo $invoice_data['product_id']; ?>">
                                                                                            Positive
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-3">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input" type="radio" name="type" id="type2_<?php echo $invoice_data['product_id']; ?>" checked />
                                                                                        <label class="form-check-label text-warning fw-bold" for="type2_<?php echo $invoice_data['product_id']; ?>">
                                                                                            Neutral
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-3">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input" type="radio" name="type" id="type3_<?php echo $invoice_data['product_id']; ?>" />
                                                                                        <label class="form-check-label text-danger fw-bold" for="type3_<?php echo $invoice_data['product_id']; ?>">
                                                                                            Negative
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="row">
                                                                                <div class="col-3">
                                                                                    <label class="form-label fw-bold">User's Email</label>
                                                                                </div>
                                                                                <div class="col-9">
                                                                                    <input type="text" class="form-control" disabled id="mail" value="<?php echo $mail; ?>" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 mt-2">
                                                                            <div class="row">
                                                                                <div class="col-3">
                                                                                    <label class="form-label fw-bold">Feedback</label>
                                                                                </div>
                                                                                <div class="col-9">
                                                                                    <textarea class="form-control" cols="50" rows="8" id="feed_<?php echo $invoice_data['product_id']; ?>"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-primary" onclick="saveFeedback(<?php echo $invoice_data['product_id']; ?>);">Save Feedback</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- feedback model -->
                                            <?php
                                            }

                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php

                            $address_rs = Database::search("SELECT * FROM `user_has_address` INNER JOIN `district` ON 
                            user_has_address.district_district_id=district.district_id WHERE `user_email`='" . $mail . "'");
                            $address_data = $address_rs->fetch_assoc();

                            $invoice_sum_rs = Database::search("SELECT SUM(`qty`) AS total_qty FROM `invoice` WHERE `order_oid`='" . $order_data["oid"] . "'");
                            $invoice_sum_data = $invoice_sum_rs->fetch_assoc();
                            $invoice_total = (int)$invoice_sum_data['total_qty'];

                            if ($invoice_total > 5) {

                                $delivery = 0;
                            } else {

                                $delivery = $address_data["delivery_cost"];
                            }

                            ?>

                            <div class="row mt-5">
                                <div class="col-2 d-flex flex-column align-items-start ps-5">
                                    <button class="btn btn-primary col-12 fs-5" onclick="invoiceView('<?php echo $order_data['order_id']; ?>');">
                                        <i class="bi bi-filetype-pdf"></i> Invoice
                                    </button>
                                </div>
                                <div class="col-6 d-flex flex-column align-items-center">
                                    <span class="fw-bold text-danger">**Pre-Order Items will be Delivered within 7 Days after the product been Released**</span>
                                </div>
                                <div class="col-4 d-flex flex-column align-items-end pe-5">
                                    <h4>Delivary Fee : <span class="text-black fs-4 fw-bold">Rs. <?php echo $delivery; ?> .00</span></h4>
                                    <h3>Grand Total : <span class="text-success fs-3 fw-bold">Rs. <?php echo $order_data["amount"]; ?> .00</span></h3>
                                </div>
                            </div>
                        </div>

                    <?php

                    }
                    ?>
                    <div class="col-12 mb-3">
                        <div class="row">
                            <div class="offset-lg-10 col-12 col-lg-2 d-grid">
                                <button class="btn btn-danger mt-3 fs-5" onclick="deleteAll();">
                                    <i class="bi bi-trash3-fill"></i> Delete All Records
                                </button>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>

            <?php
            } else {
            ?>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    Swal.fire({
                        icon: 'info',
                        title: 'Please Login or Sign Up',
                        text: 'To view the Purchased History, you need to Login or Sign up.',
                        confirmButtonText: 'OK',
                        allowOutsideClick: false, 
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed || result.isDismissed) {
                            window.location = "signin.php";
                        }
                    });
                </script>
            <?php
            }

            include "footer.php"; ?>

        </div>
        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
            var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl)
            })
        </script>
</body>

</html>