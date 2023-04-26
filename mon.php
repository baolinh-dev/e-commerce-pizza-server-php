<?php
include "connect.php";

$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$itemsPerPage = 8;
$offset = ($currentPage - 1) * $itemsPerPage;

$searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';

$condition = '';
if ($categoryFilter && $categoryFilter !== 'all') {
    $condition = "AND `madanhmuc` = '$categoryFilter'";
}

$query = "SELECT * FROM `mon` WHERE `tenmon` LIKE '%$searchKeyword%' $condition LIMIT $itemsPerPage OFFSET $offset";
$data = mysqli_query($conn, $query);

if (!$data) {
    die(mysqli_error($conn));
}

$result = array();
while ($row = mysqli_fetch_assoc($data)) {  
    $result[] = $row;
} 

$totalItemsQuery = "SELECT COUNT(*) AS total_items FROM `mon` WHERE `tenmon` LIKE '%$searchKeyword%' $condition";
$totalItemsResult = mysqli_query($conn, $totalItemsQuery);
$totalItemsRow = mysqli_fetch_assoc($totalItemsResult);
$totalItems = $totalItemsRow['total_items'];

$totalPages = ceil($totalItems / $itemsPerPage);

if (mysqli_num_rows($data) > 0) {
    $arr = [
        'success' => true,
        'message' => "Thành công",
        'result' => $result,
        'currentPage' => $currentPage,
        'totalPages' => $totalPages
    ];
} else {
    $arr = [
        'success' => false,
        'message' => "Không tìm thấy kết quả!",
        'result' => [],
        'currentPage' => $currentPage,
        'totalPages' => 0
    ];
}

print_r(json_encode($arr));
?>