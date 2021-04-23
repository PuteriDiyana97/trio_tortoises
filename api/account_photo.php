<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/account.txt', 'a');
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
	$Sql_Select = "SELECT d.* FROM data_customer d LEFT JOIN data_customer_points c ON (c.contact_no = d.contact_no) WHERE d.active = 1 AND d.contact_no = '".$DWUserContact."' LIMIT 1";

	$Rst_Select = mysqli_query($con,$Sql_Select);

	if ( mysqli_num_rows($Rst_Select) > 0 ) {

		$row = mysqli_fetch_assoc($Rst_Select);
		$row;

		//$picture 	= "http://cloone.my/demo/starglory-admin/assets/upload_files/profile_picture/". $picture;
		//$MainData["profile_picture"]  = "http://cloone.my/demo/starglory-admin/assets/upload_files/profile_picture/". $row["profile_picture"];

		$photo = "http://starglorygroup.com/admin_sg/assets/upload_files/profile_picture/". $row["profile_picture"];
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
		
	$MainData["photo"] = $photo;
	$MainData["contactno"] = $DWUserContact;
	$MainData["firstpage"] = $firstpage;
	$MainData["status"] = $status;
	$MainData["status_message"] = $status_message;
	
	echo json_encode($MainData);
	exit;
?>