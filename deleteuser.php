<?php 
include "connect.php";
if (!$conn) {
    die("Kết nối tới cơ sở dữ liệu thất bại: " . mysqli_connect_error());
}

$id = $_GET["id"];

$sql = "DELETE FROM user WHERE id = $id";
$result = mysqli_query($conn, $sql);


if ($result) {
    $arr = [ 
        'success' => true, 
        'message' => "thành công"
       ];
} else {
    $arr = [ 
        'success' => false, 
        'message' => "không thành công"
       ];
} 

print_r(json_encode($arr));
mysqli_close($conn);
?>