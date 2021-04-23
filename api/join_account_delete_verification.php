<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/join_account_verification.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://stargloryasia.com/".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);



	/* ******************************************************************
		Return Info
		1. status - Info = 0: Error, 1: Success
		2. status_message = Show Status Message
		** All Customer Personal Info

	****************************************************************** */
	$DWUserContact = ReturnValidContact($_REQUEST["contactno"]);
	$DWUserContactChild = ReturnValidContact($_REQUEST["join_contactno"]);
	$DWOtp = $_REQUEST["otp"];

	function find_group_id($contact_no) //untuk cari contact no tu punya group kalau ada
	{
		$con = getdb();
		$sql_find_group = "SELECT * FROM data_customer WHERE contact_no = '".$contact_no."' AND active = 1";
		$q_find_group = mysqli_query($con,$sql_find_group);
		$col_group_id = '';

		if (mysqli_num_rows($q_find_group) > 0) {
			$row = mysqli_fetch_assoc($q_find_group);
			$col_group_id = $row['group_id'];
		}
		else
		{
			return 0;
		}
		return $col_group_id;
	}

	$con = getdb();
	$Sql_Select = "SELECT d.* FROM data_customer d WHERE d.contact_no = '".$DWUserContactChild."' AND d.otp = '".$DWOtp."' AND d.active =1 LIMIT 1";

	$rst_otp = mysqli_query($con,$Sql_Select);

	if ( mysqli_num_rows($rst_otp) > 0 ) {

	$Rst_Select = mysqli_query($con,$Sql_Select);

		if ( mysqli_num_rows($Rst_Select) > 0 ) {

			$row = mysqli_fetch_assoc($Rst_Select);
			$row;
			$DWID = $row["id"];
			$DWActive = $row["active"];

			// Update Info and Disable First Time Setting
			$Sql_Update = "UPDATE data_customer SET group_id = NULL, contact_no = '".$DWUserContactChild."',  firsttime = NOW(),active = 1 WHERE id = '".$DWID."'";
			$Rst_Update = mysqli_query($con,$Sql_Update);

			$MainData["contactno"] = $DWUserContact;
			$MainData["join_contactno"] = $DWUserContactChild;
			$MainData["otp"] = $DWOtp;

			//$MainData["firstpage"] = "/tabs/member";
			$MainData["firstpage"] = "/tabs/register";
				
			$MainData["status"] = "1";
			$MainData["status_message"] = "Join Account Successfully Removed.";
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