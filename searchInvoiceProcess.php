<?php

include "connection.php";

if (isset($_GET["order_id"])) {

    $order_id = $_GET["order_id"];

    $selected_rs = Database::search("SELECT * FROM `order` INNER JOIN `delivery_status` ON order.delivery_status_d_id=delivery_status.d_id WHERE `order_id`='" . $order_id . "'");
    $selected_num = $selected_rs->num_rows;

    if ($selected_num == 1) {
        $selected_data = $selected_rs->fetch_assoc();

?>
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
            </tbody>
        </table>
        <!-- invoice table -->

    <?php

    } else {
    ?>
        <div class="d-flex flex-column justify-content-center text-center mt-5 mb-5">
            <div class="col-12 sadface mb-5"></div>
            <h1 class="fw-bold text-black">Invalid Invoice ID</h1>
            <h3 class="fw-bold text-black">This Invoice does not Exists. Please Enter a Valid Invoice ID.</h3>
        </div>
<?php
    }
}

?>