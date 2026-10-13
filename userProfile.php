<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Profile | Lion Cinema</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resource/logos/logo1.png" />

</head>

<body>

    <div class="container-fluid bg-secondary">
        <div class="row">

            <?php include "header.php"; ?>

            <?php

            include "connection.php";

            if (isset($_SESSION["u"])) {

                $email = $_SESSION["u"]["email"];

                $details_rs = Database::search("SELECT * FROM `user` INNER JOIN `gender` ON 
                user.gender_gender_id=gender.gender_id WHERE `email`='" . $email . "'");

                $image_rs = Database::search("SELECT * FROM `profile_img` WHERE `user_email`='" . $email . "'");

                $address_rs = Database::search("SELECT * FROM `user_has_address` INNER JOIN `district` ON
                user_has_address.district_district_id=district.district_id INNER JOIN `province` ON
                district.province_province_id=province.province_id WHERE `user_email`='" . $email . "'");

                $user_details = $details_rs->fetch_assoc();
                $image_details = $image_rs->fetch_assoc();
                $address_details = $address_rs->fetch_assoc();

            ?>

                <div class="col-12 bg-body rounded mt-4 mb-4">
                    <div class="row">

                        <div class="col-12 bg-secondary">
                            <div class="row g-2">

                                <!-- profile image -->
                                <div class="col-md-3">
                                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">

                                        <?php

                                        if (empty($image_details["path"])) {
                                        ?>
                                            <img src="resource/default_icons/default_user.svg" class="rounded mt-5" style="width: 150px;" id="img" />
                                        <?php
                                        } else {
                                        ?>
                                            <img src="<?php echo $image_details["path"]; ?>" class="rounded mt-5" id="img" style="width: 150px;" />
                                        <?php
                                        }

                                        ?>

                                        <span class="fw-bold"><?php echo $user_details["fname"] . " " . $user_details["lname"] ?></span>
                                        <span class="fw-bold text-black-50"><?php echo $email; ?></span>

                                        <input type="file" class="form-control mt-5" id="profileimage" />
                                        <button class="btn btn-warning fw-bold mt-4" onclick="changeProfileImg();">Update Profile Image</button>

                                    </div>
                                </div>
                                <!-- profile image -->

                                <!-- profile settings -->
                                <div class="col-md-8 border border-1 rounded border-dark bg-light">
                                    <div class="px-5 py-5">

                                        <div class="text-center mb-3">
                                            <h2 class="fw-bold">Profile Settings</h2>
                                        </div>

                                        <div class="row">

                                            <div class="col-lg-4 mt-3">
                                                <label class="form-label">First Name</label>
                                                <input id="fname" type="text" class="form-control" value="<?php echo $user_details["fname"]; ?>" />
                                            </div>

                                            <div class="col-lg-4 mt-3">
                                                <label class="form-label">Last Name</label>
                                                <input id="lname" type="text" class="form-control" value="<?php echo $user_details["lname"]; ?>" />
                                            </div>

                                            <div class="col-lg-4 mt-3">
                                                <label class="form-label">Mobile</label>
                                                <input id="mobile" type="text" class="form-control" value="<?php echo $user_details["mobile"]; ?>" />
                                            </div>

                                            <div class="col-lg-6 mt-3">
                                                <label class="form-label">Email</label>
                                                <input type="text" class="form-control" style="background-color: gainsboro;" readonly value="<?php echo $user_details["email"]; ?>" />
                                            </div>

                                            <div class="col-lg-6 mt-3">
                                                <label class="form-label">Password</label>
                                                <div class="input-group">
                                                    <input id="password" type="password" class="form-control" style="background-color: gainsboro;" value="<?php echo $user_details["password"]; ?>" readonly />
                                                    <span class="input-group-text bg-black" id="basic-addon2">
                                                        <i id="psb" class="bi bi-eye-slash-fill text-white" onclick="showPassword();"></i>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 mt-3">
                                                <label class="form-label">Registered Date</label>
                                                <input type="text" class="form-control" style="background-color: gainsboro;" readonly value="<?php echo $user_details["joined_date"]; ?>" />
                                            </div>

                                            <div class="col-lg-6 mt-3">
                                                <label class="form-label">Gender</label>
                                                <input type="text" class="form-control" style="background-color: gainsboro;" value="<?php echo $user_details["gender_name"]; ?>" readonly />
                                            </div>

                                            <div class="col-12 mt-5">
                                                <span class="fs-5 fw-bold">Delivery Address :</span>
                                            </div>

                                            <div class="col-lg-6 mt-4">
                                                <label class="form-label">Address Line 01</label>

                                                <?php
                                                if (empty($address_details["line1"])) {
                                                ?>
                                                    <input id="line1" type="text" class="form-control" />
                                                <?php
                                                } else {
                                                ?>
                                                    <input id="line1" type="text" class="form-control" value="<?php echo $address_details["line1"]; ?>" />
                                                <?php
                                                }
                                                ?>

                                            </div>

                                            <div class="col-lg-6 mt-3">
                                                <label class="form-label">Address Line 02</label>

                                                <?php
                                                if (empty($address_details["line2"])) {
                                                ?>
                                                    <input id="line2" type="text" class="form-control" />
                                                <?php
                                                } else {
                                                ?>
                                                    <input id="line2" type="text" class="form-control" value="<?php echo $address_details["line2"]; ?>" />
                                                <?php
                                                }
                                                ?>

                                            </div>

                                            <div class="col-lg-6 mt-3">
                                                <label class="form-label">City</label>
                                                <?php
                                                if (empty($address_details["city"])) {
                                                ?>
                                                    <input id="city" type="text" class="form-control" />
                                                <?php
                                                } else {
                                                ?>
                                                    <input id="city" type="text" class="form-control" value="<?php echo $address_details["city"]; ?>" />
                                                <?php
                                                }
                                                ?>

                                            </div>

                                            <div class="col-lg-6 mt-3">
                                                <label class="form-label">Postal Code</label>
                                                <?php
                                                if (empty($address_details["postal_code"])) {
                                                ?>
                                                    <input id="pcode" type="text" class="form-control" />
                                                <?php
                                                } else {
                                                ?>
                                                    <input id="pcode" type="text" class="form-control" value="<?php echo $address_details["postal_code"]; ?>" />
                                                <?php
                                                }
                                                ?>
                                            </div>

                                            <?php
                                            $district_rs = Database::search("SELECT * FROM `district`");
                                            $province_rs = Database::search("SELECT * FROM `province`");
                                            ?>

                                            <div class="col-lg-6 mt-3">
                                                <label class="form-label">District</label>
                                                <select class="form-select" id="district">
                                                    <option value="0">Select District</option>
                                                    <?php
                                                    for ($x = 0; $x < $district_rs->num_rows; $x++) {
                                                        $district_data = $district_rs->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo $district_data["district_id"]; ?>" <?php
                                                                                                                        if (!empty($address_details["district_id"])) {
                                                                                                                            if ($district_data["district_id"] == $address_details["district_id"]) {
                                                                                                                        ?>selected<?php
                                                                                                                                }
                                                                                                                            }
                                                                                                                                    ?>>
                                                            <?php echo $district_data["district_name"]; ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>

                                                </select>
                                            </div>

                                            <div class="col-lg-6 mt-3">
                                                <label class="form-label">Province</label>
                                                <select class="form-select" id="province">
                                                    <option value="0">Select Province</option>
                                                    <?php
                                                    for ($x = 0; $x < $province_rs->num_rows; $x++) {
                                                        $province_data = $province_rs->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo $province_data["province_id"]; ?>" <?php
                                                                                                                        if (!empty($address_details["province_id"])) {
                                                                                                                            if ($province_data["province_id"] == $address_details["province_id"]) {
                                                                                                                        ?>selected<?php
                                                                                                                                }
                                                                                                                            }
                                                                                                                                    ?>>
                                                            <?php echo $province_data["province_name"]; ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="offset-lg-3 col-lg-6 d-grid mt-4">
                                                <button class="btn fw-bold" style="background-color: rgb(255, 132, 0);" onclick="updateProfile();">Update My Profile</button>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <!-- profile settings -->

                            </div>
                        </div>

                    </div>
                </div>

            <?php

            } else {
            ?>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    Swal.fire({
                        icon: 'info',
                        title: 'Please Login or Sign Up',
                        text: 'To view the Profile, you need to Login or Sign Up.',
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

            ?>

            <?php include "footer.php"; ?>

        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
</body>

</html>