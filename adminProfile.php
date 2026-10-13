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

        <title>Admin Profile | Admins | Lion Cinema</title>

        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="style.css" />

        <link rel="icon" href="resource/logos/logo1.png" />

    </head>

    <body class="bg-secondary">

        <div class="container-fluid">
            <div class="row">

                <?php include "adminHeader.php"; ?>

                <?php

                $email = $_SESSION["au"]["email"];

                $details_rs = Database::search("SELECT * FROM `admin` WHERE `email`='" . $email . "'");

                $image_rs = Database::search("SELECT * FROM `admin_profile_img` WHERE `admin_email`='" . $email . "'");

                $user_details = $details_rs->fetch_assoc();
                $image_details = $image_rs->fetch_assoc();

                ?>

                <div class="col-12 bg-body rounded mt-4 mb-4">
                    <div class="row">

                        <div class="col-12 bg-secondary">
                            <div class="row g-2">

                                <!-- admin profile image -->
                                <div class="col-md-3">
                                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">

                                        <?php

                                        if (empty($image_details["admin_path"])) {
                                        ?>
                                            <img src="resource/default_icons/default_user.svg" class="rounded mt-5" style="width: 150px;" id="adimg" />
                                        <?php
                                        } else {
                                        ?>
                                            <img src="<?php echo $image_details["admin_path"]; ?>" class="rounded mt-5" id="adimg" style="width: 150px;" />
                                        <?php
                                        }

                                        ?>

                                        <span class="fw-bold"><?php echo $user_details["fname"] . " " . $user_details["lname"] ?></span>
                                        <span class="fw-bold text-black-50"><?php echo $email; ?></span>

                                        <input type="file" class="form-control mt-5" id="adprofileimage" />
                                        <button class="btn btn-warning fw-bold mt-4" onclick="changeAdminProfileImg();">Update Profile Image</button>

                                    </div>
                                </div>
                                <!-- admin profile image -->

                                <!-- admin profile settings -->
                                <div class="col-md-8 border border-1 rounded border-dark bg-light">
                                    <div class="px-5 py-5">

                                        <div class="text-center mb-3">
                                            <h2 class="fw-bold">Profile Settings</h2>
                                        </div>

                                        <div class="row">

                                            <div class="col-lg-4 mt-3">
                                                <label class="form-label">First Name</label>
                                                <input id="adfname" type="text" class="form-control" value="<?php echo $user_details["fname"]; ?>" />
                                            </div>

                                            <div class="col-lg-4 mt-3">
                                                <label class="form-label">Last Name</label>
                                                <input id="adlname" type="text" class="form-control" value="<?php echo $user_details["lname"]; ?>" />
                                            </div>

                                            <div class="col-lg-4 mt-3">
                                                <label class="form-label">Mobile</label>
                                                <input id="admobile" type="text" class="form-control" value="<?php echo $user_details["mobile"]; ?>" />
                                            </div>

                                            <div class="col-lg-6 mt-3">
                                                <label class="form-label">Email</label>
                                                <input type="text" class="form-control" style="background-color: gainsboro;" readonly value="<?php echo $email; ?>" />
                                            </div>

                                            <div class="col-lg-6 mt-3">
                                                <label class="form-label">Password</label>
                                                <div class="input-group">
                                                    <input id="password" type="password" class="form-control" value="<?php echo $user_details["password"]; ?>" />
                                                    <span class="input-group-text bg-black" id="basic-addon2">
                                                        <i id="psb" class="bi bi-eye-slash-fill text-white" onclick="showPassword();"></i>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 offset-lg-3 mt-3">
                                                <label class="form-label">Registered Date</label>
                                                <input type="text" class="form-control" style="background-color: gainsboro;" readonly value="<?php echo $user_details["registered_date"]; ?>" />
                                            </div>

                                            <div class="offset-lg-3 col-lg-6 d-grid mt-4">
                                                <button class="btn fw-bold" style="background-color: rgb(255, 132, 0);" onclick="updateAdminProfile();">Update My Profile</button>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <!-- admin profile settings -->

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 fixed-bottom text-center text-white">
            <p>&copy; 2024 lioncinema.lk | All Rights Reserved</p>
        </div>

        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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