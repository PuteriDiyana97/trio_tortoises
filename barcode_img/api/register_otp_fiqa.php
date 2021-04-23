<?php
    include 'conf_fiqa.php';
    
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/register_otp.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://cloone.my/".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************
		Return Info
		1. status - Info = 0: Error, 1: Success
		2. status_message = Show Status Message
		** All Customer Personal Info

	****************************************************************** */
	//http://cloone.my/demo/starglory-admin/api/register_otp.php
   $_REQUEST["contactno"] = '01390619255';

	echo $DWUserContact = ReturnValidContact($_REQUEST["contactno"]);
	$DWOTPNumber = rand(1000, 9999);
 
	//echo "<br />".
	if(!empty($DWUserContact) && $DWUserContact !=''){
	$con = getdb();
	$Sql_Select = "SELECT d.* FROM data_customer d WHERE d.contact_no = '".$DWUserContact."'";
	$Rst_Select = mysqli_query($con,$Sql_Select);

	
	if ( mysqli_num_rows($Rst_Select) > 0 ) {

		// $DWID = mysqli_result($Rst_Select, 0, "id");
		// $DWActive = mysqli_result($Rst_Select, 0, "active");

		$row = mysqli_fetch_assoc($Rst_Select);
		echo $row;
		echo $DWID = $row["id"];
		echo $DWActive = $row["active"];


		if ($DWActive == 2 ) {
			//echo "<br>".
			$Sql_Update = " UPDATE data_customer SET otp = '".$DWOTPNumber."' WHERE id = '".$DWID."'";
			$Rst_Update = mysqli_query($con,$Sql_Update);
			//
			// Send SMS Function
			// SendSMS($DWUserContact, $DWOTPNumber);
			//
			// Contact Existing in DB with Pending as Activate
			$MainData["status"] = "1";
			$MainData["status_message"] = "You will receive your OTP code via SMS.";
		} else {
			//
			// Contact is Activated
			$MainData["status"] = "0";
			$MainData["status_message"] = "Sorry, contact no. already existing and activated, please try another. Thank you.";
		}
		
	} else {
		//
		// Contact is NEW
		//echo "<br />".
		$Sql_Insert = "INSERT INTO data_customer (contact_no, otp, updated, created, active) VALUES ('".$DWUserContact."','".$DWOTPNumber."', NOW(), NOW(), 2)";
		$Rst_Insert = mysqli_query($con,$Sql_Insert);
		//
		// Send SMS Function
		// SendSMS($DWUserContact, $DWOTPNumber);
		//
		// Return TRUE
		$MainData["contactno"] = $DWUserContact;
		$MainData["status"] = "1";
		$MainData["status_message"] = "You will receive your OTP code via SMS.";
	}

}else{

		$MainData["status"] = "-1";
		$MainData["status_message"] = "Please Key in Contact Number";

}
	
	
	echo json_encode($MainData);
	exit;
?>