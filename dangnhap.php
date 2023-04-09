<?php
include "connect.php"; 

$username = $_POST["username"];
$password = $_POST["password"];

// Hash mật khẩu với mã SHA-256
$hashed_password = hash('sha256', $password); 

$query = "SELECT * FROM user WHERE username='$username' AND password='$hashed_password'";
$data = mysqli_query($conn, $query);
$result = array(); 
while($row = mysqli_fetch_assoc($data)) { 
	$result[] = ($row);
} 

if (!empty($result)) {
    $arr = [ 
        'success' => true, 
        'message' => "thành công", 
        'result' => $result
       ];
} else {
    $arr = [ 
        'success' => false, 
        'message' => "không thành công", 
        'result' => $hashed_password
       ];
}  
print_r(json_encode($arr));
mysqli_close($conn);
?>