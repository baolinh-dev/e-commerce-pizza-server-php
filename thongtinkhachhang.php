<?php
    include "connect.php";
    
    $tenkhachhang = $_POST['tenkhachhang'];
    $email = $_POST['email'];
    $ngaydathang = date("Y-m-d");
    $sodienthoai = $_POST['sodienthoai'];
    $tongtien = $_POST['tongtien'];
    $ghichu = $_POST['ghichu'];

    $query = "INSERT INTO donhang (id, tenkhachhang, email, ngaydathang, sodienthoai, tongtien, ghichu) 
              VALUES (null, '$tenkhachhang', '$email', '$ngaydathang', '$sodienthoai', '$tongtien', '$ghichu')";

    if(mysqli_query($conn, $query)) {
        $id = $conn->insert_id;
        echo $id;
    } else {
        echo "Thất bại!";
    }
?>