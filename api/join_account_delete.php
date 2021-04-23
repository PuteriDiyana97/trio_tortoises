<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/join_account_delete.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://stargloryasia.com/".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);


	/* ******************************************************************
		Return Info
		1. status - Info = 0: Error, 1: Success
		2. status_message = Show Status Message
		** All Customer Personal Info

	****************************************************************** */
	 //$_REQUEST["contactno"] = '01234567844';

	 $DWUserContact = ReturnValidContact($_REQUEST["contactno"]);
	 $DWUserContactChild = ReturnValidContact($_REQUEST["join_contactno"]);
	 $DWOTPNumber = rand(1000, 9999);

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

  
	 //echo "<br />".
	 if(!empty($DWUserContact) && $DWUserContact !='')
	 {
		 $con = getdb();
		 $Sql_Select = "SELECT d.* FROM data_customer d WHERE d.contact_no = '".$DWUserContactChild."'";
		 $Rst_Select = mysqli_query($con,$Sql_Select);
 
	 
		 if ( mysqli_num_rows($Rst_Select) > 0 ) { //means dah ada data child tu
 
			$search_group_id = find_group_id($DWUserContactChild);
			$Sql_SelectParent = "SELECT d.* FROM data_customer d WHERE d.group_id = '".$search_group_id."'";
			 $Rst_SelectParent = mysqli_query($con,$Sql_SelectParent);
			 
			 if ( mysqli_num_rows($Rst_SelectParent) > 0 ) { //means child tu ada dalam group

				$Sql_Update = "UPDATE data_customer SET otp = '".$DWOTPNumber."', group_id = NULL WHERE contact_no = '".$DWUserContactChild."'";
				$Rst_Update = mysqli_query($con,$Sql_Update);

				$SqlPoint_Update = " UPDATE data_customer_points SET group_id = NULL WHERE contact_no = '".$DWUserContactChild."'";
				$RstPoint_Update = mysqli_query($con,$SqlPoint_Update);

				// $Sql_UpdateMain = "UPDATE data_customer SET group_id = NULL WHERE contact_no = '".$DWUserContact."'";
				// $Rst_UpdateMain = mysqli_query($con,$Sql_UpdateMain);

				// $SqlPoint_UpdateMain = " UPDATE data_customer_points SET group_id = NULL WHERE contact_no = '".$DWUserContact."'";
				// $RstPoint_UpdateMain = mysqli_query($con,$SqlPoint_UpdateMain);
				
				//Send SMS Function
				SendSMS($DWUserContactChild, $DWOTPNumber);
				
				// Return TRUE
				$MainData["contactno"] = $DWUserContact;
				$MainData["join_contactno"] = $DWUserContactChild;
				$MainData["otp"] = $DWOTPNumber;
				$MainData["status"] = "1";
				$MainData["status_message"] = "You will receive your OTP code via SMS.";
			 }	 
			 else { //means child tu takda group pun

				$MainData["status"] = "0";
				$MainData["status_message"] = "Sorry, contact number does not exist. Please register";
			 }
		 } 
		 else { //kena hantar message suruh child register dulu
			 
			 $MainData["status"] = "0";
			 $MainData["status_message"] = "Sorry, contact number does not exist. Please register";
		 }
	 }else{
 
			 $MainData["status"] = "0";
			 $MainData["status_message"] = "Please enter contact number";
 
	 }



	echo json_encode($MainData);
	exit;
?>