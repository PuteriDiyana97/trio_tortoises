<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
	$DWUserContact = ReturnValidContact($_REQUEST["contactno"]);
	$_REQUEST['modified_contact'] = $DWUserContact;
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/login_otp.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://starglorygroup.com/".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);


	/* ******************************************************************
		Return Info
		1. status - Info = 0: Error, 1: Success
		2. status_message = Show Status Message
		** All Customer Personal Info
			- Active = 1: Paid Member, 2: Free Member
			- firsttime_login = 1: Yes, 0: No
			- name = Please put in Update page
			- email = Please put in Update page
			- BANNER_BG = Background Image

	****************************************************************** */
	$DWUserContact = ReturnValidContact($_REQUEST["contactno"]);
	// echo $DWUserContact; die();
	$DWOTPNumber = rand(1000, 9999);

	if(!empty($DWUserContact) && $DWUserContact !='')
	{
		if($DWUserContact == "60123456788") { //60107631360
			$MainData["contactno"] = $DWUserContact;
			$MainData["status"] = "1";
			$MainData["status_message"] = "Your OTP number is 1111.";
		}
		else {
			$con = getdb();
			$Sql_Select = "SELECT d.* FROM data_customer d WHERE d.contact_no = '".$DWUserContact."' AND d.active > 0";
			$Rst_Select = mysqli_query($con,$Sql_Select);

			if ( mysqli_num_rows($Rst_Select) > 0 ) {

				$row = mysqli_fetch_assoc($Rst_Select);
				$row;
				$DWID = $row["id"];
				$DWActive = $row["active"]; //1:verify 2:not verify(new number)

				if ( $DWActive == 1 ) {
					//echo "<br>".
					$Sql_Update = " UPDATE data_customer SET otp = '".$DWOTPNumber."' WHERE id = '".$DWID."'";
					$Rst_Update = mysqli_query($con,$Sql_Update);
					//
					// Send SMS Function
					SendSMS($DWUserContact, $DWOTPNumber);
					//
					// Contact Existing in DB with Pending as Activate
					$MainData["contactno"] = $DWUserContact;
					$MainData["status"] = "1"; //login_otp_verification
					$MainData["status_message"] = "You will receive your OTP code via SMS.";
				} 
				else {
					//
					$Sql_Update = " UPDATE data_customer SET otp = '".$DWOTPNumber."' WHERE id = '".$DWID."'";
					$Rst_Update = mysqli_query($con,$Sql_Update);
					//
					// Send SMS Function
					SendSMS($DWUserContact, $DWOTPNumber);
					// Contact is Activated
					$MainData["status"] = "2"; //register_otp_verification
					$MainData["status_message"] = "Please sign up to continue. Thank you."; //Sorry, contact number not registered, please sign up to continue. Thank you.
				}
				
			} else {
				
				$Sql_Insert = "INSERT INTO data_customer (contact_no, otp, updated, created, active) VALUES ('".$DWUserContact."','".$DWOTPNumber."', NOW(), NOW(), 2)";
				$Rst_Insert = mysqli_query($con,$Sql_Insert);
				// if($Rst_Insert) {
				// 	$MainData["mm"] = 'yeahhh';
				// } else {
				// 	$MainData["mm"] = 'ouhh snap ' . mysqli_error($con);
				// }
				
				//Send SMS Function
				SendSMS($DWUserContact, $DWOTPNumber);
				
				// Return TRUE
				$MainData["contactno"] = $DWUserContact;
				$MainData["otp"] = $DWOTPNumber;
				$MainData["status"] = "2";
				$MainData["status_message"] = "Please sign up to continue. Thank you.";
			}

		}
		
	}else{

			$MainData["status"] = "0";
			$MainData["status_message"] = "Please enter contact number";

	}

	echo json_encode($MainData);
	exit;
?>