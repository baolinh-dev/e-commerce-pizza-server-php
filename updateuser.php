<?php 
include "connect.php";

if (!$conn) {
    die("Kết nối tới cơ sở dữ liệu thất bại: " . mysqli_connect_error());
}

$id = $_POST['id'];
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$phone = $_POST['phone']; 
$fullname = $_POST["fullname"];

// Hash mật khẩu với mã SHA-256
$hashed_password = hash('sha256', $password);

$sql = "UPDATE user SET username='$username', password='$hashed_password', email='$email', phone='$phone', fullname='$fullname' WHERE id='$id'";

if (mysqli_query($conn, $sql)) {
    $arr = [ 
        'success' => true, 
        'message' => "Sửa thông tin người dùng thành công"
    ];
} else {
    $arr = [ 
        'success' => false, 
        'message' => "Sửa thông tin người dùng thất bại"
    ];
}

print_r(json_encode($arr));
mysqli_close($conn);
?>