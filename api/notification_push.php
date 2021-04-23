<?php


// $DWEVENT = "Testing";
// $DWTITLE = "Title";
// $DWBODY = "Notification Body";

// $DWPLAYERID = "555df5b6-df94-48ea-8db5-1c7f91909160";
// 		$data = array(
// 	        "event"=>$DWEVENT,
// 	        "title"=>($DWTITLE),
// 	        "body"=>($DWBODY),
// 		);
		
// 		echo "<pre>";
// 		print_r($data);
// 		echo "</pre>";
			
// 		$content = array("en" => rawurldecode($DWBODY));
// 	    $title = array("en" => rawurldecode($DWTITLE));
	    
// 	    $fields = array(
// 	        'app_id' => "9e324027-ee9e-439f-a524-11f1adc70b1a",
// 	        'include_player_ids' => array($DWPLAYERID),
// 	        'data' => $data,
// 	        'headings' => $title,
// 	        'contents' => $content,
// 	        'small_icon' => 'mipmap/icon',
// 	        'priority' => 10
// 	    );
	    
// 	    $fields = json_encode($fields);

// 	    $ch = curl_init();
// 	    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
// 	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
// 	                                               'Authorization: Basic NDQ4MzQzNjQtYzJlZC00NzM0LWE5NDYtY2QwMzk1MTBmY2Zl'));
// 	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
// 	    curl_setopt($ch, CURLOPT_HEADER, FALSE);
// 	    curl_setopt($ch, CURLOPT_POST, TRUE);
// 	    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
// 	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

// 	    echo "<br />response: ".
// 		$response = curl_exec($ch);
// 		curl_close($ch);
		

// 		exit;

    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */

	$req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/notification_push.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://stargloryasia.com".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************

		Query Function & Print JSON Data
		810 Push Notification Info (Auto)
		Sample URL: http://810speedmart.com/api/apps_push_notification_2.php?contactno=[CONTACTNO or '' (EMPTY)]&uuid=[UUID]&regid=[REG ID]

		Return Info
		Ignore It

	****************************************************************** */

	$con = getdb();

	// onesignal ID : 9e324027-ee9e-439f-a524-11f1adc70b1a
	// sender ID : 786732968203
	
	function push_notice($DWEVENT, $DWTITLE, $DWBODY, $DWPLAYERID) {
		// $DWPLAYERID = "555df5b6-df94-48ea-8db5-1c7f91909160";
		$data = array(
	        "event"=>$DWEVENT,
	        "title"=>($DWTITLE),
	        "body"=>($DWBODY),
		);
		
		echo "<pre>";
		print_r($data);
		echo "</pre>";
			
		$content = array("en" => rawurldecode($DWBODY));
	    $title = array("en" => rawurldecode($DWTITLE));
	    
	    $fields = array(
	        'app_id' => "9e324027-ee9e-439f-a524-11f1adc70b1a",
	        'include_player_ids' => array($DWPLAYERID),
	        'data' => $data,
	        'headings' => $title,
	        'contents' => $content,
	        'small_icon' => 'mipmap/icon',
	        'priority' => 10
	    );
	    
	    $fields = json_encode($fields);
		
		// $ch = curl_init();
	    // curl_setopt($ch, CURLOPT_URL, "https://senheng.com.my");

	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
	                                               'Authorization: Basic NDQ4MzQzNjQtYzJlZC00NzM0LWE5NDYtY2QwMzk1MTBmY2Zl'));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		// curl_setopt($ch, CURLOPT_PORT, 443);
	    curl_setopt($ch, CURLOPT_POST, TRUE);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

	    echo "<br />response: ".
		$response = curl_exec($ch);
	    curl_close($ch);
	}

	$con = getdb();
	mysqli_set_charset($con, "utf8");
	$DWCount = 0;
	echo "<br />Select Cust: ".
	$SqlCust_Select = "SELECT d.*, d.id as receive_id, i.userid FROM notification_receiver d INNER JOIN data_customer c ON (c.contact_no=d.contact_no) INNER JOIN data_apps_info i ON (i.contact_no=c.contact_no) WHERE d.push_notification = 0 and DATE(d.start_date) = '".date("Y-m-d")."' and c.active = '1' ORDER BY d.contact_no LIMIT 1000";
	$RstCust_Select = mysqli_query($con,$SqlCust_Select);
	while ( $RowData = mysqli_fetch_assoc($RstCust_Select) ) {

		echo "<br />UserID: ".$RowData["userid"];
		push_notice("NOTIFICATION", urldecode($RowData["notification_title"]), urldecode($RowData["short_description"]), $RowData["userid"]);

		echo "<br />Update Cust: ".($DWCount++).": ".
		$SqlCust_Update = "UPDATE notification_receiver SET push_notification = 1 WHERE id = '".$RowData["receive_id"]."' ";
		$RstCust_Update = mysqli_query($con,$SqlCust_Update);
	}


?>