<?php

include "connection.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sign In | Lion Cinema</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resource/logos/logo1.png" />

</head>

<body class="main-body">

    <!-- signin box -->
    <div class="offset-1 col-10 signin-body" id="signInBox">
        <div class="row">
            <div class="card rounded-3 bg-black">
                <div class="row">
                    <div class="col-lg-6 background rounded-3"></div>
                    <div class="col-lg-6 bg-light rounded-3">
                        <div class="card-body">
                            <div class="col-12">
                                <div class="row g-3">
                                    <div class="col-12 text-center">
                                        <p class="title01">Sign In</p>
                                    </div>

                                    <div class="col-12 d-none" id="msgdiv" onclick="window.location.reload();">
                                        <div class="alert alert-danger" role="alert" id="msg">

                                        </div>
                                    </div>

                                    <?php
                                    $email = "";
                                    $password = "";

                                    if (isset($_COOKIE["email"])) {
                                        $email = $_COOKIE["email"];
                                    }

                                    if (isset($_COOKIE["password"])) {
                                        $password = $_COOKIE["password"];
                                    }
                                    ?>


                                    <div class="col-12">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" value="<?php echo $email; ?>" />
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" value="<?php echo $password; ?>" />
                                            <span class="input-group-text bg-black" id="basic-addon2">
                                                <i id="psb" class="bi bi-eye-slash-fill text-white" onclick="showPassword();"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="rememberme" />
                                            <label class="form-check-label">Remember Me</label>
                                        </div>
                                    </div>
                                    <div class="col-6 text-end">
                                        <a href="#" class="link-primary text-decoration-none" onclick="forgotPassword();">Forgot Password?</a>
                                    </div>
                                    <div class="col-12 col-lg-6 d-grid mt-5 mb-3">
                                        <button class="btn fw-bold" style="background-color: rgb(255, 208, 0);" onclick="signin();">Sign In</button>
                                    </div>
                                    <div class="col-12 col-lg-6 d-grid mt-5 mb-3">
                                        <button class="btn fw-bold" style="background-color: rgb(255, 132, 0);" onclick="changeView();">New to Store? Sign Up</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- signin box -->

    <!-- signup box -->
    <div class="offset-1 col-10 signin-body d-none" id="signUpBox">
        <div class="row">
            <div class="card rounded-3 bg-black">
                <div class="row">
                    <div class="col-lg-6 background rounded-3"></div>
                    <div class="col-lg-6 bg-light rounded-3">
                        <div class="card-body">
                            <div class="col-12">
                                <div class="row g-3">

                                    <div class="col-12 text-center">
                                        <p class="title01">Sign Up</p>
                                    </div>

                                    <div class="col-12 d-none" id="msgdiv1" onclick="window.location.reload();">
                                        <div class="alert alert-danger" role="alert" id="msg1">

                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control" placeholder="ex:- Sadun" id="fname" />
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control" placeholder="ex:- Perera" id="lname" />
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" placeholder="ex:- sadun@gmail.com" id="email1" />
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" placeholder="ex:- **********" id="password1" />
                                            <span class="input-group-text bg-black" id="basic-addon2">
                                                <i id="psb1" class="bi bi-eye-slash-fill text-white" onclick="showPassword1();"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label">Mobile</label>
                                        <input type="text" class="form-control" placeholder="ex:- 0777777777" id="mobile" />
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label">Gender</label>
                                        <select class="form-control" id="gender">

                                            <?php

                                            $rs = Database::search("SELECT * FROM `gender`");
                                            $num = $rs->num_rows;

                                            for ($x = 0; $x  < $num; $x++) {
                                                $data = $rs->fetch_assoc();
                                            ?>

                                                <option value="<?php echo $data["gender_id"]; ?>">
                                                    <?php echo $data["gender_name"]; ?>
                                                </option>

                                            <?php
                                            }
                                            ?>

                                        </select>
                                    </div>

                                    <div class="col-12 col-lg-6 d-grid mt-5 mb-3">
                                        <button class="btn fw-bold" style="background-color: rgb(255, 208, 0);" onclick="signup();">Sign Up</button>
                                    </div>
                                    <div class="col-12 col-lg-6 d-grid mt-5 mb-3">
                                        <button class="btn fw-bold" style="background-color: rgb(255, 132, 0);" onclick="changeView();">Have an account? Sign In</button>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- signup box -->

    <!-- forgot password modal -->
    <div class="modal" tabindex="-1" id="fpmodal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Forgot Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row g-6">

                        <div class="col-6">
                            <label class="form-label">New Password</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" id="np" />
                                <span class="input-group-text bg-black" id="basic-addon2">
                                    <i id="npb" class="bi bi-eye-slash-fill text-white" onclick="showPassword2();"></i>
                                </span>
                            </div>
                        </div>

                        <div class="col-6">
                            <label class="form-label">Re-type Password</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" id="rnp" />
                                <span class="input-group-text bg-black" id="basic-addon2">
                                    <i id="rnpb" class="bi bi-eye-slash-fill text-white" onclick="showPassword3();"></i>
                                </span>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Verification Code</label>
                            <input type="text" class="form-control" id="vcode" />
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="resetPassword();">Reset</button>
                </div>
            </div>
        </div>
    </div>
    <!-- forgot password modal -->

    <div class="col-12 fixed-bottom text-center text-white">
        <p>&copy; 2024 lioncinema.lk | All Rights Reserved</p>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>