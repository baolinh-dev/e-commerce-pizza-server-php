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
$host = gethostbyname(gethostname());

// Xử lý tệp tin hình ảnh avatar
$file = $_FILES["avatar"];
$target_dir = "D:/workspace/web/personal-project/e-commerce-pizza/e-commerce-pizza-web/public/imgs/";
$target_file = $target_dir . basename($file["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Kiểm tra file hình ảnh có phù hợp không
if($file["size"] > 5000000) {
    echo "Kích thước tệp tin quá lớn. Vui lòng chọn tệp tin có kích thước nhỏ hơn hoặc bằng 5MB.";
    exit();
}
if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
    echo "Chỉ cho phép tải lên các tệp tin JPG, JPEG, PNG hoặc GIF.";
    exit();
}

// Upload tệp tin hình ảnh vào thư mục /public/imgs
if (move_uploaded_file($file["tmp_name"], $target_file)) {
    $avatar = "http://" . $host . ":3000/imgs/" . basename($file["name"]);

    // Hash mật khẩu với mã SHA-256
    $hashed_password = hash('sha256', $password);

    $sql = "SELECT * FROM user WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "Tên đăng nhập đã được sử dụng, vui lòng chọn tên đăng nhập khác";
        exit();
    } 

    $sql = "INSERT INTO user (id, username, avatar, password, fullname, email, phone, role) VALUES ('$new_id', '$username', '$avatar', '$hashed_password', '$fullname', '$email', '$phone', '$role')";

    if (mysqli_query($conn, $sql)) {
        $new_id = mysqli_insert_id($conn);
        $new_user = [
            'id' => $new_id,
            'username' => $username,
            'fullname' => $fullname,
            'email' => $email,
            'phone' => $phone,
            'role' => $role,
            'avatar' => $avatar
        ];
        $arr = [ 
            'success' => true, 
            'message' => "Thành công",
            'result' => $new_user
        ];
    } else {
        $arr = [ 
            'success' => false, 
            'message' => "Không thành công"
        ];
    }
} else {
    $arr = [ 
        'success' => false, 
        'message' => "Không thể tải lên tệp tin hình ảnh"
    ];
}

print_r(json_encode($arr));
mysqli_close($conn);
?>