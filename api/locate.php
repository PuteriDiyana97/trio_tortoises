<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/locate.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://stargloryasia.com/".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************

		Query Function & Print JSON Data
		810 Location API
		Sample URL: http://810speedmart.com/api/locate.php?contactno=[CONTACTNO or '' (EMPTY)]&lot=[LOT]&lat=[LAT]

		Return Info
		1. LOCATION = Multiple Shop Info
			- shop_name
			- shop_image
			- shop_address
			- shop_lnl
			- shop_contact
			- shop_postal_code
			- distance
		2. LOCATION_MAP = URL for Google Map

	****************************************************************** */
	// $DWUserContact = $_REQUEST["contactno"];
	// $DWOTPNumber = rand(1000, 9999);

	$con = getdb();
	$DWLot = $_REQUEST["long"];
	$DWLat = $_REQUEST["lat"];

	if ( empty($DWLot) ) {
		$DWLot = "0";
		$DWLat = "0";
	}

	// function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo) {
	// 	//Calculate distance from latitude and longitude
	// 	$theta = $longitudeFrom - $longitudeTo;
	// 	$dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
	// 	$dist = acos($dist);
	// 	$dist = rad2deg($dist);
	// 	$miles = $dist * 60 * 1.1515;

	// 	return $distance = (number_format(($miles * 1.609344),2,".","") < 50 ? number_format(($miles * 1.609344),2,".","") : "distance").' km';
	// }

	function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius)
	  {
		// convert from degrees to radians
		$latFrom = deg2rad($latitudeFrom);
		$lonFrom = deg2rad($longitudeFrom);
		$latTo = deg2rad($latitudeTo);
		$lonTo = deg2rad($longitudeTo);
	  
		$latDelta = $latTo - $latFrom;
		$lonDelta = $lonTo - $lonFrom;
	  
		$angle = 2 * asin(sqrt(pow(sin($latDelta / 2),2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2),2)));
		$dist = $angle * $earthRadius;
		return (number_format(($dist),2,".","")).' km';
	  }

	$con = getdb();
	mysqli_set_charset($con, "utf8");
	$Sql_Select = "SELECT d.* FROM store_locations d WHERE d.active > 0 ORDER BY d.created DESC";
	$Rst_Select = mysqli_query($con,$Sql_Select);
	while ($RowData = mysqli_fetch_assoc($Rst_Select)) {
		unset($ShopData);
		
		$ShopData["shop_status"] = 0;
		if ($RowData["open_time"] <= date("H:i:s") && $RowData["close_time"] >= date("H:i:s")){
			$ShopData["shop_status"] = 1;
		}
		else {
			$ShopData["shop_status"] = 0;
		}

		$ori_open_time = $RowData["open_time"];
		$ori_close_time = $RowData["close_time"];

		$ShopData["shop_name"] = $RowData["store_name"];
		$ShopData["open_time"] = date('h:i A',strtotime($ori_open_time));
		$ShopData["close_time"] = date('h:i A',strtotime($ori_close_time));
		$ShopData["shop_image"] = $_URL."assets/upload_files/location/". $RowData["attachment"];
		$ShopData["shop_address"] = $RowData["store_address"];
		$ShopData["shop_lnl"] = $RowData["latitude"].",".$RowData["longitude"];
		$ShopData["shop_contact"] = $RowData["contact_no"];
		if ( empty($DWLot) || $DWLot == 0 ) {
			$ShopData["distance"] = "-";
		} else {
			$ShopData["distance"] = haversineGreatCircleDistance($DWLat, $DWLot, $RowData["latitude"], $RowData["longitude"], 6371);
		}
		$LocateData[] = $ShopData;
		$shop_locator = $ShopData["shop_lnl"];
	}

	
	$MainData["LOCATION"] = $LocateData;

	$MainData["LOCATION_MAP"] = "https://maps.google.com/maps?q=Star%20Glory%20Asia%20Duty%20Free%20Shop&t=&z=13&ie=UTF8&iwloc=&output=embed";
	// $MainData["LOCATION_MAP"] = "https://www.google.com/maps/embed?origin=mfe&pb=!1m3!2m1!1sStar+glory+asia+duty+free+shop!6i50";


	// ($DWLot, $DWLat, $RowData["shop_lon"], $RowData["shop_lat"]);
	// http://maps.google.com/maps?saddr=(lot,lat)&daddr=(address)
	
	
	echo json_encode($MainData);
	exit;
?>