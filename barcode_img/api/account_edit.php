<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/account_edit.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://cloone.my".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************
		Return Info
		- status - Info = 0: Error, 1: Success
		- status_message = Show Status Message

	****************************************************************** */
	$DWUserContact = ReturnValidContact($_REQUEST["contactno"]);
	$name 	= strtoupper($_REQUEST["name"]);
	$email 	= strtolower($_REQUEST["email"]);
	// $ic_no 	= ($_REQUEST["icNumber"]);
	// $date_of_birth = ($_REQUEST["dob"]);
	$city  = strtolower($_REQUEST["city"]);
	$address = strtolower($_REQUEST["address"]);
	$country = strtolower($_REQUEST["country"]);
	$state   = strtoupper($_REQUEST["state"]);
	$zipcode = ($_REQUEST["zipcode"]);
	
	$con = getdb();
	$Sql_Select = "SELECT * FROM data_customer WHERE contact_no = '".$DWUserContact."' AND active = 1 LIMIT 1";
	$Rst_Select = mysqli_query($con,$Sql_Select);

	if ( mysqli_num_rows($Rst_Select) > 0 ) {

	$Rst_Select = mysqli_query($con,$Sql_Select);

		if ( mysqli_num_rows($Rst_Select) > 0 ) {

			$row = mysqli_fetch_assoc($Rst_Select);
			$row;
			$DWID = $row["id"];
			$DWActive = $row["active"];

			// Update Info 
			$Sql_Update = "UPDATE data_customer SET name = '".$name."', email = '".$email."', address = '".$address."', city = '".$city."', country = '".$country."', state = '".$state."', zipcode = '".$zipcode."', active = 1 WHERE id = '".$DWID."'";

			$Rst_Update = mysqli_query($con,$Sql_Update);

			$MainData["contactno"] = $DWUserContact;
			$MainData["name"]  = $name;
			$MainData["email"] = $email;
			$MainData["address"]   = $address;
			$MainData["city"]   = $city;
			$MainData["state"]     = $state;
			$MainData["country"]   = $country;
			$MainData["zipcode"]   = $zipcode;
				
			$MainData["status"] = "1";
			$MainData["status_message"] = "Your info has been updated, thank you.";
		} else {
			$MainData["contactno"] = $DWUserContact;
			$MainData["status"] = "0";
			$MainData["status_message"] = "Unable to update your info. Please try again.";
		}

	}else{
		$MainData["contactno"] = $DWUserContact;
		$MainData["status"] = "0";
		$MainData["status_message"] = "Please try again";
	}	
	
	echo json_encode($MainData);
	exit;
?>

