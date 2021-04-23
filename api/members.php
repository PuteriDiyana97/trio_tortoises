<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/member.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://moonlight.cloone.my".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);


	/* ******************************************************************

		Query Function & Print JSON Data
		810 Member API
		Sample URL: http://810speedmart.com/api/member.php?contactno=[CONTACTNO or '' (EMPTY)]

		Return Info
		- status - Info = 0: Error, 1: Success
		- status_message = Show Status Message
		- CUST_NAME - Customer Name
		- CUST_CODE - Customer Code
		- CUST_ID - Customer ID
		- CUST_TYPE - 0: Guest Member (Cannot see POINT TAB) , 1: Valid Member / Expire Member (Can see POINT TAB) , 2: Free Member (Can see POINT TAB)
		- CUST_BARCODE - Barcode for ID
		- CUST_PROFILE_IMAGE - Customer Profile Image
		- CUST_CARD_BG - MEMBER CARD BACKGROUND
		- CUST_CONTACT - Customer Contact
		- CUST_NRIC - Customer IC
		- CUST_EXPIRY_DATE - Membership Expiry Date
		- CUST_EXPIRY - 0: Not Expire, 1: Already Expire
		- CUST_EMAIL - Customer Email
		- ACCOUNT_IMAGE - Image when CUST_TYPE = 0 / 2
		- POINT_TOTAL - Total Point
		- POINT_LAST - Last Earn Point
		- POINT_LAST_DATE - Last Earn Date
		- POINT_LIST = Point Info (Array)
			- DATE = Transaction Date
			- LOCATION = Transaction Location
			- AMOUNT = Transaction Amount
			- POINT = Point Earn from Transaction

	****************************************************************** */
	$DWMode = $_REQUEST["display_mode"];
	$DWUserContact = ReturnValidContact($_REQUEST["contactno"]);

	$DWDayLast = date('Y-m-d 23:59:59');
	$DWDayFirst = date('Y-m-d 00:00:00', strtotime("-7 day"));


	if ( $_REQUEST["contactno"] != "" ) {

		$Sql_Select = "SELECT d.* FROM data_customer d WHERE d.active > 0 AND d.tel = '".$DWUserContact."' LIMIT 1";
		$Rst_Select = mysql_query($Sql_Select);
		while ($RowData = mysql_fetch_assoc($Rst_Select)) {

			$MainData["CUST_NAME"] = $RowData["name"];
			$MainData["CUST_CODE"] = "";//$RowData["id"];
			$MainData["CUST_ID"] = $RowData["tel"];
			$MainData["CUST_TYPE"] = $RowData["active"];
			$MainData["CUST_BARCODE"] = "http://sys.senheng.com.my/senhengmobile/senhengapps/cms/php-barcode/barcode.php?size=25&text=".$RowData["tel"]."&print=false";
			$MainData["CUST_BARCODE_V"] = "http://sys.senheng.com.my/senhengmobile/senhengapps/cms/php-barcode/barcode.php?size=30&text=".$RowData["tel"]."&print=true";
			$MainData["CUST_PROFILE_IMAGE"] = "/assets/icon/profile_image.png";


			//
			// Apps Setting, 0: Not Show, 1: Show
			$MainData["SET_SHOW_BANNER"] = 0;
			//
			// My Profile
			$MainData["CUST_CONTACT"] = $RowData["tel"];
			$MainData["CUST_NRIC"] = (($RowData["nric"]==NULL OR $RowData["nric"]=="null") ? "" : $RowData["nric"]);


			$MainData["CUST_EMAIL"] = (($RowData["email"]==NULL OR $RowData["email"]=="null") ? "" : $RowData["email"]);
			if ( $MainData["CUST_TYPE"] == 0 ) {
				$MainData["ACCOUNT_IMAGE"] = "http://810speedmart.com/api/images/member_login_2.png";
				$MainData["CUST_CARD_BG"] = "";

				$MainData["CUST_EXPIRY_DATE"] = "-";
				$MainData["CUST_EXPIRY"] = 1;
			} else if ( $MainData["CUST_TYPE"] == 2 ) {
				$MainData["ACCOUNT_IMAGE"] = "http://810speedmart.com/api/images/member_upgrade.png";
				$MainData["CUST_CARD_BG"] = "http://810speedmart.com/api/images/membercard_free.png";

				$MainData["CUST_EXPIRY_DATE"] = "-";
				$MainData["CUST_EXPIRY"] = 1;
			} else {
				$MainData["CUST_CARD_BG"] = "http://810speedmart.com/api/images/membercard_paid.png";

				$MainData["CUST_EXPIRY_DATE"] = date("d M Y", strtotime($RowData["expired"]));
				$MainData["CUST_EXPIRY"] = ($RowData["expired"] >= date("Y-m-d") ? 0 : 1);
			}

			//
			// My Point
			$MainData["POINT_TOTAL"] = $RowData["point"] ." PTS";
			$MainData["POINT_LAST"] = "-";
			$MainData["POINT_LAST_DATE"] = "-";

			$SqlTra_Select = "SELECT s.* FROM data_sales_transaction s WHERE sbclient_id = '".$DWUserContact."' AND active IN (1,3,6) ORDER BY s.created DESC LIMIT 10";
			$RstTra_Select = mysql_query($SqlTra_Select);
			while ($TraData = mysql_fetch_assoc($RstTra_Select)) {
				unset($TransactionData);
				$TransactionData["DATE"] = date("d M Y h:i A", strtotime($TraData["created"]));// "01 MAY 2019 03:42 PM";
				$TransactionData["LOCATION"] = OutletDisplay($TraData["trxnum"]);//"Sri Rampai";//$TraData["trxnum"];
				$TransactionData["AMOUNT"] = "RM ".$TraData["trxtotal"];
				$TransactionData["POINT"] = $TraData["trxpoint_desc"];//number_format($TraData["trxtotal"])." pts";
				$MainData["POINT_LIST"][] = $TransactionData;
			}


		}

		$Sql_Select = "SELECT n.* FROM data_customer d INNER JOIN data_notification n ON (n.customer_id=d.id) WHERE d.tel = '".$DWUserContact."' AND n.push_notification = 1 AND d.tel <> '' AND d.active > 0 AND n.active = 1 AND n.read = 0 AND (n.created BETWEEN '".$DWDayFirst."' AND '".$DWDayLast."') ORDER BY n.id DESC";
		$Rst_Select = mysql_query($Sql_Select);
		while ($RowData = mysql_fetch_assoc($Rst_Select)) {
			unset($BannerData);
			$BannerData["ID"] = $RowData["id"];
			$BannerData["THUMB"] = $RowData["thumbnail"];
			$BannerData["THUMB_ALIGN"] = ($RowData["thumbnail_align"]==0 ? "start" : "end");//start , end
			$BannerData["TITLE"] = $RowData["title"];
			$BannerData["TITLE1"] = $RowData["title1"];
			$BannerData["TITLE2"] = $RowData["title2"];
			$BannerData["READ"] = $RowData["read"];
			$BannerData["TYPE"] = $RowData["type"];
			$BannerData["DATESHOW"] = date("Y/m/d", strtotime($RowData["created"]));
			if ($BannerData["TYPE"] == 1) {
				$BannerData["ALL_INFO"] = $RowData["html"];
			} else {
				unset($BannerPages);
				$BannerPages = json_decode($RowData["banner"]);
				$BannerData["ALL_PAGES"] = $BannerPages;
			}
			$MainData_Info[] = $BannerData;
		}

		$MainData["NOTIFICATION"] = $MainData_Info;

		$MainData["status"] = "1";
		$MainData["status_message"] = "";
	} else {
		$MainData["ACCOUNT_IMAGE"] = "http://810speedmart.com/api/images/member_login_2.png";
		$MainData["status"] = "0";
		$MainData["status_message"] = "Need Login";
	}

	$SqlSetting_Select = "SELECT d.* FROM data_apps_setting d WHERE d.title = 'HOME_BANNER_BACKGROUND' ";
	$RstSetting_Select = mysql_query($SqlSetting_Select);
	while ($SettingData = mysql_fetch_assoc($RstSetting_Select)) {
		$MainData["BANNER_BG"] = $SettingData["data"];
	}


	if ( $DWMode == "TEST" ) {
		echo "<pre>";
		print_r($MainData);
		echo "</pre>";
	}

	echo json_encode($MainData);
	exit;
?>