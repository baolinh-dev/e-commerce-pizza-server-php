<?php 
include "connect.php";
if (!$conn) {
    die("Kết nối tới cơ sở dữ liệu thất bại: " . mysqli_connect_error());
} 
// id tenkhachhang email sodienthoai tongtien ghichu ngaydathang

$tenkhachhang = $_POST["tenkhachhang"];
$email = $_POST["email"];
$sodienthoai = $_POST["sodienthoai"];
$tongtien = $_POST["tongtien"]; 
$ghichu = $_POST["ghichu"]; 
$ngaydathang = $_POST["ngaydathang"];

$sql = "SELECT * FROM donhang WHERE tenkhachhang='$tenkhachhang'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "Đã trùng tên khách hàng";
    exit();
} 

$sql = "INSERT INTO donhang (tenkhachhang, email, sodienthoai, tongtien, ghichu, ngaydathang) VALUES ('$tenkhachhang', '$email', '$sodienthoai', '$tongtien', '$ghichu', '$ngaydathang')";

if (mysqli_query($conn, $sql)) {
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