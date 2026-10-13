<?php

include "connection.php";

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Advanced Search | Lion Cinema</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resource/logos/logo1.png" />

</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <?php include "header.php"; ?>

            <div class="col-12 pt-2" style="background-color: gainsboro;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Filter</li>
                    </ol>
                </nav>
            </div>

            <div class="col-12 col-lg-2 bg-black">
                <div class="col-12 mt-5 p-3">
                    <div class="row g-3">
                        <div class="col-12">
                            <select class="form-select" id="ty">
                                <option value="0">Select Type</option>

                                <?php

                                $type_rs = Database::search("SELECT * FROM `type`");
                                $type_num = $type_rs->num_rows;

                                for ($x = 0; $x < $type_num; $x++) {
                                    $type_data = $type_rs->fetch_assoc();
                                ?>
                                    <option value="<?php echo $type_data["type_id"]; ?>">
                                        <?php echo $type_data["type"]; ?>
                                    </option>
                                <?php
                                }
                                ?>

                            </select>
                        </div>

                        <div class="col-12">
                            <select class="form-select" id="cat">
                                <option value="0">Select Category</option>

                                <?php

                                $category_rs = Database::search("SELECT * FROM `category`");
                                $category_num = $category_rs->num_rows;

                                for ($y = 0; $y < $category_num; $y++) {
                                    $category_data = $category_rs->fetch_assoc();
                                ?>
                                    <option value="<?php echo $category_data["category_id"]; ?>">
                                        <?php echo $category_data["category_name"]; ?>
                                    </option>
                                <?php
                                }
                                ?>

                            </select>
                        </div>

                        <div class="col-12">
                            <select class="form-select" id="lan">
                                <option value="0">Select Language</option>

                                <?php

                                $language_rs = Database::search("SELECT * FROM `language`");
                                $language_num = $language_rs->num_rows;

                                for ($z = 0; $z < $language_num; $z++) {
                                    $language_data = $language_rs->fetch_assoc();
                                ?>
                                    <option value="<?php echo $language_data["language_id"]; ?>">
                                        <?php echo $language_data["language_name"]; ?>
                                    </option>
                                <?php
                                }
                                ?>

                            </select>
                        </div>

                        <div class="col-12">
                            <select class="form-select" id="av">
                                <option value="0">Select Availability</option>

                                <?php

                                $availability_rs = Database::search("SELECT * FROM `availability`");
                                $availability_num = $availability_rs->num_rows;

                                for ($e = 0; $e < $availability_num; $e++) {
                                    $availability_data = $availability_rs->fetch_assoc();
                                ?>
                                    <option value="<?php echo $availability_data["availability_id"]; ?>">
                                        <?php echo $availability_data["availability"]; ?>
                                    </option>
                                <?php
                                }
                                ?>

                            </select>
                        </div>

                        <div class="col-12">
                            <input type="text" class="form-control" placeholder="Type Released Year..." id="ry" />
                        </div>

                        <div class="col-12 col-lg-6">
                            <input type="text" class="form-control" placeholder="Price From..." id="pf" />
                        </div>

                        <div class="col-12 col-lg-6">
                            <input type="text" class="form-control" placeholder="Price To..." id="pt" />
                        </div>

                        <div class="col-12 text-light text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="r" id="10" />
                                <label class="form-check-label fw-bold" for="10"><i class="bi bi-star-fill text-warning"></i>&nbsp;10 - 9</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="r" id="9" />
                                <label class="form-check-label fw-bold" for="9"><i class="bi bi-star-fill text-warning"></i>&nbsp;9 - 8</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="r" id="8" />
                                <label class="form-check-label fw-bold" for="8"><i class="bi bi-star-fill text-warning"></i>&nbsp;8 - 7</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="r" id="7" />
                                <label class="form-check-label fw-bold" for="7"><i class="bi bi-star-fill text-warning"></i>&nbsp;7 - 6</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="r" id="6" />
                                <label class="form-check-label fw-bold" for="6"><i class="bi bi-star-fill text-warning"></i>&nbsp;6 - 5</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="r" id="5" />
                                <label class="form-check-label fw-bold" for="5"><i class="bi bi-star-fill text-warning"></i>&nbsp;5 - 4</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="r" id="l4" />
                                <label class="form-check-label fw-bold" for="l4"> < <i class="bi bi-star-fill text-warning"></i>&nbsp;4
                                </label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-12 mt-3">
                    <div class="row">
                        <div class="col-12">
                            <select class="form-select" id="s">
                                <option value="0">SORT BY</option>
                                <option value="1">PRICE LOW TO HIGH</option>
                                <option value="2">PRICE HIGH TO LOW</option>
                                <option value="3">QUANTITY HIGH TO LOW</option>
                                <option value="4">QUANTITY LOW TO HIGH</option>
                                <option value="5">RATINGS LOW TO HIGH</option>
                                <option value="6">RATINGS HIGH TO LOW</option>
                                <option value="7">RELEASED DATE NEW TO OLD</option>
                                <option value="8">RELEASED DATE OLD TO NEW</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-5 mb-5">
                    <div class="row g-3">
                        <div class="col-12 col-lg-6 d-grid">
                            <button class="btn btn-success" onclick="advancedSearch(0);">Apply</button>
                        </div>
                        <div class="col-12 col-lg-6 d-grid">
                            <button class="btn btn-danger" onclick="window.location.reload();">Clear</button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-12 col-lg-10 bg-secondary">
                <div class="row">
                    <div class="col-12 text-center">
                        <label class="form-label fs-1 fw-bold text-black">Filter Products <i class="bi bi-funnel-fill fs-1"></i></label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row bg-black">
                        <div class="offset-lg-1 col-12 col-sm-10 col-lg-8 p-3">
                            <input type="text" class="form-control bg-light" placeholder="Type keyword to search..." id="ad_text" />
                        </div>
                        <div class="col-12 col-sm-2 d-grid p-3">
                            <button class="btn btn-warning fw-bold" onclick="advancedSearch(0);"><i class="bi bi-search"></i>&nbsp;Search</button>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="row justify-content-center gap-1" id="view_area">
                        <div class="col-12 search mt-5 mb-5"></div>
                        <div class="col-12 text-center">
                            <label class="form-label fs-1 fw-bold">No Items Searched Yet...</label>
                        </div>
                    </div>
                </div>

            </div>

            <?php include "footer.php"; ?>

        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>