<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/join_account_list.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://stargloryasia.com/".$_SERVER['REQUEST_URI']."\n".$req_dump);
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

	$group_id = find_group_id($DWUserContact);
	$Sql_Select = "SELECT d.* FROM data_customer d WHERE d.group_id = '".$group_id."'";
	// $Sql_Select = "SELECT d.* FROM data_customer d WHERE d.parent_contact_no = '".$DWUserContact."' AND d.parent_contact_no != d.contact_no";
	$Rst_Select = mysqli_query($con,$Sql_Select);
	$join_count = mysqli_num_rows($Rst_Select);

	$con = getdb();
	mysqli_set_charset($con, "utf8");

	if ( mysqli_num_rows($Rst_Select) > 0 ) {
		$rowAll = array();

		while($row = mysqli_fetch_array($Rst_Select)) {
			// $row = mysqli_fetch_assoc($Rst_Select);
			// $row;

			$data['id']  = $row["id"]; 
			$data['name']  = $row["name"]; 
			$data['dob']   = $row["date_of_birth"];
			$data['join_contactno']   = $row["contact_no"];

			$rowAll[] = $data;
		}
		
		$status = 1;
		$status_message = 'You have no join account with anyone at the moment';
		$firstpage["firstpage"] = "/tabs/home";
		

		}
		else {
			$rowAll[] = ''; 
			$status = 0;
			$status_message = 'You have no join account with anyone at the moment';
			$firstpage = '' ;
		}
		
	$MainData["JOIN"] = $rowAll;
	$MainData["JOIN_COUNT"] = $join_count;
	$MainData["contactno"] = $DWUserContact;
	$MainData["firstpage"] = $firstpage;
	$MainData["status"] = $status;
	$MainData["status_message"] = $status_message;
	
	echo json_encode($MainData);
	exit;
?>