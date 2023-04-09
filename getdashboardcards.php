<?php
	include "connect.php";
	$resultQuantityMon = mysqli_query($conn, "SELECT COUNT(*) as totalMon FROM mon");
	$rowQuantityMon = mysqli_fetch_assoc($resultQuantityMon);   

	$resultQuantityDonHang = mysqli_query($conn, "SELECT COUNT(*) as totalDonhang FROM donhang"); 
	$rowQuantityDonHang = mysqli_fetch_assoc($resultQuantityDonHang);   

	$resultQuantityUser = mysqli_query($conn, "SELECT COUNT(*) as totalUser FROM user");  
	$rowQuantityUser = mysqli_fetch_assoc($resultQuantityUser);   

	$resultTotalDonHang = mysqli_query($conn, "SELECT SUM(tongtien) as totalDonHang FROM donhang");
	$rowTotalDonHang = mysqli_fetch_assoc($resultTotalDonHang);

// faUsers faClipboardList faCartShopping faWallwt
	$quantityMon = $rowQuantityMon["totalMon"]; 
	$quantityDonHang = $rowQuantityDonHang["totalDonhang"];   
	$quantityUser = $rowQuantityUser['totalUser'];
	// $totalDonHang = $rowTotalDonHang['totalDonHang']; 
	$totalDonHang = number_format($rowTotalDonHang['totalDonHang'])  . ' đ';

	$objMon = new stdClass();
	$objMon->name = "Số lượng món";
	$objMon->quantity = $quantityMon;  
	$objMon->icon = "faUsers"; 

	$objDonHang = new stdClass();
	$objDonHang->name = "Số lượng đơn hàng";
	$objDonHang->quantity = $quantityDonHang;  
	$objDonHang->icon = "faClipboardList"; 

	$objUser = new stdClass();
	$objUser->name = "Số lượng user";
	$objUser->quantity = $quantityUser;  
	$objUser->icon = "faCartShopping";

	$objTotalDonHang = new stdClass();
	$objTotalDonHang->name = "Tổng cộng đơn hàng";
	$objTotalDonHang->quantity = $totalDonHang; 
	$objTotalDonHang->icon = "faWallet";

	$result = [$objMon, $objDonHang, $objUser, $objTotalDonHang];
	if (!empty($result)) {
		$arr = [
			'success' => true,
			'message' => "Thành công",
			'result' => $result, 
		];
	} else {
		$arr = [
			'success' => false,
			'message' => "Thất bại!",
			'result' => $result
		];
	}
	print_r(json_encode($arr));
?>