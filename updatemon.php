<?php
// Kết nối với cơ sở dữ liệu
include "connect.php"; 

$host = gethostbyname(gethostname());
// Lấy thông tin người dùng từ biến POST
$id = $_POST['id'];
$madanhmuc = $_POST['madanhmuc'];
$tenmon = $_POST['tenmon'];
$gia = $_POST['gia']; 
$mota = $_POST['mota'];

// Xử lý file hình ảnh nếu có
if(isset($_FILES['hinhmon'])) {
  $errors = array();
  $file_name = $_FILES['hinhmon']['name'];
  $file_size = $_FILES['hinhmon']['size'];
  $file_tmp = $_FILES['hinhmon']['tmp_name'];
  $file_type = $_FILES['hinhmon']['type'];
  $file_parts = explode('.', $_FILES['hinhmon']['name']);
  $file_ext = strtolower(end($file_parts));

  $extensions = array("jpeg", "jpg", "png");

  if(in_array($file_ext, $extensions) === false) {
     $errors[] = "Chỉ hỗ trợ upload file JPEG hoặc PNG.";
  }

  if($file_size > 2097152) {
     $errors[] = 'Kích cỡ file nên là 2 MB';
  }

  if(empty($errors) == true) {
     $target_dir = "D:/workspace/web/personal-project/e-commerce-pizza/e-commerce-pizza-web/public/imgs/";
     $hinhmon = "http://" . $host . ":3000/imgs/".$file_name;
     move_uploaded_file($file_tmp, $target_dir.$file_name);
  } else {
     $response = array("success" => false, "message" => $errors[0]);
     echo json_encode($response);
     exit();
  }
}

// Thực hiện câu lệnh SQL để sửa thông tin món ăn
if(isset($hinhmon)) {
  $stmt = mysqli_prepare($conn, "UPDATE mon SET madanhmuc=?, tenmon=?, hinhmon=?, gia=?, mota=? WHERE id=?");
  mysqli_stmt_bind_param($stmt, "sssssi", $madanhmuc, $tenmon, $hinhmon, $gia, $mota, $id);
} else {
  $stmt = mysqli_prepare($conn, "UPDATE mon SET madanhmuc=?, tenmon=?, gia=?, mota=? WHERE id=?");
  mysqli_stmt_bind_param($stmt, "ssssi", $madanhmuc, $tenmon, $gia, $mota, $id);
}

$result = mysqli_stmt_execute($stmt);

// Kiểm tra kết quả và trả về mảng chứa message
if ($result) {
  $response = array("success" => true, "message" => "Sửa thông tin món ăn thành công", "result" => true);
} else {
  $response = array("success" => false, "message" => "Sửa thông tin món ăn thất bại");
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

echo json_encode($response);
?> 