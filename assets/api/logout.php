<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/logout.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://810speedmart.com".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************

		Query Function & Print JSON Data
		810 Login / Activate API
		Sample URL: http://810speedmart.com/api/logout.php?contactno=[CONTACTNO]&uuid=[UUID]

	****************************************************************** */
	$DWUserContact = ReturnValidContact($_REQUEST["contactno"]);
	$DWUUID = $_REQUEST["uuid"];
	
	//
	// Update base on Device ID
	$Sql_Update = "UPDATE data_apps_info SET customer_id = 0 WHERE uuid = '".$DWUUID."' AND uuid <> ''";
	$Rst_Update = mysql_query($Sql_Update);

	//
	// Update base on Customer ID
	/*
	$SqlCust_Select = "SELECT d.* FROM data_customer d WHERE d.active > 0 AND d.tel = '".$DWUserContact."' LIMIT 1";
	$RstCust_Select = mysql_query($SqlCust_Select);
	if (mysql_num_rows($RstCust_Select) > 0) {
		$DWID = mysql_result($RstCust_Select, 0, "id");

		$Sql_Update = "UPDATE data_apps_info SET customer_id = 0 WHERE customer_id = '".$DWID."' AND customer_id > 0";
		$Rst_Update = mysql_query($Sql_Update);
	}
	*/
	
	$MainData["status"] = "1";
	$MainData["status_message"] = "";
	
	
	echo json_encode($MainData);
	exit;
?>