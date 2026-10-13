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

        <title>Admin Panel | Lion Cinema</title>

        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="style.css" />

        <link rel="icon" href="resource/logos/logo1.png" />
    </head>

    <body class="bg-secondary" onload="loadChart();">

        <div class="container-fluid">
            <div class="row">

                <?php include "adminHeader.php"; ?>

                <div class="col-12">
                    <div class="row">

                        <div class="col-12 text-center">
                            <label class="form-label fs-1 fw-bold text-black">Dashboard <i class="bi bi-speedometer2 fs-1"></i></label>
                        </div>

                        <div class="col-12">
                            <hr class="border border-dark" />
                        </div>

                        <!-- most sold chart -->
                        <div class="text-center col-4 offset-1 bg-light mt-1 mb-3 me-4">
                            <h1 class="fw-bold p-3">Mostly Sold Products</h1>
                            <canvas id="soldChart" class="p-3"></canvas>
                        </div>
                        <!-- most sold chart chart -->

                        <!-- Net income chart -->
                        <div class="text-center col-6 bg-light mt-1 mb-3">
                            <h1 class="fw-bold p-3">Daily Income</h1>
                            <canvas id="incomeChart"></canvas>
                        </div>
                        <!-- Net income chart -->

                        <!-- summery boxes -->
                        <div class="col-12 col-lg-10 offset-lg-1">
                            <div class="row g-2">

                                <div class="col-6 col-lg-4 px-2">
                                    <div class="row g-2">
                                        <div class="col-12 bg-warning text-black text-center rounded" style="height: 110px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Daily Earnings</span>

                                            <?php

                                            $today = date("Y-m-d");
                                            $thismonth = date("m");
                                            $thisyear = date("Y");

                                            $der = "0";
                                            $mer = "0";
                                            $yer = "0";
                                            $ter = "0";
                                            $ds = "0";
                                            $ms = "0";
                                            $ys = "0";
                                            $ts = "0";
                                            $den = "0";
                                            $men = "0";
                                            $yen = "0";
                                            $ten = "0";

                                            $invoice_rs = Database::search("SELECT * FROM `order` INNER JOIN `invoice` ON order.oid=invoice.order_oid  WHERE `delivery_status_d_id` != '5' AND `delivery_status_d_id` != '6'");
                                            $invoice_num = $invoice_rs->num_rows;

                                            for ($x = 0; $x < $invoice_num; $x++) {
                                                $invoice_data = $invoice_rs->fetch_assoc();

                                                $ter = $ter + $invoice_data["amount"];
                                                $ts = $ts + $invoice_data["qty"];

                                                $di = $invoice_data["order_date"];
                                                $splitDate = explode(" ", $di);
                                                $pidate = $splitDate["0"];

                                                if ($pidate == $today) {
                                                    $der = $der + $invoice_data["amount"];
                                                    $ds = $ds + $invoice_data["qty"];
                                                }

                                                $splitMonth = explode("-", $pidate);
                                                $piyear = $splitMonth["0"];
                                                $pimonth = $splitMonth["1"];

                                                if ($piyear == $thisyear) {
                                                    if ($pimonth == $thismonth) {
                                                        $mer = $mer + $invoice_data["amount"];
                                                        $ms = $ms + $invoice_data["qty"];
                                                    }

                                                    $yer = $yer + $invoice_data["amount"];
                                                    $ys = $ys + $invoice_data["qty"];
                                                }
                                            }

                                            $user_rs = Database::search("SELECT COUNT(*) as count FROM `user`");
                                            $user_data = $user_rs->fetch_assoc();
                                            $ten = $user_data['count'];

                                            $today_user_rs = Database::search("SELECT COUNT(*) as count FROM `user` WHERE DATE(`joined_date`) = '$today'");
                                            $today_user_data = $today_user_rs->fetch_assoc();
                                            $den = $today_user_data['count'];

                                            $month_user_rs = Database::search("SELECT COUNT(*) as count FROM `user` WHERE MONTH(`joined_date`) = '$thismonth' AND YEAR(`joined_date`) = '$thisyear'");
                                            $month_user_data = $month_user_rs->fetch_assoc();
                                            $men = $month_user_data['count'];

                                            $year_user_rs = Database::search("SELECT COUNT(*) as count FROM `user` WHERE YEAR(`joined_date`) = '$thisyear'");
                                            $year_user_data = $year_user_rs->fetch_assoc();
                                            $yen = $year_user_data['count'];

                                            ?>

                                            <br />
                                            <span class="fs-5">Rs. <?php echo $der; ?> .00</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-4 px-2">
                                    <div class="row g-2">
                                        <div class="col-12 text-black text-center rounded" style="height: 110px; background-color: rgb(255, 132, 0);">
                                            <br />
                                            <span class="fs-4 fw-bold">Daily Sellings</span>
                                            <br />
                                            <span class="fs-5"><?php echo $ds; ?> Copies</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-4 px-2">
                                    <div class="row g-2">
                                        <div class="col-12 bg-light text-black text-center rounded" style="height: 110px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Daily Engagements</span>
                                            <br />
                                            <span class="fs-5"><?php echo $den; ?> Members</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-4 px-2">
                                    <div class="row g-2">
                                        <div class="col-12 bg-warning text-black text-center rounded" style="height: 110px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Monthly Earnings</span>
                                            <br />
                                            <span class="fs-5">Rs. <?php echo $mer; ?> .00</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-4 px-2">
                                    <div class="row g-2">
                                        <div class="col-12 text-black text-center rounded" style="height: 110px; background-color: rgb(255, 132, 0);">
                                            <br />
                                            <span class="fs-4 fw-bold">Monthly Sellings</span>
                                            <br />
                                            <span class="fs-5"><?php echo $ms; ?> Copies</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-4 px-2">
                                    <div class="row g-2">
                                        <div class="col-12 bg-light text-black text-center rounded" style="height: 110px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Monthly Engagements</span>
                                            <br />
                                            <span class="fs-5"><?php echo $men; ?> Members</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-4 px-2">
                                    <div class="row g-2">
                                        <div class="col-12 bg-warning text-black text-center rounded" style="height: 110px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Yearly Earnings</span>
                                            <br />
                                            <span class="fs-5">Rs. <?php echo $yer; ?> .00</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-4 px-2">
                                    <div class="row g-2">
                                        <div class="col-12 text-black text-center rounded" style="height: 110px; background-color: rgb(255, 132, 0);">
                                            <br />
                                            <span class="fs-4 fw-bold">Yearly Sellings</span>
                                            <br />
                                            <span class="fs-5"><?php echo $ys; ?> Copies</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-4 px-2">
                                    <div class="row g-2">
                                        <div class="col-12 bg-light text-black text-center rounded" style="height: 110px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Yearly Engagements</span>
                                            <br />
                                            <span class="fs-5"><?php echo $yen; ?> Members</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-4 px-2">
                                    <div class="row g-2">
                                        <div class="col-12 bg-black text-white text-center rounded" style="height: 110px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Total Earnings</span>
                                            <br />
                                            <span class="fs-5">Rs. <?php echo $ter; ?> .00</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-4 px-2">
                                    <div class="row g-2">
                                        <div class="col-12 bg-black text-white text-center rounded" style="height: 110px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Total Sellings</span>
                                            <br />
                                            <span class="fs-5"><?php echo $ts; ?> Copies</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-4 px-2">
                                    <div class="row g-2">
                                        <div class="col-12 bg-black text-white text-center rounded" style="height: 110px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Total Engagements</span>
                                            <br />
                                            <span class="fs-5"><?php echo $ten; ?> Members</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- summery boxes -->

                        <div class="col-12">
                            <hr class="border border-dark" />
                        </div>

                        <!-- active time -->
                        <div class="col-12 bg-black">
                            <div class="row">
                                <div class="col-12 col-lg-2 text-center my-3">
                                    <label class="form-label fs-4 fw-bold text-white">Active Time</label>
                                </div>
                                <div class="col-12 col-lg-10 text-center my-3">

                                    <?php

                                    $start_date = new DateTime("2024-05-01 00:00:00");

                                    $tdate = new DateTime();
                                    $tz = new DateTimeZone("Asia/Colombo");
                                    $tdate->setTimezone($tz);
                                    $end_date = new DateTime($tdate->format("Y-m-d H:i:s"));

                                    $difference = $end_date->diff($start_date);

                                    ?>

                                    <label class="form-label fs-4 fw-bold text-warning">
                                        <?php
                                        echo $difference->format('%Y') . " Years " . $difference->format('%m') . " Months " .
                                            $difference->format('%d') . " Days " . $difference->format('%H') . " Hours " .
                                            $difference->format('%i') . " Minutes " . $difference->format('%s') . " Seconds ";
                                        ?>

                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- active time -->

                        <div class="col-12 col-lg-10 offset-lg-1">
                            <div class="row">

                                <!-- mostly sold item -->
                                <div class="col-10 offset-1 offset-lg-0 col-lg-6 my-3 bg-light rounded border-end border-5 border-secondary">
                                    <div class="row g-1">

                                        <div class="col-12 text-center">
                                            <label class="form-label fs-4 fw-bold">Mostly Sold Item Today</label>
                                        </div>

                                        <?php

                                        $qty_rs = Database::search("SELECT `product_id`,SUM(`qty`) AS `qty_total` FROM `invoice`
                                        INNER JOIN `order` ON order.oid=invoice.order_oid WHERE `order_date` LIKE '%" . $today . "%' GROUP BY `product_id` ORDER BY `qty_total` DESC LIMIT 1");

                                        $qty_num = $qty_rs->num_rows;

                                        if ($qty_num > 0) {

                                            $qty_data = $qty_rs->fetch_assoc();

                                            $total_rs = Database::search("SELECT SUM(`amount`) AS `grand_total` FROM `order` INNER JOIN `invoice` ON 
                                            order.oid=invoice.order_oid WHERE `product_id`='" . $qty_data["product_id"] . "'");

                                            $total_data = $total_rs->fetch_assoc();

                                            $product_rs = Database::search("SELECT * FROM `product` INNER JOIN `product_img` ON
                                            product.id=product_img.product_id INNER JOIN `invoice` ON 
                                            invoice.product_id=product.id INNER JOIN `order` ON 
                                            order.oid=invoice.order_oid INNER JOIN `user` ON order.user_email=user.email INNER JOIN `profile_img` ON 
                                            user.email=profile_img.user_email WHERE `id`='" . $qty_data["product_id"] . "'");

                                            $product_data = $product_rs->fetch_assoc();

                                        ?>
                                            <div class="col-8 col-lg-4 offset-2 offset-lg-4 text-center shadow bg-white rounded p-2">
                                                <img src="<?php echo $product_data["img_path"]; ?>" class="img-fluid" style="height: 250px;" />
                                            </div>
                                            <div class="col-12 text-center my-3">
                                                <span class="fs-4 fw-bold"><?php echo $product_data["title"]; ?></span><br />
                                                <span class="fs-5"><?php echo $qty_data["qty_total"]; ?> Copies</span><br />
                                                <span class="fs-5">Rs. <?php echo $total_data["grand_total"]; ?> .00</span>
                                            </div>

                                            <div class="col-12 mb-2">
                                                <div class="first-place"></div>
                                            </div>

                                        <?php

                                        } else {

                                        ?>
                                            <!-- empty product -->
                                            <div class="col-8 col-lg-4 offset-2 offset-lg-4 text-center shadow bg-white rounded p-2">
                                                <img src="resource/default_icons/default_image.svg" class="img-fluid rounded-top" style="height: 250px;" />
                                            </div>
                                            <div class="col-12 text-center my-3">
                                                <span class="fs-4 fw-bold">-----</span><br />
                                                <span class="fs-5">--- Copies</span><br />
                                                <span class="fs-5">Rs. ----- .00</span>
                                            </div>
                                            <!-- empty product -->
                                        <?php

                                        }

                                        ?>

                                    </div>
                                </div>
                                <!-- mostly sold item -->

                                <!-- mostly engaged customer -->
                                <div class="col-10 offset-1 offset-lg-0 col-lg-6 my-3 rounded bg-light border-start border-5 border-secondary">
                                    <div class="row g-1">
                                        <div class="col-12 text-center">
                                            <label class="form-label fs-4 fw-bold">Mostly Engaged Customer Today</label>
                                        </div>

                                        <?php

                                        if ($qty_num > 0) {

                                        ?>
                                            <div class="col-8 offset-2 col-lg-6 offset-lg-3 text-center shadow bg-white rounded p-2">
                                                <img src="<?php echo $product_data["path"]; ?>" class="img-fluid rounded-top" style="height: 250px;" />
                                            </div>
                                            <div class="col-12 text-center my-3">
                                                <span class="fs-4 fw-bold"><?php echo $product_data["fname"] . " " . $product_data["lname"]; ?></span><br />
                                                <span class="fs-5"><?php echo $product_data["email"]; ?></span><br />
                                                <span class="fs-5"><?php echo $product_data["mobile"]; ?></span>
                                            </div>

                                            <div class="col-12 mb-2">
                                                <div class="first-place"></div>
                                            </div>

                                        <?php

                                        } else {

                                        ?>
                                            <!-- empty user -->
                                            <div class="col-8 offset-2 col-lg-6 offset-lg-3 text-center shadow bg-white rounded p-2">
                                                <img src="resource/default_icons/default_user.svg" class="img-fluid rounded-top" style="height: 200px;" />
                                            </div>
                                            <div class="col-12 text-center my-3">
                                                <span class="fs-4 fw-bold">----- -----</span><br />
                                                <span class="fs-5">-----</span><br />
                                                <span class="fs-5">----------</span>
                                            </div>
                                            <!-- empty user -->
                                        <?php

                                        }

                                        ?>

                                    </div>
                                </div>
                                <!-- mostly engaged customer -->

                            </div>
                        </div>

                        <div class="col-12">
                            <hr class="border border-dark" />
                        </div>

                        <?php
                        $lowstock_rs = Database::search("SELECT * From `product` WHERE `availability_availability_id`='1' AND `qty_available` <= '100' ORDER BY `qty_available` ASC");
                        $lowstaock_num = $lowstock_rs->num_rows;

                        if ($lowstaock_num > 0) {
                        ?>
                            <!-- low stock products -->

                            <div class="col-12 col-lg-10 offset-lg-1">
                                <h1 class="fw-bold text-black text-center mt-3">Low Stock Items</h1>
                                <div class="row justify-content-center">
                                    <?php
                                    for ($x = 0; $x < $lowstaock_num; $x++) {
                                        $lowstaock_data = $lowstock_rs->fetch_assoc();
                                    ?>
                                        <div class="col-10 offset-1 offset-lg-0 col-lg-3 my-3 rounded bg-light border rounded-3 border-5 border-secondary py-4">
                                            <div class="col-8 offset-2 text-center shadow bg-white rounded p-2">
                                                <?php
                                                $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $lowstaock_data["id"] . "'");
                                                $img_data = $img_rs->fetch_assoc();
                                                ?>

                                                <img src="<?php echo $img_data["img_path"]; ?>" class="img-fluid rounded-top" style="height: 250px;" />
                                            </div>
                                            <div class="col-12 text-center my-3">
                                                <span class="fs-4 fw-bold text-danger"><?php echo $lowstaock_data["qty_available"] ?> Copies Remaining</span>
                                                <button class="btn btn-success col-10 mt-3 fs-5" onclick="sendid(<?php echo $lowstaock_data['id']; ?>);">Update Stock</button>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>

                            <!-- low stock products -->
                        <?php

                        }

                        ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 text-center text-white">
            <p>&copy; 2024 lioncinema.lk | All Rights Reserved</p>
        </div>

        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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