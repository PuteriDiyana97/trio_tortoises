<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/forget_password_otp.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://810speedmart.com/".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************

		Query Function & Print JSON Data
		810 Forget Password, Request OTP API
		Sample URL: http://810speedmart.com/api/forget_password_otp.php?contactno=[CONTACTNO]

		Return Info
		1. status - Info = 0: Error, 1: Success
		2. status_message = Show Status Message
		3. otp_message = OTP for App Checking
		** All Customer Personal Info

	****************************************************************** */
	$DWUserContact = ReturnValidContact($_REQUEST["contactno"]);
	$DWOTPNumber = rand(100000, 999999);

	$Sql_Select = "SELECT d.* FROM data_customer d WHERE d.tel = '".$DWUserContact."' AND active > 0";
	$Rst_Select = mysql_query($Sql_Select);
	if ( mysql_num_rows($Rst_Select) > 0 ) {
		
		$DWID = mysql_result($Rst_Select, 0, "id");
		$DWActive = mysql_result($Rst_Select, 0, "active");
		$DWUserContact = mysql_result($Rst_Select, 0, "tel");

		$Sql_Update = "UPDATE data_customer SET otp = '".$DWOTPNumber."' WHERE id = '".$DWID."'";
		$Rst_Update = mysql_query($Sql_Update);
		//
		// Send SMS Function
		SendSMS($DWUserContact, $DWOTPNumber);
		//
		// Contact Existing in DB with Pending as Activate
		$MainData["status"] = "1";
		$MainData["status_message"] = "";
		$MainData["otp_message"] = $DWOTPNumber;

	} else {

		$MainData["status"] = "0";
		$MainData["status_message"] = "Invalid Customer Contact";

	}
	
	
	echo json_encode($MainData);
	exit;
?>