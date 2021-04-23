<?php
	include 'conf.php';
	// include 'barcodegenerator.php';
	// include 'barcode.php';
	require 'vendor/autoload.php';

    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/register_sign_up.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://cloone.my/".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************
		Return Info
		1. status - Info = 0: Error, 1: Success
		2. status_message = Show Status Message
		** All Customer Personal Info

	****************************************************************** */
	$DWUserContact = ReturnValidContact($_REQUEST["contactno"]);
	$name 	= $_REQUEST["name"];
	$email 	= $_REQUEST["email"];
	$ic_no 	= $_REQUEST["icNumber"];
	$date_of_birth = $_REQUEST["dob"];
	$gender  = $_REQUEST["gender"];
	$address = $_REQUEST["address"];
	$country = $_REQUEST["country"];
	$state   = $_REQUEST["state"];
	$zipcode = $_REQUEST["zipcode"];
	$city = $_REQUEST["city"];
	$race = $_REQUEST["race"];

	
	// generate then save -- https://github.com/picqer/php-barcode-generator
	$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
	$path_to_save_barcode = '../barcode_img/';
	$barcode_img_name = $DWUserContact.'_'.uniqid().'.png';
	$barcode_value = $DWUserContact;
	file_put_contents($path_to_save_barcode.$barcode_img_name, $generator->getBarcode($barcode_value, $generator::TYPE_CODE_128));

	// grab balik
	// $path_to_get_barcode_img = $__domain_url.'barcode_img/'.$barcode_img_name;
	// echo $path_to_get_barcode_img;
	

		$con = getdb();
		$Sql_Select = "SELECT d.* FROM data_customer d WHERE d.contact_no = '".$DWUserContact."' AND d.active =1 LIMIT 1";
		$Rst_Select = mysqli_query($con,$Sql_Select);

		if ( mysqli_num_rows($Rst_Select) > 0 ) {

			$row = mysqli_fetch_assoc($Rst_Select);
			$row;
			$DWID = $row["id"];
			$DWActive = $row["active"];
			// $barcode = bar128(stripcslashes($DWUserContact));

			$Sql_Update = "UPDATE data_customer SET name = '".$name."',profile_picture	='default-profile.png', barcode	= '".$barcode_img_name."', group_id = NULL, contact_no = '".$DWUserContact."', email = '".$email."', ic_no = '".$ic_no."', date_of_birth = '".$date_of_birth."' , address = '".$address."', city = '".$city."', country = '".$country."', state = '".$state."', zipcode = '".$zipcode."', gender = '".$gender."' , race = '".$race."' , active = 1 WHERE id = '".$DWID."'";
			$Rst_Update = mysqli_query($con,$Sql_Update);

			$SqlPoint_Insert = "INSERT INTO data_customer_points (contact_no, points, group_id, point_type, description, transaction_date, created, active) VALUES ('".$DWUserContact."', 300, NULL, 1, 'Welcome Point', NOW(), NOW(), 1)  ";
			$RstPoint_Insert = mysqli_query($con,$SqlPoint_Insert);

			$MainData["contactno"] = $DWUserContact;
			$MainData["name"]  = $name;
			// $MainData["barcode"]  = $barcode_img_name;
			$MainData["email"] = $email;
			$MainData["ic_no"] = $ic_no;
			$MainData["date_of_birth"] = $date_of_birth;
			$MainData["address"]   = $address;
			$MainData["city"]   = $city;
			$MainData["state"]     = $state	;
			$MainData["country"]   = $country;
			$MainData["gender"]   = $gender;
			$MainData["race"]   = $race;

			//$MainData["firstpage"] = "/tabs/member";
			$MainData["firstpage"] = "/tabs/home";
				
			$MainData["status"] = "1";
			$MainData["status_message"] = "Register Successfully.";
		} else {
			$MainData["status"] = "0";
			$MainData["status_message"] = "Sorry, fail to register. Please try again";
		}
	
	echo json_encode($MainData);
	exit;
?>