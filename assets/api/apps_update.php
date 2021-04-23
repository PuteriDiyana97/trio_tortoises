<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/apps_update_'.date("Y-m-d").'.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://cloone.my".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************

		Query Function & Print JSON Data
		810 Device Info / OneSignal ID API
		Sample URL: http://810speedmart.com/api/apps_update.php?contactno=[CONTACTNO or '' (EMPTY)]&uuid=[UUID]&regid=[REG ID]

		http://810speedmart.com/api/apps_update.php?contactno=0163660905&uuid=ee2a9fff1912c6f0&regid=ef6NwsVdXtE:APA91bHqy0XKZ3NXlszR4lHFTIz3y6o-WwgzWIGKnS8-GPM10pBeNmTeylkQO8fohKQKNcA1Rm5RBdXRaVbxIFrwZDTnhwTPAFfGfcCZRyi4Eh2V67YG6pcHSXSaoKduDACuRTVtw8t8&userid=4b391148-6ddb-4746-a375-5e21e208c80f&version=0.0.2
			2019-06-24 11:20:16 - http://810speedmart.com//api/apps_update.php
			Array
			(
			    [uuid] => ee2a9fff1912c6f0
			    [regid] => ef6NwsVdXtE:APA91bHqy0XKZ3NXlszR4lHFTIz3y6o-WwgzWIGKnS8-GPM10pBeNmTeylkQO8fohKQKNcA1Rm5RBdXRaVbxIFrwZDTnhwTPAFfGfcCZRyi4Eh2V67YG6pcHSXSaoKduDACuRTVtw8t8
			    [userid] => 4b391148-6ddb-4746-a375-5e21e208c80f
			    [version] => 0.0.2
			)

		Return Info
		Ignore It

	****************************************************************** */
	// $DWMode = $_REQUEST["display_mode"];
	$DWUserContact = ReturnValidContact($_REQUEST["contactno"]);
	$DWUUID = $_REQUEST["uuid"];
	$DWUserID = $_REQUEST["userid"];
	$DWRegID = $_REQUEST["regid"];
	$DWVersion = $_REQUEST["version"];

	$con = getdb();

	// echo $DWVersion;
	// die();

	// if ($DWVersion != "0.1.0" && $DWVersion != "0.2.1" && $DWVersion != "0.2.2" && $DWVersion != "0.2.3" && $DWVersion != "0.2.5" && $DWVersion != "0.2.6" && $DWVersion != "0.2.8" && $DWVersion != "0.2.9") {
	// 	$MainData["status"] = "2";
	// 	$MainData["status_message"] = "Your app is outdated, please update it.";
	// 	$MainData["status_url"] = "com.cloone.speedmart810";
	// 	$MainData["status_url_ios"] = "com.cloone.speedmart810";
	// } else {
		// $MainData["status"] = "1";
		// $MainData["status_message"] = "";
		// $MainData["status_url"] = "";
		// $MainData["status_url_ios"] = "";
	// }

	if ( $DWUserContact != "") {

		// $DWID = 0;
		//echo "<br />Select Cust: ".
		$con = getdb();

		$SqlCust_Select = "SELECT d.* FROM data_customer d WHERE d.active > 0 AND d.contact_no = '".$DWUserContact."' LIMIT 1";
		$RstCust_Select = mysqli_query($con,$SqlCust_Select);
		
		if (mysqli_num_rows($RstCust_Select) > 0) {
			// $Sql_Select = "SELECT i.* FROM data_apps_info i WHERE i.active > 0 AND i.contact_no = '".$DWUserContact."' AND i.uuid = '".$DWUUID."' LIMIT 1";
			$Sql_Select = "SELECT i.* FROM data_apps_info i WHERE i.active > 0 AND i.contact_no = '".$DWUserContact."' LIMIT 1";
			$Rst_Select = mysqli_query($con,$Sql_Select);
			if (mysqli_num_rows($Rst_Select) > 0) {
				$Sql_Update = "UPDATE data_apps_info SET registerid = '".$DWRegID."', userid = '".$DWUserID."', version = '".$DWVersion."', updated = NOW() WHERE contact_no = '".$DWUserContact."'";
				$Rst_Update = mysqli_query($con,$Sql_Update);
			} else {
				//echo "<br />Insert: ".
				$Sql_Insert = "INSERT INTO data_apps_info (contact_no, uuid, userid, registerid, version, updated, created, active) VALUES ('".$DWUserContact."', '".$DWUUID."', '".$DWUserID."', '".$DWRegID."', '".$DWVersion."', NOW(), NOW(), 1)";
				$Rst_Insert = mysqli_query($con,$Sql_Insert);
			}
			$MainData["status"] = "1";
			$MainData["status_message"] = "success update";
		}
		else {
			$MainData["status"] = "0";
			$MainData["status_message"] = "contact number does not exist, please register";
		}
		
	} else {
		$MainData["status"] = "0";
		$MainData["status_message"] = "Contact number is not activated";
	}
	
	
	echo json_encode($MainData);
	exit;
?>