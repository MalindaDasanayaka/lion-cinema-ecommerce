<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Invoice | Lion Cinema</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resource/logos/logo1.png" />
</head>

<body style="background-color: gray;">

    <div class="container-fluid">
        <div class="row">
            <?php include "header.php";

            include "connection.php";

            if (isset($_SESSION["u"])) {
                $umail = $_SESSION["u"]["email"];
                $oid = $_GET["id"];

            ?>

                <div class="col-12">
                    <hr class="border border-1 border-dark" />
                </div>

                <div class="col-12 btn-toolbar justify-content-end">
                    <button class="btn btn-danger me-2" onclick="printInvoice();"><i class="bi bi-printer-fill"></i> Print</button>
                </div>

                <div class="col-12">
                    <hr class="border border-1 border-dark" />
                </div>

                <div class="col-12" id="page">
                    <div class="row">

                        <div class="col-3">
                            <div class="ms-5 invoiceHeaderImage"></div>
                        </div>

                        <div class="offset-6 col-3">
                            <div class="row">
                                <div class="col-12 text-end">
                                    <h1 class="title02 fs-1">Lion <span class="title03 fs-1">Cinema</span></h1>
                                </div>
                                <div class="col-12 fw-bold text-end text-black">
                                    <span>MC Plaza, 18 2nd Floor, Kurunegala.</span><br />
                                    <span>+94 374 758 758</span><br />
                                    <span>lioncinema@gmail.com</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <hr class="border border-1 border-warning" />
                        </div>

                        <div class="col-12 mb-4">
                            <div class="row">

                                <?php

                                $address_rs = Database::search("SELECT * FROM `user_has_address` INNER JOIN `district` ON 
                            user_has_address.district_district_id=district.district_id INNER JOIN `province` ON 
                            district.province_province_id=province.province_id WHERE `user_email`='" . $umail . "'");
                                $address_data = $address_rs->fetch_assoc();

                                ?>

                                <div class="col-6 text-black fw-bold">
                                    <h5 class="fw-bold">INVOICE TO :</h5>
                                    <h2 class="fw-bold"><?php echo $_SESSION["u"]["fname"] . " " . $_SESSION["u"]["lname"]; ?></h2>
                                    <span><?php echo $address_data["line1"] . ", " . $address_data["line2"] . ","; ?></span><br />
                                    <span><?php echo $address_data["city"] . ", " . $address_data["district_name"] . ", " . $address_data["province_name"] . "."; ?></span><br />
                                    <span><?php echo $address_data["postal_code"]; ?></span><br />
                                    <span><?php echo $_SESSION["u"]["mobile"]; ?></span><br />
                                    <span><?php echo $umail; ?></span>
                                </div>

                                <?php

                                $order_rs = Database::search("SELECT * FROM `order` WHERE `order_id`='" . $oid . "'");
                                $order_data = $order_rs->fetch_assoc();

                                ?>

                                <div class="col-6 text-end mt-4">
                                    <h1 style="color: rgb(255, 132, 0);">ORDER #<?php echo $order_data["order_id"]; ?></h1>
                                    <span class="fw-bold text-black">Data & Time of Order : </span>&nbsp;
                                    <span class="fw-bold text-black"><?php echo $order_data["order_date"]; ?></span><br /><br />
                                    <?php

                                    $d = $order_data["order_date"];
                                    $splitDate = explode(" ", $d);
                                    $pdate = $splitDate["0"];

                                    $existingDate = $pdate;
                                    $di = new DateTime($existingDate);

                                    $di->modify('+8 days');
                                    $deliveredDate = $di->format('Y-m-d');

                                    ?>
                                    <span class="fw-bold text-black">Expected Delivery Date : </span>&nbsp;
                                    <span class="fw-bold text-black"><?php echo $deliveredDate ?></span>
                                    <?php

                                    ?>
                                </div>

                                <span class="fw-bold text-black text-center mt-3">**Pre-Order Items will be Delivered within 7 Days after the product been Released**</span>

                            </div>
                        </div>

                        <div class="col-12">
                            <table class="table">
                                <thead>
                                    <tr class="border border-1 border-dark">
                                        <th class="text-start">#</th>
                                        <th class="text-center">Product</th>
                                        <th class="text-center">Unit Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $invoice_rs = Database::search("SELECT * FROM `order` INNER JOIN `invoice` ON order.oid=invoice.order_oid WHERE `order_id`='" . $oid . "'");
                                    $invoice_num = $invoice_rs->num_rows;
                                    for ($x = 0; $x < $invoice_num; $x++) {
                                        $invoice_data = $invoice_rs->fetch_assoc();
                                    ?>
                                        <tr style="height: 50px;" class="text-center border-dark">
                                            <td class="bg-warning text-black fw-bold text-start"><?php echo $x + 1; ?></td>
                                            <td>
                                                <?php

                                                $invoice_sum_rs = Database::search("SELECT SUM(`qty`) AS total_qty FROM `invoice` WHERE `order_oid`='" . $order_data["oid"] . "'");
                                                $invoice_sum_data = $invoice_sum_rs->fetch_assoc();
                                                $invoice_total = (int)$invoice_sum_data['total_qty'];

                                                if ($invoice_total > 5) {

                                                    $total = $invoice_data["amount"];
                                                } else {

                                                    $total = $invoice_data["amount"] - $address_data["delivery_cost"];
                                                }

                                                ?>

                                                <?php
                                                $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $invoice_data["product_id"] . "'");
                                                $product_data = $product_rs->fetch_assoc();

                                                $tot = (intval($product_data["price"]) * intval($invoice_data["qty"]));
                                                ?>
                                                <span class="fw-bold fs-5 text-black p-2"><?php echo $product_data["title"]; ?></span>
                                            </td>
                                            <td class="fw-bold fs-6 text-center pt-3 text-black" style="background-color: rgb(255, 132, 0);">Rs. <?php echo $product_data["price"]; ?> .00</td>
                                            <td class="fw-bold fs-6 text-center pt-3 text-black"><?php echo $invoice_data["qty"]; ?></td>
                                            <td class="fw-bold fs-6 text-end pt-3 text-black" style="background-color: rgb(255, 132, 0);">Rs. <?php echo $tot; ?> .00</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>

                                </tbody>
                                <tfoot>

                                    <?php

                                    if ($invoice_total > 5) {
                                        $delivery = 0;
                                    } else {
                                        $delivery = $address_data["delivery_cost"];
                                    }

                                    $g = $total + $delivery

                                    ?>

                                    <tr>
                                        <td colspan="3" class="border-0"></td>
                                        <td class="fs-5 text-end fw-bold border-dark">SUBTOTAL</td>
                                        <td class="fs-5 text-end fw-bold text-black border-dark">Rs. <?php echo $total; ?> .00</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="border-0"></td>
                                        <td class="fs-5 text-end fw-bold border-dark">Delivery Fee</td>
                                        <td class="fs-5 text-end fw-bold text-black border-dark">Rs. <?php echo $delivery; ?> .00</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="border-0"></td>
                                        <td class="fs-4 text-end fw-bold border-dark">GRAND TOTAL</td>
                                        <td class="fs-4 text-end fw-bold text-black border-dark">Rs. <?php echo $g; ?> .00</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="col-4 text-center" style="margin-top: -100px;">
                            <span class="fs-1 fw-bold text-info">Thank You !</span>
                        </div>

                        <div class="col-12 mt-3 mb-3 border-0 border-start border-5 border-danger rounded" style="background-color: rgb(255, 208, 208);">
                            <div class="row">
                                <div class="col-12 mt-3 mb-3">
                                    <label class="form-label fs-5 fw-bold">NOTICE : </label>
                                    <br />
                                    <label class="form-label fs-6">Purchased items can return befor 7 days of Delivery.</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <hr class="border border-1 border-warning" />
                        </div>

                        <div class="col-12 text-center mb-3">
                            <label class="form-label fs-5 text-black fw-bold">
                                **Invoice was created on a computer and is valid without the Signature and Seal.**
                            </label>
                        </div>

                    </div>
                </div>

            <?php
            }

            ?>

            <?php include "footer.php"; ?>
        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>