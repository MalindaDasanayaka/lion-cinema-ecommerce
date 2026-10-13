<?php
include "connection.php";

$txt = $_POST["t"];

$query = "SELECT * FROM `user`";

if (!empty($txt)) {
    $query .= "WHERE `fname` LIKE '%" . $txt . "%'";
}

$pageno;

if ("0" != ($_POST["page"])) {
    $pageno = $_POST["page"];
} else {
    $pageno = 1;
}

$user_rs = Database::search($query);
$user_num = $user_rs->num_rows;

$results_per_page = 20;
$number_of_pages = ceil($user_num / $results_per_page);

$page_results = ($pageno - 1) * $results_per_page;
$selected_rs = Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

$selected_num = $selected_rs->num_rows;

if ($selected_num == 0) {
?>
    <div class="d-flex flex-column justify-content-center text-center mt-5 mb-5">
        <div class="col-12 sadface mb-5"></div>
        <h1 class="fw-bold text-black">Search No User</h1>
        <h3 class="fw-bold text-black">We're Sorry, We cannot find any User for your search term..</h3>
    </div>
<?php
} else {

?>

    <!-- user table -->
    <div class="col-12" id="userSearchResult">
        <table class="table table-hover table-striped-columns border border-dark border-1 text-center" style="background-color: gainsboro;">
            <thead style="background-color: wheat;">
                <tr>
                    <th scope="col" class="fs-4 fw-bold">#</th>
                    <th scope="col" class="fs-4 fw-bold">Profile Image</th>
                    <th scope="col" class="fs-4 fw-bold">User Name</th>
                    <th scope="col" class="fs-4 fw-bold">Email</th>
                    <th scope="col" class="fs-4 fw-bold">Mobile</th>
                    <th scope="col" class="fs-4 fw-bold">Registered Date & Time</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>

                <?php

                for ($x = 0; $x < $selected_num; $x++) {
                    $selected_data = $selected_rs->fetch_assoc();

                ?>

                    <tr>
                        <th scope="row" class="fs-4 text-dark"><?php echo $x + 1; ?></th>
                        <td onmouseover="viewUserModal('<?php echo $selected_data['email']; ?>');">

                            <?php
                            $profile_img_rs = Database::search("SELECT * FROM `profile_img` WHERE `user_email`='" . $selected_data["email"] . "'");
                            $profile_img_num = $profile_img_rs->num_rows;
                            $profile_img_data = $profile_img_rs->fetch_assoc();

                            if ($profile_img_num == 1) {
                            ?>
                                <img src="<?php echo $profile_img_data["path"]; ?>" style="height: 50px;" />
                            <?php
                            } else {
                            ?>
                                <img src="resource/default_icons/default_user.svg" style="height: 50px;" />
                            <?php
                            }
                            ?>

                        </td>
                        <td class="fs-4"><?php echo $selected_data["fname"] . " " . $selected_data["lname"]; ?></td>
                        <td class="fs-4 "><?php echo $selected_data["email"]; ?></td>
                        <td class="fs-4"><?php echo $selected_data["mobile"]; ?></td>
                        <td class="fs-4 "><?php echo $selected_data["joined_date"]; ?></td>
                        <td>

                            <?php
                            if ($selected_data["status_status_id"] == 1) {
                            ?>
                                <button id="ub<?php echo $selected_data["email"]; ?>" onclick="blockUser('<?php echo $selected_data['email']; ?>');" class="btn btn-danger">Block</button>
                            <?php
                            } else {
                            ?>
                                <button id="ub<?php echo $selected_data["email"]; ?>" onclick="blockUser('<?php echo $selected_data['email']; ?>');" class="btn btn-success">Unblock</button>
                            <?php
                            }
                            ?>

                        </td>
                    </tr>

                    <!-- view user model -->
                    <div class="modal fade" tabindex="-1" id="viewUserModal<?php echo $selected_data['email']; ?>">
                        <div class="modal-dialog">
                            <div class="modal-content bg-light">
                                <div class="modal-header">
                                    <h2 class="modal-title fw-bold"><?php echo $selected_data["fname"] . " " . $selected_data["lname"]; ?></h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="offset-4 col-4">

                                        <?php
                                        $image_rs1 = Database::search("SELECT * FROM `profile_img` WHERE `user_email`='" . $selected_data["email"] . "'");
                                        $image_num1 = $image_rs1->num_rows;

                                        if ($image_num1 == 0) {
                                        ?>
                                            <img src="resource/default_icons/default_user.svg" style="height: 150px;" class="img-fluid" />
                                        <?php
                                        } else {
                                            $image_data1 = $image_rs1->fetch_assoc();
                                        ?>
                                            <img src="<?php echo $image_data1["path"]; ?>" style="height: 150px;" class="img-fluid" />
                                        <?php
                                        }
                                        ?>

                                    </div>
                                    <div class="col-12">

                                        <?php
                                        $address_rs = Database::search("SELECT * FROM `user_has_address` INNER JOIN `district` ON 
                                                    user_has_address.district_district_id=district.district_id INNER JOIN `province` ON 
                                                    district.province_province_id=province.province_id WHERE `user_email`='" . $selected_data["email"] . "'");
                                        $address_data = $address_rs->fetch_assoc();

                                        ?>

                                        <span class="fs-5 fw-bold">Delivery Address :</span><br />

                                        <?php
                                        if (empty($address_data["city"])) {

                                        ?>
                                            <span class="fs-5 text-danger">This User Has not updated his Profile Yet.</span><br /><br />
                                        <?php

                                        } else {

                                        ?>
                                            <span class="fs-5"><?php echo $address_data['line1']; ?>,</span><br />
                                            <span class="fs-5"><?php echo $address_data['line2']; ?>,</span><br />
                                            <span class="fs-5"><?php echo $address_data['city']; ?>,</span><br />
                                            <span class="fs-5"><?php echo $address_data['district_name']; ?>,</span><br />
                                            <span class="fs-5"><?php echo $address_data['province_name']; ?>.</span><br />
                                            <span class="fs-5"><?php echo $address_data['postal_code']; ?></span><br /><br />
                                        <?php

                                        }
                                        ?>

                                        <span class="fs-5 fw-bold">Contact No :</span>&nbsp;
                                        <span class="fs-5"><?php echo $selected_data['mobile']; ?></span><br />
                                        <span class="fs-5 fw-bold">Email :</span>&nbsp;
                                        <span class="fs-5"><?php echo $selected_data['email']; ?></span><br />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- view user model -->

                <?php
                }
                ?>

            </tbody>
        </table>
    </div>
    <!-- user table -->

    <!-- pagination -->
    <div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3">
        <nav aria-label="Page navigation example">
            <ul class="pagination pagination-lg justify-content-center">
                <li class="page-item">
                    <a class="page-link" <?php if ($pageno <= 1) {
                                                echo ("#");
                                            } else {
                                            ?> onclick="searchUser(<?php echo ($pageno - 1); ?>);" ; <?php
                                                                                                    }
                                                                                                        ?> aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php
                for ($x = 1; $x <= $number_of_pages; $x++) {
                    if ($x == $pageno) {
                ?>
                        <li class="page-item active">
                            <a class="page-link" onclick="searchUser(<?php echo $x; ?>);"><?php echo $x; ?></a>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="page-item">
                            <a class="page-link" onclick="searchUser(<?php echo $x; ?>);"><?php echo $x; ?></a>
                        </li>
                <?php
                    }
                }
                ?>

                <li class="page-item">
                    <a class="page-link" <?php if ($pageno >= $number_of_pages) {
                                                echo ("#");
                                            } else {
                                            ?> onclick="searchUser(<?php echo ($pageno + 1); ?>);" ; <?php
                                                                                                    }
                                                                                                        ?> aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- pagination -->

<?php
}
?>