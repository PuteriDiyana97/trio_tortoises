<?php
    include 'conf.php';
	
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/voucher_check_register.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - https://810speedmart.com/qapi".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************

		Query Function & Print JSON Data
		810 Voucher Check for Register QAPI
		- Only for register voucher checking
		- info_id = 2 = Register Member Voucher ID
		Sample URL: http://810speedmart.com/qapi/voucher_check_register.php?apikey-access=api810:lTL0FraU!QzSTM2^XN&voucher={"code":"REGJHAK71K1","id":"0163660905"}
			- Testing Voucher REGJHAK71K1 ~ REGJHAK71K39 (total 39 Vouchers)

		Return Info
		- status - Info = 0: Error, 1: Success
		- status_message - Will display message once *status* = 0

	****************************************************************** */
	$DWAPIKey = $_REQUEST["apikey-access"];
    //$_REQUEST["voucher"] = '{"code":"YIJAKJDW","id":"0163621446"}';
	$DWVoucherData = json_decode($_REQUEST["voucher"]);
	
	if ( $DWAPIKey != "api810:lTL0FraU!QzSTM2^XN" ) {
		$ReturnData["status"] = 0;
		$ReturnData["status_message"] = "Wrong API Key";
		
		echo json_encode($ReturnData);
		exit;
	}

	//
	// Default Value
	$ReturnData["status"] = 2;
	$ReturnData["status_message"] = "Unknown Error!";

	
	//
	// Check Customer is Qua to Redeem
	$DWUserContact = ReturnValidContact($DWVoucherData->id);
	if ( $DWUserContact != "" ) {
		$SqlCust_Select = "SELECT * FROM data_customer WHERE sbclient_id = '".$DWUserContact."' ";
    	$RstCust_Select = mysql_query($SqlCust_Select);
    	if ( mysql_num_rows($RstCust_Select) > 0 ) {

    		$DWCustID = mysql_result($RstCust_Select, 0, "id");
            
            $SqlCustVou_Select = "SELECT * FROM data_voucher WHERE customer_id = '".$DWCustID."' AND info_id = 2 ";
    		$RstCustVou_Select = mysql_query($SqlCustVou_Select);
    		if ( mysql_num_rows($RstCustVou_Select) > 0 ) {
    			$ReturnData["status"] = 0;
				$ReturnData["status_message"] = "Sorry, Customer '".$DWUserContact."' has been redeemed Register Voucher before.";
    		}

        } else {
        	$ReturnData["status"] = 0;
			$ReturnData["status_message"] = "Invalid Customer ID";
        }
	} else {
		$ReturnData["status"] = 0;
		$ReturnData["status_message"] = "No ID";
	}

	
	if ( $ReturnData["status"] != 0 ) {
		//
		// Alfred - Same voucher got * some no , need hardcode check and add
		if ( substr($DWVoucherData->code, 0, 1) != "*" ) $DWVoucherData->code = "*".$DWVoucherData->code."*";
				
		//
		// Check Voucher Code Valid ?
		if ( $DWVoucherData->code != "" ) {
			$SqlVou_Select = "SELECT v.voucher_code, i.info_validity_from, i.info_validity_to, i.info_value FROM `data_voucher` v INNER JOIN `data_voucher_info` i ON (i.id=v.info_id AND i.active=1) WHERE v.voucher_code = '".$DWVoucherData->code."' AND v.active = 1 ";
	    	$RstVou_Select = mysql_query($SqlVou_Select);
	    	if ( mysql_num_rows($RstVou_Select) > 0 ) {
	            while ( $RowData = mysql_fetch_assoc($RstVou_Select) ) {
	            	$ReturnData["status"] = 1;
	            	$ReturnData["status_message"] = "Voucher Valid";

	            	$ReturnData[] = $RowData;
	            }
	        } else {
	        	$ReturnData["status"] = 0;
				$ReturnData["status_message"] = "Invalid Voucher Code";
	        }
		} else {
			$ReturnData["status"] = 0;
			$ReturnData["status_message"] = "No Voucher Code";
		}
	}
	
	
	echo json_encode($ReturnData);
	exit;

?>