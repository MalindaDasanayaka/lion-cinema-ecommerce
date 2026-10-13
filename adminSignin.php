<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Sign In | lion Cinema</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resource/logos/logo1.png" />
</head>

<body class="main-body">

    <!-- admin signin box -->
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
                                        <p class="title01">Admin Sign In</p>
                                    </div>

                                    <div class="col-12 d-none" id="msgdiv" onclick="window.location.reload();">
                                        <div class="alert alert-danger" role="alert" id="msg">

                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" />
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" />
                                    </div>
                                    <div class="col-12 col-lg-6 d-grid mt-5 mb-3">
                                        <button class="btn fw-bold" style="background-color: rgb(255, 208, 0);" onclick="adminVerification();">Send Verification Code</button>
                                    </div>
                                    <div class="col-12 col-lg-6 d-grid mt-5 mb-3">
                                        <a href="signin.php" class="btn fw-bold" style="background-color: rgb(255, 132, 0);">Back to Customer Login</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- admin signin box -->

    <!-- admin verification model -->
    <div class="modal" tabindex="-1" id="verificationModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Admin Verification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Enter Your Verification Code</label>
                    <input type="text" class="form-control" id="vcode">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="verify();">Verify</button>
                </div>
            </div>
        </div>
    </div>
    <!-- admin verification model -->

    <div class="col-12 fixed-bottom text-center text-white">
        <p>&copy; 2024 lioncinema.lk | All Rights Reserved</p>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>