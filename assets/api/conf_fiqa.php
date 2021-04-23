<?php

	error_reporting (E_WARNING);
	date_default_timezone_set("Asia/Kuala_Lumpur");
	header("Access-Control-Allow-Origin: *");
	

	function getdb(){
    //$servername = "localhost";
    //$username = "root";
    //$password = "";
    //$db = "senheng1";
//    /ob_start();
    //session_start();
    
    define('MYSQL_SERVER', 'localhost', true);
	define('MYSQL_DATABASE', 'cloonemy_stargloryadmin', true);
	define('MYSQL_USER', 'cloonemy_stargloryadmin', true);
	define('MYSQL_PASSWORD', '@oasis98', true);

	$mysql_server = MYSQL_SERVER;
	$mysql_database = MYSQL_DATABASE;
	$mysql_user = MYSQL_USER;
	$mysql_password = MYSQL_PASSWORD;

    try {

        $conn = mysqli_connect($mysql_server, $mysql_user, $mysql_password, $mysql_database);
      
    }
    catch(exception $e)
    {
        echo "Connection failed: " . $e->getMessage();
        // die();
    }
    return $conn;
}

	function ReturnValidContact($DWCustContact) {
		$DWCustContact = str_replace(array(" ", "-", ".", ",", "+"), "", $DWCustContact);
		if ( substr($DWCustContact, 0, 1) != "6" && !empty($DWCustContact) ) {
			$DWCustContact = "6".$DWCustContact;
		}

		return $DWCustContact;
	}

	function SendSMS($DWCustContact, $DWOTPCode) {
		$DWSMSContent = "Your OTP No. is ".$DWOTPCode.". Request to login Moonlight APP on ".date("Y-m-d H:i:s").". Code will expire in 3 mins.";

		//$DWFullText = "http://bulk.ezlynx.net:7001/BULK/BULKMT.aspx?user=dwarmnp&pass=dwaremnpmc0711&smstype=TEXT&msisdn=".$DWCustContact."&body=".urlencode($DWSMSContent)."&Sender=DWare&ServiceName=DWARE";
		$DWFullText = "http://www.etracker.cc/bulksms/mesapi.aspx?user=senhengotp&pass=Senheng@188&type=0&to=".$DWCustContact."&from=Senheng&text=".urlencode($DWSMSContent)."&servid=MES01&title=OTP&detail=1";

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

	function OutletDisplay($TrnNumber) {
		$DWOutlet = "Sri Rampai";
		if ( substr($TrnNumber, 0, 4) == "S001" ) {
            $DWOutlet = "Sri Rampai";
        } else if ( substr($TrnNumber, 0, 4) == "S002" ) {
            $DWOutlet = "Wangsa Maju";
        } else if ( $TrnNumber == "ONLINE CLAIM" ) {
            $DWOutlet = "Voucher Claimed";
        }
        return $DWOutlet;
	}


?>