<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/member_edit.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://810speedmart.com/".$_SERVER['REQUEST_URI']."\n".$req_dump);
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
	$DWMode = $_REQUEST["display_mode"];
	$DWUserContact = ReturnValidContact($_REQUEST["contactno"]);
	$DWUserIC = $_REQUEST["ic"];
	$DWUserName = strtoupper($_REQUEST["name"]);
	$DWUserEmail = strtolower($_REQUEST["email"]);

	$Sql_Update = "UPDATE data_customer SET nric = '".$DWUserIC."', name = '".$DWUserName."', email = '".$DWUserEmail."' WHERE tel = '".$DWUserContact."' AND active > 0 LIMIT 1";
	$Rst_Update = mysql_query($Sql_Update);

	if ( $DWUserContact != "" ) {
		$MainData["status"] = "1";
		$MainData["status_message"] = "Your info has been updated, thank you.";
	} else {
		$MainData["status"] = "0";
		$MainData["status_message"] = "Please login";
	}
	

	if ( $DWMode == "TEST" ) {
		echo "<pre>";
		print_r($MainData);
		echo "</pre>";
	}
	
	echo json_encode($MainData);
	exit;
?>