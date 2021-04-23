<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/account.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://cloone.my".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************

		Query Function & Print JSON Data
		810 Member Edit API
		Sample URL: http://810speedmart.com/api/member_edit.php?contactno=[CONTACTNO or '' (EMPTY)]&info={"password":"YIJAKJDW","email":"test@example.com"}
		Pass Info
		- info (JSON Format)
			- password
			- email

		Return Info
		- status - Info = 0: Error, 1: Success
		- status_message = Show Status Message

	****************************************************************** */
	$DWUserContact = ReturnValidContact($_REQUEST["contactno"]);
	
	$con = getdb();

	function find_group_id($contact_no) //untuk cari contact no tu punya group kalau ada
	{
		$con = getdb();
		$sql_find_group = "SELECT * FROM data_customer WHERE contact_no = '".$contact_no."' AND active = 1";
		
		$q_find_group = mysqli_query($con,$sql_find_group);
		// $col_parent_contact_no = '';
		$col_group_id = '';

		if (mysqli_num_rows($q_find_group) > 0) {
			$row = mysqli_fetch_assoc($q_find_group);
			$col_group_id = $row['group_id'];//mysqli_fetch_assoc($q_find_parent, 0, "parent_contact_no");
			// $col_contact_no = $row['contact_no'];//mysqli_fetch_assoc($q_find_parent, 0, "contact_no");
		}
		else
		{
			return 0;
		}

		return $col_group_id;
		// if($col_parent_contact_no == $col_contact_no)
		// {
		// 	return $col_contact_no;
		// }
		// else
		// {
		// 	return $col_parent_contact_no;
		// }
		
	}

	///////////////////////////////////////////////////GROUP/////////////////////////////////////////////////////////
	function getGroup_add_point($contact_no)
	{
		$group_id = find_group_id($contact_no);
		if($group_id == 0)
		{
			return 0;
		}

		$sql = "SELECT SUM(points) as pts FROM data_customer_points WHERE group_id = '".$group_id."' AND active = 1 and point_type='1'";
		$con = getdb();
		$q = mysqli_query($con,$sql);
		$col_pts = 0;
		if (mysqli_num_rows($q) > 0) {
			$row = mysqli_fetch_assoc($q);
			$col_pts = $row['pts'];//mysqli_fetch_assoc($q, 0, "pts");
		}

		return $col_pts;
	}

	function getGroup_deduct_point($contact_no)
	{
		$group_id = find_group_id($contact_no);
		if($group_id == 0)
		{
			return 0;
		}

		$sql = "SELECT SUM(points) as pts FROM data_customer_points WHERE group_id = '".$group_id."' AND active = 1 and point_type='0'";
		$con = getdb();
		$q = mysqli_query($con,$sql);
		$col_pts = 0;
		if (mysqli_num_rows($q) > 0) {
			$row = mysqli_fetch_assoc($q);
			$col_pts = $row['pts'];//mysqli_fetch_assoc($q, 0, "pts");
		}

		return $col_pts;
	}

	function getGroup_point($contact_no)
	{
		$group_add_point = getGroup_add_point($contact_no);
	
		$group_deduct_point = getGroup_deduct_point($contact_no);
		
		$balance_point = $group_add_point - $group_deduct_point;
		
		return $balance_point;
	}
	///////////////////////////////////////////////////GROUP/////////////////////////////////////////////////////////



	///////////////////////////////////////////////////SINGLE/////////////////////////////////////////////////////////
	function getIndividual_add_point($contact_no)
	{
		$sql = "SELECT SUM(points) as pts FROM data_customer_points WHERE contact_no = '".$contact_no."' AND active = 1 and point_type='1'";
		$con = getdb();
		$q = mysqli_query($con,$sql);
		$col_pts = 0;
		if (mysqli_num_rows($q) > 0) {
			$row = mysqli_fetch_assoc($q);
			$col_pts = $row['pts'];//mysqli_fetch_assoc($q, 0, "pts");
		}

		return $col_pts;
	}

	function getIndividual_deduct_point($contact_no)
	{
		$sql = "SELECT SUM(points) as pts FROM data_customer_points WHERE contact_no = '".$contact_no."' AND active = 1 and point_type='0'";
		$con = getdb();
		$q = mysqli_query($con,$sql);
		$col_pts = 0;
		if (mysqli_num_rows($q) > 0) {
			$row = mysqli_fetch_assoc($q);
			$col_pts = $row['pts'];//mysqli_fetch_assoc($q, 0, "pts");
		}

		return $col_pts;
	}

	function getIndividual_point($contact_no)
	{
		$individual_add_point = getIndividual_add_point($contact_no);
	
		$individual_deduct_point = getIndividual_deduct_point($contact_no);
		
		$balance_point = $individual_add_point - $individual_deduct_point;
		
		return $balance_point;
	}
	///////////////////////////////////////////////////SINGLE/////////////////////////////////////////////////////////

	///////////UNTUK TAHU POINT CUSTOMER//////////////////
	$con = getdb();
	$group_id = find_group_id($DWUserContact);
	$DWCustPoint = 0;
	$SqlCust_Select = "SELECT d.* FROM data_customer d WHERE d.active > 0 AND d.group_id = '".$group_id."'";
	$RstCust_Select = mysqli_query($con,$SqlCust_Select);

	if (mysqli_num_rows($RstCust_Select) > 0) {
		$DWCustPoint = getGroup_point($DWUserContact);
	}
	else{
		$DWCustPoint = getIndividual_point($DWUserContact);
	}
	///////////UNTUK TAHU POINT CUSTOMER//////////////////

	$Sql_Select = "SELECT d.*, LOWER(d.name) as nameSmall,LOWER(d.gender) as genderSmall,LOWER(d.address) as addressSmall,LOWER(d.city) as citySmall,LOWER(d.country) as countrySmall,LOWER(d.state) as stateSmall,LOWER(d.race) as raceSmall FROM data_customer d LEFT JOIN data_customer_points c ON (c.contact_no = d.contact_no) WHERE d.active = 1 AND d.contact_no = '".$DWUserContact."' LIMIT 1";
	$Rst_Select = mysqli_query($con,$Sql_Select);

	if ( mysqli_num_rows($Rst_Select) > 0 ) {

		$row = mysqli_fetch_assoc($Rst_Select);
		$row;
		
		$id    = $row["id"];
		$name  = ucwords($row["nameSmall"]);
		$email = $row["email"]; 
		$dob   = $row["date_of_birth"];
		$icNumber   = $row["ic_no"];
		$gender  = ucwords($row["genderSmall"]);
		$address = ucwords($row["addressSmall"]); 
		$city = ucwords($row["citySmall"]); 
		$country = ucwords($row["countrySmall"]); 
		$countryBig = strtoupper($row["countrySmall"]); 
		$state   = ucwords($row["stateSmall"]);
		$zipcode = $row["zipcode"];
		$race = ucwords($row["raceSmall"]);
		$barcode = "http://cloone.my/demo/starglory-admin/barcode_img/". $row["barcode"];
		
		$status = 1;
		$status_message = 'Success display account details.';
		$firstpage["firstpage"] = "/tabs/home";
		}
		else {
			$rowAll[] = ''; 
			$status = 0;
			$status_message = 'No data found';
			$firstpage = '' ;
		}
		
	$MainData["id"] = $id;
	$MainData["barcode"] = $barcode;
	$MainData["name"] = $name;
	$MainData["email"] = $email;
	$MainData["dob"] = $dob;
	$MainData["icNumber"] = $icNumber;
	$MainData["gender"] = $gender;
	$MainData["address"] = $address;
	$MainData["city"] = $city;
	$MainData["country"] = $country;
	$MainData["countryBig"] = $countryBig;
	$MainData["state"] = $state;
	$MainData["race"] = $race;
	$MainData["zipcode"] = $zipcode;
	$MainData["contactno"] = $DWUserContact;
	$MainData["firstpage"] = $firstpage;
	$MainData["status"] = $status;
	$MainData["status_message"] = $status_message;
	$MainData["POINT"] = $DWCustPoint;
	// $MainData["photo"] = $photo;

	
	echo json_encode($MainData);
	exit;
?>