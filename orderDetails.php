<?php

include "connection.php";

$oid = $_GET["id"];
$invoice_rs = Database::search("SELECT * FROM `invoice` INNER JOIN `product` ON `invoice`.`product_id`=`product`.`id` WHERE `order_oid`='$oid'");
$invoice_num = $invoice_rs->num_rows;

echo '<table class="table table-hover table-striped-columns border-dark mt-3 text-center">
        <thead style="background-color: wheat;">
            <tr>
                <th scope="col" class="fs-5">#</th>
                <th scope="col" class="fs-5">Product Name</th>
                <th scope="col" class="fs-5">Qty</th>
                <th scope="col" class="fs-5">Price</th>
            </tr>
        </thead>
        <tbody>';

for ($y = 0; $y < $invoice_num; $y++) {
    $invoice_data = $invoice_rs->fetch_assoc();
    echo '<tr>
            <th scope="row" class="fs-4">' . ($y + 1) . '</th>
            <th class="fs-4">' . $invoice_data["title"] . '</th>
            <td class="fs-4">' . $invoice_data["qty"] . '</td>
            <td class="fs-4">Rs.' . ($invoice_data["qty"] * $invoice_data["price"]) . ' .00</td>
          </tr>';
}

echo '  </tbody>
    </table>';
?>