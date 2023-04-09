<?php 
include "connect.php";
if (!$conn) {
    die("Kết nối tới cơ sở dữ liệu thất bại: " . mysqli_connect_error());
}  

$host = gethostbyname(gethostname());
$madanhmuc = $_POST["madanhmuc"];
$tenmon = $_POST["tenmon"];
$file = $_FILES["hinhmon"];
$gia = $_POST["gia"];
$mota = $_POST["mota"];

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
    $hinhmon = "http://" . $host . ":3000/imgs/" . basename($file["name"]);

    // Lưu thông tin món ăn vào CSDL
    $sql = "SELECT * FROM mon WHERE tenmon='$tenmon'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "Món này đã tồn tại, vui lòng đặt tên khác";
        exit();
    }
    $sql = "INSERT INTO mon (madanhmuc, tenmon, hinhmon, gia, mota) VALUES ('$madanhmuc', '$tenmon', '$hinhmon', '$gia', '$mota')";
    if (mysqli_query($conn, $sql)) {
        $result_arr = array();
        $arr = [ 
            'success' => true, 
            'message' => "thành công",
            'data' => $result_arr
        ];
    } else {    
        $arr = [ 
            'success' => false, 
            'message' => "không thành công"
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