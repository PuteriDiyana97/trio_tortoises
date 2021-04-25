<?php

	error_reporting (E_WARNING);
	date_default_timezone_set("Asia/Kuala_Lumpur");
	header("Access-Control-Allow-Origin: *");
	
	/*define('MYSQL_SERVER', 'localhost', true);
	define('MYSQL_DATABASE', 'speedmar_810', true);
	define('MYSQL_USER', 'speedmar_cloone', true);
	define('MYSQL_PASSWORD', 'a%CP3%5Lm*XM', true);*/

	define('MYSQL_SERVER', 'localhost', true);
	define('MYSQL_DATABASE', 'cloonemy_stargloryadmin', true);
	//define('MYSQL_USER', 'freshmart', true);
	//define('MYSQL_PASSWORD', 't?n^GdLU#!x5iQHSXj', true);
	define('MYSQL_USER', 'cloonemy', true);
	define('MYSQL_PASSWORD', "#9ry>XE/w'wJ,_NS", true);

	$mysql_server = MYSQL_SERVER;
	$mysql_database = MYSQL_DATABASE;
	$mysql_user = MYSQL_USER;
	$mysql_password = MYSQL_PASSWORD;

	$db = mysql_connect($mysql_server,$mysql_user,$mysql_password) or die('Could not connect: ' . mysql_error());
	mysql_select_db($mysql_database, $db);
	mysql_query("set names 'utf8'",$db);

	function ReturnValidContact($DWCustContact) {
		$DWCustContact = str_replace(array(" ", "-", ".", ",", "+"), "", $DWCustContact);
		if ( substr($DWCustContact, 0, 1) != "6" ) {
			$DWCustContact = "6".$DWCustContact;
		}

		if ( substr($DWCustContact, 0, 4) == "6060" ) {
			$DWCustContact = substr($DWCustContact, 2);
		}
		return $DWCustContact;
	}

	function SendSMS($DWCustContact, $DWOTPCode) {
		$DWSMSContent = "Your OTP No. is ".$DWOTPCode.". Request to login StarGlory APP on ".date("Y-m-d H:i:s").". Code will expire in 3 mins.";

		$DWFullText = "http://bulk.ezlynx.net:7001/BULK/BULKMT.aspx?user=dwarmnp&pass=dwaremnpmc0711&smstype=TEXT&msisdn=".$DWCustContact."&body=".urlencode($DWSMSContent)."&Sender=DWare&ServiceName=DWARE";
		//$DWFullText = "http://www.etracker.cc/bulksms/mesapi.aspx?user=senhengotp&pass=Senheng@188&type=0&to=".$DWCustContact."&from=Senheng&text=".urlencode($DWSMSContent)."&servid=MES01&title=OTP&detail=1";

		//
		// SEND SMS
		if ( strlen($DWCustContact) > 9 ) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $DWFullText);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			curl_close($ch);
		}
	}

	function PointCal($DWTotal) {
		if ( $DWTotal > 0 ) {
            $DWTotalPoint = round($DWTotal, 0);
        } else {
            $DWTotalPoint = round($DWTotal * -1, 0);
        }
        return $DWTotalPoint;
	}

	function PointDisplay($DWTotal, $DWActive) {
        return $DWTotal;
	}

	function DWPriceLevel($DWPriceLevel) {
		if ( $DWPriceLevel == 0 ) {
            return "";
        } else {
            return "4.MB";
        }
	}

?>