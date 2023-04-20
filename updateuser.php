<?php  
header('Access-Control-Allow-Origin: *');
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
$role = $_POST["role"]; // lấy giá trị của trường "role" từ phía client

// Lưu file ảnh đại diện vào thư mục "imgs/" trên server
$target_dir = "D:/workspace/web/personal-project/e-commerce-pizza/e-commerce-pizza-web/public/imgs/";
$target_file = $target_dir . basename($_FILES["avatar"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Kiểm tra tính hợp lệ của file ảnh
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["avatar"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
        $arr = [ 
            'success' => false, 
            'message' => "File tải lên không phải là ảnh"
        ];
        print_r(json_encode($arr));
        exit();
    }
}
// Kiểm tra kích thước của file ảnh
if ($_FILES["avatar"]["size"] > 500000) {
    $uploadOk = 0;
    $arr = [ 
        'success' => false, 
        'message' => "Kích thước ảnh đại diện phải nhỏ hơn 500KB"
    ];
    print_r(json_encode($arr));
    exit();
}
// Cho phép tải lên các định dạng ảnh sau: JPG, JPEG, PNG, GIF
if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif" ) {
    $uploadOk = 0;
    $arr = [ 
        'success' => false, 
        'message' => "Chỉ cho phép tải lên các file ảnh định dạng: JPG, JPEG, PNG, GIF"
    ];
    print_r(json_encode($arr));
    exit();
}
if ($uploadOk == 0) {
    $arr = [ 
        'success' => false, 
        'message' => "Tải lên ảnh đại diện thất bại"
    ];
    print_r(json_encode($arr));
    exit();
} else {
    // Nếu các kiểm tra đều đã được thông qua, lưu ảnh đại diện vào thư mục "imgs/" trên server
    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
        $avatar = "http://" . $_SERVER['HTTP_HOST'] . ":3000/imgs/" . basename($_FILES["avatar"]["name"]);
    } else {
        $arr = [ 
            'success' => false, 
            'message' => "Tải lên ảnh đại diện thất bại"
        ];
        print_r(json_encode($arr));
        exit();
    }
}

// Hash mật khẩu với mã SHA-256
$hashed_password = hash('sha256', $password);

$sql = "UPDATE user SET username='$username', password='$hashed_password', email='$email', phone='$phone', fullname='$fullname', role='$role', avatar='$avatar' WHERE id='$id'";

if (mysqli_query($conn, $sql)) {
    $new_user = [
        'id' => $id,
        'username' => $username,
        'fullname' => $fullname,
        'email' => $email,
        'phone' => $phone,
        'role' => $role,
        'avatar' => $avatar
    ];
    $arr = [ 
        'success' => true, 
        'message' => "Sửa thông tin người dùng thành công",
        'result' => $new_user
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