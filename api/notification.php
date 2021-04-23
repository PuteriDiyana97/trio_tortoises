<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/notification.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://stargloryasia.com/".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	/* ******************************************************************

		Query Function & Print JSON Data
		810 Notification API
		Sample URL: http://810speedmart.com/api/notification.php?contactno=[CONTACTNO or '' (EMPTY)]

		Return Info
		1. status - Info = 0: Error, 1: Success
		2. status_message = Show Status Message
		3. NOTIFICATION = Banner Image (Array)
			- THUMB = Thumbnail
			- TITLE = Title display in Modal Header
			- TITLE1 = Title
			- TITLE2 = Title (display if any)
			- READ = 0: Unread , 1: Readed
			- TYPE = 0: Multiple Image , 1: HTML Content
			- ALL_PAGES (if TYPE = 0) = Show all slide image when click THUMB Image 
			- ALL_INFO (if TYPE = 1) = Display HTML Content

	****************************************************************** */
	// $DWMode = $_REQUEST["display_mode"];
	$DWUserContact = ReturnValidContact($_REQUEST["contactno"]);
	// 	$DWOTPNumber = rand(1000, 9999);


	$con = getdb();
	mysqli_set_charset($con, "utf8mb4"); 
	$Sql_Select = "SELECT n.* FROM notification_receiver n WHERE n.active = 1 AND 
	(DATE(n.start_date) <= '".date("Y-m-d")."' AND DATE(n.end_date) >= '".date("Y-m-d")."') 
	AND n.push_notification = 1 AND n.contact_no = '".$DWUserContact."' ORDER BY n.created DESC";

	$Rst_Select = mysqli_query($con,$Sql_Select);

	$Sql_Count = "SELECT n.* FROM notification_receiver n WHERE n.notification_read = 0 AND n.active = 1 AND
	(DATE(n.start_date) <= '".date("Y-m-d")."' AND DATE(n.end_date) >= '".date("Y-m-d")."') 
	AND n.push_notification = 1 AND n.contact_no = '".$DWUserContact."' ";
	$Rst_Count = mysqli_query($con,$Sql_Count);
	
	if(mysqli_num_rows($Rst_Select) > 0)
		while($row = mysqli_fetch_array($Rst_Select)) {

			$data['notification_image'] = "";
			if ($row["notification_image"] != '') {
				$data['notification_image'] = $_URL."assets/upload_files/notification/". $row["notification_image"];
			}
			else {
				$data['notification_image'] = "";
			}

		$data['notification_id'] = $row["id"]; 
		$data['notification_title'] 		  = $row["notification_title"]; 
		$data['short_description']  = str_replace("\r\n", "<br>", $row["short_description"]); 
		$data['long_description']   = str_replace("\r\n", "<br>", $row["long_description"]);
		// $data['notification_image'] = "http://cloone.my/demo/starglory-admin/assets/upload_files/notification/". $row["notification_image"];
		$data['start_date']   = $row["start_date"];
		$data['end_date']  = $row["end_date"]; 
		$data['push_notification'] = $row["push_notification"]; //0:not publish 1:published
		$data['notification_read'] = $row["notification_read"]; //0:not publish 1:published

		$rowAll[] = $data;
		$status = 1;
		$status_message = 'Success display notification details.';
		$firstpage = '/tabs/home' ;
		$unread = mysqli_num_rows($Rst_Count);

	}else{

		$status   = 0;
		$status_message = 'You have no notification at the moment';
		$firstpage = '' ;
		$unread = '';

	}

	// $DWDayLast = date('Y-m-d 23:59:59');	<<<---------------------------------------------------->>>>
	// $DWDayFirst = date('Y-m-d 00:00:00', strtotime("-7 day"));
	
	// $Sql_Select = "SELECT n.* FROM data_customer d INNER JOIN notifications n ON (n.customer_id=d.id) WHERE d.tel = '".$DWUserContact."' AND n.push_notification = 1 AND d.active > 0 AND n.active = 1 AND (n.created BETWEEN '".$DWDayFirst."' AND '".$DWDayLast."') ORDER BY n.id DESC";
	// $Rst_Select = mysqli_query($con,$Sql_Select);
	// while ($RowData = mysql_fetch_assoc($Rst_Select)) {
	// 	unset($BannerData);
	// 	$BannerData["ID"] = $RowData["id"];
	// 	$BannerData["THUMB"] = $RowData["thumbnail"];
	// 	$BannerData["THUMB_ALIGN"] = ($RowData["thumbnail_align"]==0 ? "start" : "end");//start , end
	// 	$BannerData["TITLE"] = $RowData["title"];
	// 	$BannerData["TITLE1"] = $RowData["title1"];
	// 	$BannerData["TITLE2"] = $RowData["title2"];
	// 	$BannerData["READ"] = $RowData["read"];
	// 	$BannerData["TYPE"] = $RowData["type"];
	// 	$BannerData["DATESHOW"] = date("Y/m/d", strtotime($RowData["created"]));
	// 	if ($BannerData["TYPE"] == 1) {
	// 		$BannerData["ALL_INFO"] = $RowData["html"];
	// 	} else {
	// 		unset($BannerPages);
	// 		$BannerPages = json_decode($RowData["banner"]);
	// 		$BannerData["ALL_PAGES"] = $BannerPages;
	// 	}
	// 	$MainData_Info[] = $BannerData;
	// }

	// $MainData["NOTIFICATION"] = $MainData_Info;

	// $SqlSetting_Select = "SELECT d.* FROM data_apps_setting d WHERE d.title = 'HOME_BANNER_BACKGROUND' ";
	// $RstSetting_Select = mysqli_query($con,$SqlSetting_Select);
	// while ($SettingData = mysql_fetch_assoc($RstSetting_Select)) {
	// 	$MainData["BANNER_BG"] = $SettingData["data"];
	// }   <<<---------------------------------------------------->>>>

	/*
	if ( $DWUserContact != "" ) {
		unset($BannerData);
		$BannerData["THUMB"] = "assets/810-speedmart-catalogue.png";
		$BannerData["TITLE"] = "Title 1";
		$BannerData["TITLE1"] = "Thu,2 May - Wed,15 May";
		$BannerData["TITLE2"] = "Promotion";
		$BannerData["READ"] = 0;
		$BannerData["TYPE"] = 0;
		unset($BannerPages);
		$BannerPages[] = "assets/810-speedmart-catalogue.png";
		$BannerPages[] = "assets/810-speedmart-catalogue-1.png";
		$BannerPages[] = "assets/810-speedmart-catalogue-2.png";
		$BannerPages[] = "assets/810-speedmart-catalogue-3.png";
		$BannerData["ALL_PAGES"] = $BannerPages;
		$MainData_Info[] = $BannerData;

		unset($BannerData);
		$BannerData["THUMB"] = "assets/810-speedmart-catalogue-1.png";
		$BannerData["TITLE"] = "Title 2";
		$BannerData["TITLE1"] = "Thu,3 May - Wed,16 May";
		$BannerData["TITLE2"] = "";
		$BannerData["READ"] = 1;
		$BannerData["TYPE"] = 1;
		$BannerData["ALL_INFO"] = "<b>Content of info at Thu,3 May - Wed,16 May</b>";
		$MainData_Info[] = $BannerData;

		unset($BannerData);
		$BannerData["THUMB"] = "assets/810-speedmart-catalogue-2.png";
		$BannerData["TITLE"] = "Title 3";
		$BannerData["TITLE1"] = "Thu,4 May - Wed,18 May";
		$BannerData["TITLE2"] = "";
		$BannerData["READ"] = 1;
		$BannerData["TYPE"] = 0;
		unset($BannerPages);
		$BannerPages[] = "assets/810-speedmart-catalogue.png";
		$BannerPages[] = "assets/810-speedmart-catalogue-1.png";
		$BannerPages[] = "assets/810-speedmart-catalogue-2.png";
		$BannerPages[] = "assets/810-speedmart-catalogue-3.png";
		$BannerData["ALL_PAGES"] = $BannerPages;
		$MainData_Info[] = $BannerData;

		unset($BannerData);
		$BannerData["THUMB"] = "assets/810-speedmart-catalogue-3.png";
		$BannerData["TITLE"] = "Title 4";	
		$BannerData["TITLE1"] = "Thu,10 May - Wed,31 May";
		$BannerData["TITLE2"] = "";
		$BannerData["READ"] = 0;
		$BannerData["TYPE"] = 1;
		$BannerData["ALL_INFO"] = "<b>Content of info at Thu,10 May - Wed,31 May</b>";
		$MainData_Info[] = $BannerData;

		$MainData["NOTIFICATION"] = $MainData_Info;
	} else if ( 0 ) {
		unset($BannerData);
		$BannerData["THUMB"] = "assets/810-speedmart-catalogue.png";
		$BannerData["TITLE"] = "Title 1";
		$BannerData["TITLE1"] = "Thu,2 May - Wed,15 May";
		$BannerData["TITLE2"] = "Promotion";
		$BannerData["READ"] = 0;
		$BannerData["TYPE"] = 0;
		unset($BannerPages);
		$BannerPages[] = "assets/810-speedmart-catalogue.png";
		$BannerPages[] = "assets/810-speedmart-catalogue-1.png";
		$BannerPages[] = "assets/810-speedmart-catalogue-2.png";
		$BannerPages[] = "assets/810-speedmart-catalogue-3.png";
		$BannerData["ALL_PAGES"] = $BannerPages;
		$MainData_Info[] = $BannerData;

		$MainData["NOTIFICATION"] = $MainData_Info;
	}
	*/
	

	// if ( $DWMode == "TEST" ) {
	// 	echo "<pre>";
	// 	print_r($MainData);
	// 	echo "</pre>";
	// }
	
	// echo json_encode($MainData);
	// exit;

	$MainData["NOTIFICATIONS"] = $rowAll;
	$MainData["NOTIFICATION_UNREAD"] = $unread;
	$MainData["firstpage"] = $firstpage;
	$MainData["status"] = $status;
	$MainData["status_message"] = $status_message;
			
	echo json_encode($MainData);
	exit;
?>