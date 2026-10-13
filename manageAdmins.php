<?php

session_start();
include "connection.php";

if (isset($_SESSION["su"])) {

?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Manage Admins | Super Admin | Lion Cinema</title>

        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="style.css" />

        <link rel="icon" href="resource/logos/logo1.png" />

    </head>

    <body class="bg-secondary">

        <div class="container-fluid">
            <div class="row">

                <div class="col-12 text-center">
                    <label class="form-label fs-1 fw-bold text-black">Manage Admins</label>
                </div>

                <div class="col-12">
                    <table class="table table-hover table-striped-columns border border-dark border-1 text-center" style="background-color: gainsboro;">
                        <thead style="background-color: wheat;">
                            <tr>
                                <th scope="col" class="fs-4 fw-bold">#</th>
                                <th scope="col" class="fs-4 fw-bold">Profile Image</th>
                                <th scope="col" class="fs-4 fw-bold">Admin Name</th>
                                <th scope="col" class="fs-4 fw-bold">Email</th>
                                <th scope="col" class="fs-4 fw-bold">Mobile</th>
                                <th scope="col" class="fs-4 fw-bold">Registered Date & Time</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            $admin_rs = Database::search("SELECT * FROM `admin`");
                            $admin_num = $admin_rs->num_rows;
                            for ($y = 0; $y < $admin_num; $y++) {
                                $admin_data = $admin_rs->fetch_assoc();

                            ?>
                                <tr>
                                    <th scope="row" class="fs-4 text-dark"><?php echo $y + 1; ?></th>
                                    <td>

                                        <?php
                                        $admin_profile_img_rs = Database::search("SELECT * FROM `admin_profile_img` WHERE `admin_email`='" . $admin_data["email"] . "'");
                                        $admin_profile_img_num = $admin_profile_img_rs->num_rows;
                                        $admin_profile_img_data = $admin_profile_img_rs->fetch_assoc();

                                        if ($admin_profile_img_num == 1) {
                                        ?>
                                            <img src="<?php echo $admin_profile_img_data["admin_path"]; ?>" style="height: 50px;" />
                                        <?php
                                        } else {
                                        ?>
                                            <img src="resource/default_icons/default_user.svg" style="height: 50px;" />
                                        <?php
                                        }
                                        ?>

                                    </td>
                                    <td class="fs-4"><?php echo $admin_data["fname"] . " " . $admin_data["lname"]; ?></td>
                                    <td class="fs-4 "><?php echo $admin_data["email"]; ?></td>
                                    <td class="fs-4"><?php echo $admin_data["mobile"]; ?></td>
                                    <td class="fs-4 "><?php echo $admin_data["registered_date"]; ?></td>
                                    <td>

                                        <?php
                                        if ($admin_data["status_status_id"] == 1) {
                                        ?>
                                            <button id="ab<?php echo $admin_data["email"]; ?>" onclick="blockAdmin('<?php echo $admin_data['email']; ?>');" class="btn btn-danger">Block</button>
                                        <?php
                                        } else {
                                        ?>
                                            <button id="ab<?php echo $admin_data["email"]; ?>" onclick="blockAdmin('<?php echo $admin_data['email']; ?>');" class="btn btn-success">Unblock</button>
                                        <?php
                                        }
                                        ?>

                                    </td>
                                </tr>

                            <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>

                <div class="col-12 col-lg-10 offset-lg-1 mb-3">
                    <div class="row">
                        <div class="col-12 col-lg-4 d-grid">
                            <a href="adminRegister.php" class="btn btn-success mt-3 fs-5">
                                <i class="bi bi-person-plus-fill"></i>&nbsp;&nbsp;Register New Admin
                            </a>
                        </div>
                        <div class="col-12 col-lg-4 d-grid">
                            <a href="manageUsers.php" class="btn btn-dark mt-3 fs-5">
                                <i class="bi bi-arrow-left"></i>&nbsp;&nbsp;Back to Manage Users
                            </a>
                        </div>
                        <div class="col-12 col-lg-4 d-grid">
                            <button class="btn btn-danger mt-3 fs-5" onclick="superAdminSignout();">
                                <i class="bi bi-box-arrow-left"></i>&nbsp;&nbsp;Sign Out
                            </button>
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
            text: 'You are not the Super Admin. Please Sign In.',
            confirmButtonText: 'OK',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then((result) => {
            if (result.isConfirmed || result.isDismissed) {
                window.location = "superAdminLogin.php";
            }
        });
    </script>
<?php
}

?>