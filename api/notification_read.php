<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/notification_read.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://stargloryasia.com/".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************

		Query Function & Print JSON Data
		810 Notification - Read API
		Sample URL: http://810speedmart.com/api/notification_read.php?id=[Notification ID]

		Return Info


	****************************************************************** */
	// $DWMode = $_REQUEST["display_mode"];
	$DWUserContact = ReturnValidContact($_REQUEST["contactno"]);
	$DWNotificationID = $_REQUEST["id"];
	
	$con = getdb();
	$Sql_Update = "UPDATE notification_receiver SET notification_read = 1 WHERE id = '".$DWNotificationID."' AND contact_no = '".$DWUserContact."'";
	$Rst_Update = mysqli_query($con,$Sql_Update);

?>