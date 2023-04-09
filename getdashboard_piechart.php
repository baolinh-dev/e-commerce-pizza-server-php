<?php
	include "connect.php";
	$resultQuantityMainDish = mysqli_query($conn, "SELECT COUNT(*) as totalMainDish FROM mon WHERE madanhmuc = 1");
	$rowQuantityMainDish = mysqli_fetch_assoc($resultQuantityMainDish);   

	$resultQuantityBurger = mysqli_query($conn, "SELECT COUNT(*) as totalBurger FROM mon WHERE madanhmuc = 2"); 
	$rowQuantityBurger = mysqli_fetch_assoc($resultQuantityBurger);   

	$resultQuantityDrink = mysqli_query($conn, "SELECT COUNT(*) as totalDrink FROM mon WHERE madanhmuc = 3");  
	$rowQuantityDrink = mysqli_fetch_assoc($resultQuantityDrink);   

	$resultQuantitySubDisk = mysqli_query($conn, "SELECT COUNT(*) as totalSubDish FROM mon WHERE madanhmuc = 4");
	$rowQuantitySubDisk = mysqli_fetch_assoc($resultQuantitySubDisk);

// faUsers faClipboardList faCartShopping faWallwt
	$quantityMainDish = $rowQuantityMainDish["totalMainDish"]; 
	$quantityBurger = $rowQuantityBurger["totalBurger"];   
	$quantityDrink = $rowQuantityDrink['totalDrink'];
	// $totalDonHang = $rowTotalDonHang['totalDonHang']; 
	$quantitySubDisk = $rowQuantitySubDisk['totalSubDish'];

	$objMainDish = new stdClass();
	$objMainDish->name = "Món chính";
	$objMainDish->quantity = $quantityMainDish;  


	$objBurger = new stdClass();
	$objBurger->name = "Burger";
	$objBurger->quantity = $quantityBurger;  


	$objDrink = new stdClass();
	$objDrink->name = "Đồ uống";
	$objDrink->quantity = $quantityDrink;  


	$objSubDisk = new stdClass();
	$objSubDisk->name = "Món phụ";
	$objSubDisk->quantity = $quantitySubDisk; 


	$result = [$objMainDish, $objBurger, $objDrink, $objSubDisk];
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