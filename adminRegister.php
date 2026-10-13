<?php

session_start();
if (isset($_SESSION["su"])) {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Admin Register | Admins | Lion Cinema</title>

        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="style.css" />

        <link rel="icon" href="resource/logos/logo1.png" />

    </head>

    <body class="main-body">

        <div class="offset-1 col-10 signin-body" id="signUpBox">
            <div class="row">
                <div class="card rounded-3 bg-black">
                    <div class="row">
                        <div class="col-lg-6 background rounded-3"></div>
                        <div class="col-lg-6 bg-light rounded-3">
                            <div class="card-body">
                                <div class="col-12">
                                    <div class="row g-3">

                                        <div class="col-12 text-center">
                                            <p class="title01">Register Admin</p>
                                        </div>

                                        <div class="col-12 d-none" id="msgdiv" onclick="window.location.reload();">
                                            <div class="alert alert-danger" role="alert" id="msg">

                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-4">
                                            <label class="form-label">First Name</label>
                                            <input type="text" class="form-control" placeholder="ex:- Sadun" id="fname" />
                                        </div>

                                        <div class="col-12 col-lg-4">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" class="form-control" placeholder="ex:- Perera" id="lname" />
                                        </div>

                                        <div class="col-12 col-lg-4">
                                            <label class="form-label">Mobile</label>
                                            <input type="text" class="form-control" placeholder="ex:- 0777777777" id="mobile" />
                                        </div>

                                        <div class="col-12 col-lg-6">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" placeholder="ex:- sadun@gmail.com" id="email" />
                                        </div>

                                        <div class="col-12 col-lg-6">
                                            <label class="form-label">Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" placeholder="ex:- **********" id="password" />
                                                <span class="input-group-text bg-black" id="basic-addon2">
                                                    <i id="psb" class="bi bi-eye-slash-fill text-white" onclick="showPassword();"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-6 d-grid mt-5 mb-3">
                                            <button class="btn fw-bold" style="background-color: rgb(255, 208, 0);" onclick="adminRegister();">Register</button>
                                        </div>

                                        <div class="col-12 col-lg-6 d-grid mt-5 mb-3">
                                            <a href="manageAdmins.php" class="btn fw-bold" style="background-color: rgb(255, 132, 0);">Back to Manage Admins</a>
                                        </div>

                                    </div>
                                </div>

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