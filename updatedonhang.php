<?php
// Kết nối với cơ sở dữ liệu
include "connect.php";

// Lấy thông tin người dùng từ biến POST
$id = $_POST['id'];
$tenkhachhang = $_POST['tenkhachhang'];
$email = $_POST['email'];
$sodienthoai = $_POST['sodienthoai'];
$tongtien = $_POST['tongtien']; 
$ghichu = $_POST['ghichu'];

// Thực hiện câu lệnh SQL để sửa thông tin người dùng
$sql = "UPDATE donhang SET tenkhachhang='$tenkhachhang', email='$email', sodienthoai='$sodienthoai', tongtien='$tongtien', ghichu='$ghichu' WHERE id='$id'";
$result = mysqli_query($conn, $sql);

// Kiểm tra kết quả và trả về mảng chứa message
if ($result) {
    $response = array("success" => true, "message" => "Sửa thông tin người dùng thành công");
} else {
    $response = array("success" => false, "message" => "Sửa thông tin người dùng thất bại");
}

echo json_encode($response);
?>