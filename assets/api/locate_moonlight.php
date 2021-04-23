<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/locate.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://cloone.my".$_SERVER['REQUEST_URI']."\n".$req_dump);
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

	$DWLot = $_REQUEST["lot"];
	$DWLat = $_REQUEST["lat"];

	if ( empty($DWLot) ) {
		$DWLot = "0";
		$DWLat = "0";
	}

	function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo) {
		//Calculate distance from latitude and longitude
		$theta = $longitudeFrom - $longitudeTo;
		$dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;

		return $distance = (number_format(($miles * 1.609344),2,".","") < 50 ? number_format(($miles * 1.609344),2,".","") : "-").' km';
	}

	unset($ShopData);
	$ShopData["shop_name"] = "Starglory Asia Duty Free Shop";
	$ShopData["shop_image"] = "https://upload.wikimedia.org/wikipedia/commons/1/13/Supermarkt.jpg";
	$ShopData["shop_address"] = "No.202B, 2F Fisherman Wharf,, Island 1, Forest City,, Jalan Tanjung Kupang, Kampung Pok,, Gelang Patah, 81500 Forest City, Johor";
	$ShopData["shop_lnl"] = "1.3344204,103.5926155";
	$ShopData["shop_contact"] = "+6075539950";
	$ShopData["shop_postal_code"] = "81500";
	$ShopData["distance"] = haversineGreatCircleDistance($DWLot, $DWLat, "1.3344204", "103.5926155");
	$LocateData[] = $ShopData;
	
	// $Sql_Select = "SELECT d.* FROM data_location d WHERE d.active > 0";
	// $Rst_Select = mysql_query($Sql_Select);
	// while ($RowData = mysql_fetch_assoc($Rst_Select)) {
	// 	unset($ShopData);
	// 	$ShopData["shop_name"] = $RowData["shop_name"];
	// 	$ShopData["shop_active"] = $RowData["active"];
	// 	$ShopData["shop_image"] = $RowData["shop_image"];
	// 	$ShopData["shop_address"] = $RowData["shop_address"];
	// 	$ShopData["shop_lnl"] = $RowData["shop_lon"].",".$RowData["shop_lat"];
	// 	$ShopData["shop_contact"] = $RowData["shop_contact"];
	// 	$ShopData["shop_postal_code"] = $RowData["shop_postal_code"];
	// 	if ( empty($DWLot) || $DWLot == 0 ) {
	// 		$ShopData["distance"] = "-";
	// 	} else {
	// 		$ShopData["distance"] = haversineGreatCircleDistance($DWLot, $DWLat, $RowData["shop_lon"], $RowData["shop_lat"]);
	// 	}
	// 	$LocateData[] = $ShopData;
	// }

	/*
	unset($ShopData);
	$ShopData["shop_name"] = "Sri Rampai";
	$ShopData["shop_image"] = "https://upload.wikimedia.org/wikipedia/commons/1/13/Supermarkt.jpg";
	$ShopData["shop_address"] = "43 & 45, Jalan Sri Rampai, Jalan 45/26, Taman Sri Rampai, 53300, Wilayah Persekutuan Kuala Lumpur";
	$ShopData["shop_lnl"] = "3.1950988,101.7325778";
	$ShopData["shop_contact"] = "012-809 9810";
	$ShopData["shop_postal_code"] = "53300";
	$ShopData["distance"] = haversineGreatCircleDistance("3.195335", "101.732599", "3.1950988", "101.7325778");
	$LocateData[] = $ShopData;

	unset($ShopData);
	$ShopData["shop_name"] = "Wangsa Maju";
	$ShopData["shop_image"] = "https://upload.wikimedia.org/wikipedia/commons/1/13/Supermarkt.jpg";
	$ShopData["shop_address"] = "No. 19, 1 & 20-1, Jalan Metro Wangsa, Wangsa Maju, 53300, Wilayah Persekutuan Kuala Lumpur";
	$ShopData["shop_lnl"] = "3.2044851,101.7360759";
	$ShopData["shop_contact"] = "012-809 9810";
	$ShopData["shop_postal_code"] = "53300";
	$ShopData["distance"] = haversineGreatCircleDistance("3.195335", "101.732599", "3.1950988", "101.7325778");
	$LocateData[] = $ShopData;
	*/

	$MainData["LOCATION"] = $LocateData;

	$MainData["LOCATION_MAP"] = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30426.898892724304!2d101.61539448265682!3d3.0399513819526454!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc4b5a3f4e7781%3A0xae431719608f5622!2sMoonlight%20Cake%20House%20(Puchong)!5e0!3m2!1sen!2smy!4v1576569129866!5m2!1sen!2smy";
	
	
	echo json_encode($MainData);
	exit;
?>