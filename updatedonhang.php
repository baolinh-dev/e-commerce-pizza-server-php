<?php
// Kết nối với cơ sở dữ liệu
include "connect.php";

// Lấy thông tin đơn hàng từ biến POST
$id = $_POST['id'];
$tenkhachhang = $_POST['tenkhachhang'];
$email = $_POST['email'];
$sodienthoai = $_POST['sodienthoai'];
$ngaydathang = $_POST['ngaydathang'];
$tongtien = $_POST['tongtien'];
$ghichu = $_POST['ghichu'];
$fullname = $_POST['fullname'];

// Thực hiện câu lệnh SQL để sửa thông tin đơn hàng
$sql = "UPDATE donhang SET tenkhachhang='$tenkhachhang', fullname='$fullname', email='$email', sodienthoai='$sodienthoai', ngaydathang='$ngaydathang', tongtien='$tongtien', ghichu='$ghichu' WHERE id='$id'";
$result = mysqli_query($conn, $sql);

// Kiểm tra kết quả và trả về mảng chứa message
if ($result) {
    $response = array("success" => true, "message" => "Sửa thông tin đơn hàng thành công");
} else {
    $response = array("success" => false, "message" => "Sửa thông tin đơn hàng thất bại");
}

echo json_encode($response);
?>