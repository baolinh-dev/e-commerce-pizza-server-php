<?php 
include "connect.php";

if (!$conn) {
    die(json_encode(["success" => false, "message" => "Kết nối thất bại: " . mysqli_connect_error()]));
}

// Kiểm tra dữ liệu đầu vào
if (!isset($_POST["tenkhachhang"]) || !isset($_POST["email"]) || !isset($_POST["sodienthoai"]) || !isset($_POST["tongtien"])) {
    die(json_encode(["success" => false, "message" => "Thiếu dữ liệu đầu vào"]));
}

// Nhận dữ liệu từ client
$tenkhachhang = $_POST["tenkhachhang"];
$fullname = isset($_POST["fullname"]) ? $_POST["fullname"] : "";
$email = $_POST["email"];
$sodienthoai = $_POST["sodienthoai"];
$tongtien = $_POST["tongtien"];
$ghichu = isset($_POST["ghichu"]) ? $_POST["ghichu"] : "";
$ngaydathang = date("Y-m-d H:i:s"); // Tự động lấy thời gian hiện tại

// Chèn dữ liệu vào bảng donhang
$sql = "INSERT INTO donhang (tenkhachhang, fullname, email, sodienthoai, tongtien, ghichu, ngaydathang) 
        VALUES ('$tenkhachhang', '$fullname', '$email', '$sodienthoai', '$tongtien', '$ghichu', '$ngaydathang')";

if (mysqli_query($conn, $sql)) {
    echo json_encode(["success" => true, "message" => "Tạo đơn hàng thành công", "id" => mysqli_insert_id($conn)]);
} else {
    echo json_encode(["success" => false, "message" => "Không thể tạo đơn hàng", "error" => mysqli_error($conn)]);
}

mysqli_close($conn);
?>
