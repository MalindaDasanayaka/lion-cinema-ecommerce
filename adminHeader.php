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
                    <span class="text-light mx-2"><span class="title02">Lion</span> <span class="title03">Cinema</span><span class="title04">&nbsp;&nbsp;&nbsp;Admin Panel</span></span>
                    <span class="text-danger signout fw-bold mx-2 mt-1" style="cursor: pointer;" onclick="adminSignout();">Sign Out</span>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="bi bi-hdd-stack-fill text-light"></i>
                    </button>

                    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link text-light mx-2" href="adminPanel.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light mx-2" href="adminProfile.php"><i class="bi bi-person-circle"></i> Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light mx-2" href="manageUsers.php"><i class="bi bi-people-fill"></i> Manage Users</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light mx-2" href="manageProducts.php"><i class="bi bi-box2-fill"></i> Manage Products</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light mx-2" href="manageDetails.php"><i class="bi bi-table"></i> Manage Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light mx-2" href="addProduct.php"><i class="bi bi-plus-square-fill"></i> Add Products</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light mx-2" href="sellingHistory.php"><i class="bi bi-list-columns-reverse"></i> Selling History</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light mx-2" href="adminReports.php"><i class="bi bi-printer-fill"></i> Reports</a>
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