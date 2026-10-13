<?php
include "connection.php";

$rs = Database::search("SELECT `product`.`id`, `product`.`title`, SUM(`product`.`qty_sold`) AS `total_sold` 
FROM `product` GROUP BY `product`.`id`, `product`.`title` ORDER BY `total_sold` DESC LIMIT 5");

$num = $rs->num_rows;

$labels = array();
$data = array();

for ($x = 0; $x < $num; $x++) {
    $d = $rs->fetch_assoc();
    $labels[] = $d["title"];
    $data[] = $d["total_sold"];
}

$rs1 = Database::search("SELECT DATE(`order`.`order_date`) AS `order_date`, SUM(`order`.`amount`) AS `total_income` 
FROM `order` WHERE `order`.`order_date` >= DATE(NOW()) - INTERVAL 5 DAY GROUP BY DATE(`order`.`order_date`) ORDER BY `order_date` ASC LIMIT 5");

$num1 = $rs1->num_rows;

$labels1 = array();
$data1 = array();

for ($y = 0; $y < $num1; $y++) {
    $d1 = $rs1->fetch_assoc();
    $labels1[] = $d1["order_date"];
    $data1[] = $d1["total_income"];
}

$response = array(
    "soldChart" => array(
        "labels" => $labels,
        "data" => $data
    ),
    "incomeChart" => array(
        "labels" => $labels1,
        "data" => $data1
    )
);

echo json_encode($response);

?>