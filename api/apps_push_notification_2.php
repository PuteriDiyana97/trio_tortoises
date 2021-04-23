<?php
    //include '/home/speedmart/public_html/api/conf.php';
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    /*$req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('/home/speedmart/public_html/api/logs/apps_push_notification_2.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://810speedmart.com/".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);*/
	
	
	/* ******************************************************************

		Query Function & Print JSON Data
		810 Push Notification Info (Auto)
		Sample URL: http://810speedmart.com/api/apps_push_notification_2.php?contactno=[CONTACTNO or '' (EMPTY)]&uuid=[UUID]&regid=[REG ID]

		Return Info
		Ignore It

	****************************************************************** */

	function push_notice($DWEVENT, $DWTITLE, $DWBODY, $DWPLAYERID) {
		//$DWPLAYERID = "ceb672fd-e8f7-40c2-9ac1-ea47224e006c";
		$data = array(
	        "event"=>$DWEVENT,
	        "title"=>($DWTITLE),
	        "body"=>($DWBODY),
	    );
			
		$content = array("en" => rawurldecode($DWBODY));
	    $title = array("en" => rawurldecode($DWTITLE));
	    
	    $fields = array(
	        'app_id' => "b53b1276-0a21-4292-bafd-4ed0a62ab423",
	        'include_player_ids' => array($DWPLAYERID),
	        'data' => $data,
	        'headings' => $title,
	        'contents' => $content,
	        'small_icon' => 'mipmap/icon',
	        'priority' => 10
	    );
	    
	    $fields = json_encode($fields);
	    
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
	                                               'Authorization: Basic YTkyYjY1MjItNTgzZC00YjgzLWEzMWEtMGEwNjVjMThmNjI5'));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	    curl_setopt($ch, CURLOPT_HEADER, FALSE);
	    curl_setopt($ch, CURLOPT_POST, TRUE);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15); 
	    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

	    echo "<br />response: ".
		$response = curl_exec($ch);
	    curl_close($ch);
	}

	$DWCount = 0;
	echo "<br />Select Cust: ".
	$SqlCust_Select = "SELECT d.*, i.userid FROM data_notification d INNER JOIN data_customer c ON (c.id=d.customer_id) INNER JOIN data_apps_info i ON (i.customer_id=c.id) WHERE d.push_notification = 0 ORDER BY d.id LIMIT 1000";
	$RstCust_Select = mysql_query($SqlCust_Select);
	while ( $RowData = mysql_fetch_assoc($RstCust_Select) ) {

		echo "<br />UserID: ".$RowData["userid"];
		push_notice("NOTIFICATION", urldecode($RowData["popup_title"]), urldecode($RowData["popup_message"]), $RowData["userid"]);

		echo "<br />Update Cust: ".($DWCount++).": ".
		$SqlCust_Update = "UPDATE data_notification SET push_notification = 1 WHERE id = '".$RowData["id"]."' ";
		$RstCust_Update = mysql_query($SqlCust_Update);
	}


?>