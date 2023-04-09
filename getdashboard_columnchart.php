<?php
include "connect.php";

$query = "SELECT DATE_FORMAT(`ngaydathang`, '%M') AS `thang`, SUM(`tongtien`) AS `tongtien` FROM `donhang` GROUP BY YEAR(`ngaydathang`), MONTH(`ngaydathang`)";
$data = mysqli_query($conn, $query);
if (!$data) {
    $arr = [
        'success' => false,
        'message' => "Thất bại: " . mysqli_error($conn),
    ];
    die(json_encode($arr));
}

$result = array();
while ($row = mysqli_fetch_assoc($data)) {
    $result[] = [$row['thang'], (int)$row['tongtien']];
}

$arr = [
    'success' => true,
    'message' => "Thành công",
    'result' => $result,
];

print_r(json_encode($arr));
?>