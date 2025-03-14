<?php 
include "connect.php";

if (!$conn) {
    die("Kết nối tới cơ sở dữ liệu thất bại: " . mysqli_connect_error());
}

$username = $_POST["username"]; 
$password = $_POST["password"];
$email = $_POST["email"];
$phone = $_POST["phone"]; 
$fullname = $_POST["fullname"];
$role = $_POST["role"]; // lấy giá trị của trường "role" từ phía client

    // Hash mật khẩu với mã SHA-256
    $hashed_password = hash('sha256', $password);

    $sql = "SELECT * FROM user WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $arr = [
            'success' => false,
            'message' => "Tên đăng nhập đã được sử dụng, vui lòng chọn tên đăng nhập khác"
        ];
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        exit();
    }
    
    $sql = "INSERT INTO user (username, password, fullname, email, phone, role) VALUES ('$username', '$hashed_password', '$fullname', '$email', '$phone', '$role')";

    if (mysqli_query($conn, $sql)) {
        $arr = [ 
            'success' => true, 
            'message' => "Thành công",
        ];
    } else {
        $arr = [ 
            'success' => false, 
            'message' => "Không thành công"
        ];
    }

print_r(json_encode($arr));
mysqli_close($conn);
?>