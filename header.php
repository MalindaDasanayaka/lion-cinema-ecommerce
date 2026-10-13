<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="style.css" />

</head>

<body>

    <div class="col-12 bg-black">
        <div class="row mt-1 mb-1">

            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">

                    <img src="resource/logos/logo1.png" class="logo1 mx-2" style="height: 50px;">

                    <?php
                    session_start();

                    if (isset($_SESSION["u"])) {
                        $data = $_SESSION["u"];
                    ?>

                        <span class="text-light mx-2">Hello !&nbsp;&nbsp;<span class="title03"> <?php echo $data["fname"]; ?></span></span>
                        <span class="text-light mx-2">Welcome to&nbsp;&nbsp;<span class="title02">Lion</span> <span class="title03">Cinema</span> <span class="title04">&nbsp;&nbsp;DVD STORE</span> </span>
                        <span class="text-danger fw-bold mx-2 mt-1" style="cursor: pointer;" onclick="signout();">Sign Out</span>

                    <?php

                    } else {
                    ?>
                        <span class="text-light mx-2">New to Our Store?</span>
                        <a href="signin.php" class="text-success text-decoration-none fw-bold mx-2" style="cursor: pointer;">Login / Register</a>
                    <?php
                    }
                    ?>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="bi bi-hdd-stack-fill text-light"></i>
                    </button>

                    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link text-light mx-2" href="index.php"><i class="bi bi-house-fill"></i> Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light mx-2" href="userProfile.php"><i class="bi bi-person-circle"></i> My Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light mx-2" href="watchlist.php"><i class="bi bi-heart-fill"></i> Watchlist</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light mx-2" href="cart.php"><i class="bi bi-cart-fill"></i> Cart</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light mx-2" href="purchasedHistory.php"><i class="bi bi-clock-history"></i> Purchased History</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light mx-2" href="#footer"><i class="bi bi-info-circle"></i> Contact Us</a>
                            </li>
                        </ul>
                    </div>


                </div>
            </nav>

        </div>
    </div>


    <script src="script.js"></script>
</body>

</html>