<?php
include "connect.php";

$query = "SELECT DATE(`ngaydathang`) AS `ngay`, CAST(`tongtien` AS SIGNED) AS `tongtien` FROM `donhang`";
$data = mysqli_query($conn, $query);
if (!$data) {
    die(mysqli_error($conn));
}

$result = array();
while ($row = mysqli_fetch_assoc($data)) {  
    $result[] = [$row['ngay'], (int)$row['tongtien']];
} 

$arr = [
    'success' => true,
    'message' => "Thành công",
    'result' => $result,
];

print_r(json_encode($arr));
?>