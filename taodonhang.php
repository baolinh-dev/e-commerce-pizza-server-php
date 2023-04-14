<?php 
include "connect.php";

if (!$conn) {
    die("Kết nối tới cơ sở dữ liệu thất bại: " . mysqli_connect_error());
} 

// Lấy dữ liệu từ biểu mẫu POST
$tenkhachhang = $_POST["tenkhachhang"];
$email = $_POST["email"]; 
$ngaydathang = $_POST["ngaydathang"];
$sodienthoai = $_POST["sodienthoai"];
$tongtien = $_POST["tongtien"]; 
$ghichu = $_POST["ghichu"]; 
$fullname = $_POST["fullname"];

// Kiểm tra xem tên khách hàng đã tồn tại trong bảng hay chưa
$sql = "SELECT * FROM donhang WHERE tenkhachhang='$tenkhachhang'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "Đã trùng tên khách hàng";
    exit();
} 

// Thêm dữ liệu vào bảng donhang
$sql = "INSERT INTO donhang (tenkhachhang, fullname, email, sodienthoai, tongtien, ghichu, ngaydathang) VALUES ('$tenkhachhang', '$fullname', '$email', '$sodienthoai', '$tongtien', '$ghichu', '$ngaydathang')";

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