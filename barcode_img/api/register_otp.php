<?php
    include 'conf.php';
    
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/register_otp.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://cloone.my".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************
		Return Info
		1. status - Info = 0: Error, 1: Success
		2. status_message = Show Status Message
		** All Customer Personal Info

	****************************************************************** */
	 //$_REQUEST["contactno"] = '01234567844';

	$DWUserContact = ReturnValidContact($_REQUEST["contactno"]);
	$DWOTPNumber = rand(1000, 9999);
 
	//echo "<br />".
	if(!empty($DWUserContact) && $DWUserContact !='')
	{
		$con = getdb();
		$Sql_Select = "SELECT d.* FROM data_customer d WHERE d.contact_no = '".$DWUserContact."'";
		$Rst_Select = mysqli_query($con,$Sql_Select);

	
		if ( mysqli_num_rows($Rst_Select) > 0 ) {

			$row = mysqli_fetch_assoc($Rst_Select);
			$row;
			$DWID = $row["id"];
			$DWActive = $row["active"]; 

			if ( $DWActive == 2 ) {
				
				$Sql_Update = " UPDATE data_customer SET otp = '".$DWOTPNumber."' WHERE id = '".$DWID."'";
				$Rst_Update = mysqli_query($con,$Sql_Update);
				
				// Send SMS Function
				SendSMS($DWUserContact, $DWOTPNumber);
				
				//Contact Existing in DB with Pending as Activate
				$MainData["status"] = "1";
				$MainData["status_message"] = "You will receive your OTP code via SMS.";
			} else {
				//
				// Contact is Activated
				$MainData["status"] = "0";
				$MainData["status_message"] = "Sorry, contact number already activated, please try another. Thank you.";
			}
			
		} else {
			//
			// Contact is NEW
			$Sql_Insert = "INSERT INTO data_customer (contact_no, otp, updated, created, active) VALUES ('".$DWUserContact."','".$DWOTPNumber."', NOW(), NOW(), 2)";
			$Rst_Insert = mysqli_query($con,$Sql_Insert);
			
			//Send SMS Function
			SendSMS($DWUserContact, $DWOTPNumber);
			
			// Return TRUE
			$MainData["contactno"] = $DWUserContact;
			$MainData["otp"] = $DWOTPNumber;
			$MainData["status"] = "1";
			$MainData["status_message"] = "You will receive your OTP code via SMS.";
		}
	}else{

			$MainData["status"] = "0";
			$MainData["status_message"] = "Please enter contact number";

	}
	
	
	echo json_encode($MainData);
	exit;
?>