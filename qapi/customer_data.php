<?php
    include 'conf.php';
	
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/customer_data_'.date("Y-m-d").'.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - https://810speedmart.com".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************

		Query Function & Print JSON Data
		810 Customer Data QAPI
		Sample URL: http://810speedmart.com/qapi/customer_data.php?apikey-access=api810:lTL0FraU!QzSTM2^XN&customer=[{"id":"0163621446"},{"id":"0163660905"}]
		Sample Send to API
		{"customer":[{"id":"0163621446"},{"id":"0163660905"}]}

		Return Info
		- status - Info = 0: Error, 1: Success
		- status_message - Will display message once *status* = 0
		- Customer Info
			- active: 1 = Paid Member, 2: Unpaid Member
			- Birthday
			- Expiry Date
			- Point
			- ID
			- Address 1, Address 2, Address 3, Address 4
			- Tel
			- Name

	****************************************************************** */
	$DWAPIKey = $_REQUEST["apikey-access"];
    //$_REQUEST["customer"] = '[{"id":"0163621446"},{"id":"0163660905"}]';
	$DWCustomerData = json_decode($_REQUEST["customer"]);
	
	if ( $DWAPIKey != "api810:lTL0FraU!QzSTM2^XN" ) {
		$ReturnData["status"] = 0;
		$ReturnData["status_message"] = "Wrong API Key";
		
		echo json_encode($ReturnData);
		exit;
	}
	
	if ( count($DWCustomerData) > 0 ) {
    	for ($i=0; $i<count($DWCustomerData); $i++) {
    		//
    		// Only pass Paid Member Data to Qube , Free Member not pass
    	    $SqlCust_Select = "SELECT * FROM `data_customer` WHERE sbclient_id = '".$DWCustomerData[$i]->id."' AND active <> 0 ";
            $RstCust_Select = mysql_query($SqlCust_Select);
            if ( mysql_num_rows($RstCust_Select) > 0 ) {
                while ( $RowData = mysql_fetch_assoc($RstCust_Select) ) {
                    $RowData["id"] = $RowData["sbclient_id"];
                    $RowData["birthday"] = date("m/d/Y", strtotime($RowData["birthday"]));
                    if ( $RowData["active"] == 2 ) {
                    	//
                    	// Free Member NO Expire Date
                    	$RowData["expired"] = date("m/d/Y", strtotime("+1 years"));
                    } else {
                    	$RowData["expired"] = date("m/d/Y", strtotime($RowData["expired"]));
                    }
                    
                    $RowData["created"] = date("m/d/Y", strtotime($RowData["created"]));
                    $RowData["point"] = $RowData["point"];
                    //
                    // 0: Invalid Member , 1: Paid Member , 2: Unpaid Member
                    $RowData["active"] = $RowData["active"];
                    //
                    //
                    $RowData["active_message"] = "This member is not activated yet, please proceed with member fee payment. Thank you.";

                    $RowData["status"] = 1;
            		$RowData["status_message"] = "Request done";
            		$RowData["pricelevel"] = DWPriceLevel($RowData["pricelevel"]);
            		
            		$ReturnData[] = $RowData;
                }
            } else {
                $APIData["status"] = 0;
        		$APIData["status_message"] = "Error ID";
        		$APIData["id"] = $DWCustomerData[$i]->id;
        		
        		$ReturnData[] = $APIData;
            }
    	}
	}
	
	echo json_encode($ReturnData);
	exit;

?>