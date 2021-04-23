<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/forget_password.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://810speedmart.com/".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************

		Query Function & Print JSON Data
		810 Forget Password API
		Sample URL: http://810speedmart.com/api/forget_password.php?contactno=[CONTACTNO]&password=[PASSWORD]&otp=[OTP]

		Return Info
		1. status - Info = 0: Error, 1: Success
		2. status_message = Show Status Message
		** All Customer Personal Info

	****************************************************************** */
	$DWUserContact = ReturnValidContact($_REQUEST["contactno"]);
	$DWUserPassword = $_REQUEST["password"];
	$DWUserOTP = $_REQUEST["otp"];

	$Sql_Select = "SELECT d.* FROM data_customer d WHERE d.tel = '".$DWUserContact."' AND otp = '".$DWUserOTP."' AND active > 0";
	$Rst_Select = mysql_query($Sql_Select);
	if ( mysql_num_rows($Rst_Select) > 0 ) {
		
		$DWID = mysql_result($Rst_Select, 0, "id");
		
		$Sql_Update = "UPDATE data_customer SET password = '".md5($DWUserPassword)."' WHERE id = '".$DWID."'";
		$Rst_Update = mysql_query($Sql_Update);

		$MainData["status"] = "1";
		$MainData["status_message"] = "";

	} else {

		$MainData["status"] = "0";
		$MainData["status_message"] = "Invalid OTP or Contact Number";

	}
	
	
	echo json_encode($MainData);
	exit;
?>