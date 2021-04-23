<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/register_otp_verification.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://stargloryasia.com/".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	
	/* ******************************************************************
		Return Info
		1. status - Info = 0: Error, 1: Success
		2. status_message = Show Status Message
		** All Customer Personal Info

	****************************************************************** */
	$DWUserContact = ReturnValidContact($_REQUEST["contactno"]);
	$DWOtp = $_REQUEST["otp"];

	$con = getdb();
	$Sql_Select = "SELECT d.* FROM data_customer d WHERE d.contact_no = '".$DWUserContact."' AND d.otp = '".$DWOtp."' AND d.active > 0 LIMIT 1";

	$rst_otp = mysqli_query($con,$Sql_Select);

	if ( mysqli_num_rows($rst_otp) > 0 ) {

	$Rst_Select = mysqli_query($con,$Sql_Select);

		if ( mysqli_num_rows($Rst_Select) > 0 ) {

			$row = mysqli_fetch_assoc($Rst_Select);
			$row;
			$DWID = $row["id"];
			$DWActive = $row["active"];

			// Update Info and Disable First Time Setting
			$Sql_Update = "UPDATE data_customer SET contact_no = '".$DWUserContact."', otp = '".$DWOtp."', firsttime = NOW(),active = 2 WHERE id = '".$DWID."'";
			$Rst_Update = mysqli_query($con,$Sql_Update);

			$MainData["contactno"] = $DWUserContact;
			$MainData["otp"] = $DWOtp;

			//$MainData["firstpage"] = "/tabs/member";
			$MainData["firstpage"] = "/tabs/register";
				
			$MainData["status"] = "1"; // register_sign_up
			$MainData["status_message"] = "OTP has been Approved. Please register to continue.";
		} else {
			$MainData["status"] = "0";
			$MainData["status_message"] = "Please enter OTP Number.";
		}

	}else{
		$MainData["status"] = "0";
		$MainData["status_message"] = "Incorrect OTP Number";
	}	
	
	echo json_encode($MainData);
	exit;
?>