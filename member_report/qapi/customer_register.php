<?php
    include 'conf.php';
	
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/customer_register_new_'.date("Y-m-d").'.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - https://810speedmart.com".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************

		Query Function & Print JSON Data
		810 Customer Register QAPI
		Sample URL: http://810speedmart.com/qapi/customer_register.php?apikey-access=api810:lTL0FraU!QzSTM2^XN
		Sample Send to API
		{"registration":[{"id":"0163660905","name":"WAI LUN","tel":"0163621446","email":"wailun.chan@163.com","addr1":"No.122, BLOCK A","addr2":"PJ CITY (INTAN)","addr3":"46100, PETALING JAYA","addr4":"","birthday":"1/13/1986","nric":"","created":"04/10/2019","expired":"04/10/2020","extend_year":"1","vouchercode":"TESTCODE1"}]}

		Return Info
		- status - Info = 0: Error, 1: Success
		- status_message - Will display message once *status* = 0
		- id - ID Send from Qube

	****************************************************************** */
	$DWAPIKey = $_REQUEST["apikey-access"];
	//$_REQUEST["registration"] = '[{"id":"0163621446","name":"WAI LUN","tel":"0163621446","email":"wailun.chan@163.com","addr1":"No.122, BLOCK A","addr2":"PJ CITY (INTAN)","addr3":"46100, PETALING JAYA","addr4":"","birthday":"1/13/1986","nric":"","created":"04/10/2019","expired":"04/10/2020"},{"id":"0193682999","name":"JONATHAN NG","tel":"0193682999","email":"jonathan@yahoo.com","addr1":"27, JALAN 8/3A","addr2":"DAMANSARA JAYA","addr3":"47700, PETALING JAYA","addr4":"","birthday":"12/25/1980","nric":"","created":"05/10/2019","expired":"05/10/2020"},{"id":"0123536669","name":"MOHD REZA B EMBI","tel":"0123536669","email":"mohd.reza@gmail.com","addr1":"2-1, PLAZA RIVERWALK","addr2":"JALAN SELVADURAI","addr3":"OFF JALAN KUCHING","addr4":"51100, KUALA LUMPUR","birthday":"03/09/1990","nric":"","created":"03/10/2019","expired":"03/10/2020","vouchercode":"TESTCODE1"}]';
	$DWRegisterData = json_decode($_REQUEST["registration"]);
	
	if ( $DWAPIKey != "api810:lTL0FraU!QzSTM2^XN" ) {
		$ReturnData["status"] = 0;
		$ReturnData["status_message"] = "Wrong API Key";
		
		echo json_encode($ReturnData);
		exit;
	}

	function izrand($length = 8, $numeric = false) {
	    $random_string = "";
	    while(strlen($random_string)<$length && $length > 0) {
	        if($numeric === false) {
	            $randnum = mt_rand(0,61);
	            $random_string .= ($randnum < 10) ?
	                chr($randnum+48) : ($randnum < 36 ? 
	                    chr($randnum+55) : chr($randnum+61));
	        } else {
	            $randnum = mt_rand(0,9);
	            $random_string .= chr($randnum+48);
	        }
	    }
	    return $random_string;
	}

	function getRandVoucher($VoucherCode="") {
		if ($VoucherCode == "") {
			$VoucherCode = strtoupper(izrand());
		}
		$VoucherCode = "*".$VoucherCode."*";
		$SqlVou_Select = "SELECT * FROM data_voucher WHERE voucher_code = '".$VoucherCode."' LIMIT 1 ";
		$RstVou_Select = mysql_query($SqlVou_Select);
		if (mysql_num_rows($RstVou_Select) > 0) {
			$VoucherCode = getRandVoucher();
		}

		return $VoucherCode;
	}
	
	/*
	{"registration":[
	{"id":"0163621446","name":"WAI LUN","tel":"0163621446","email":"wailun.chan@163.com","addr1":"No.122, BLOCK A","addr2":"PJ CITY (INTAN)","addr3":"46100, PETALING JAYA","addr4":"","birthday":"1/13/1986","nric":"","created":"04/10/2019","expired":"04/10/2020"},
    {"id":"0193682999","name":"JONATHAN NG","tel":"0193682999","email":"jonathan@yahoo.com","addr1":"27, JALAN 8/3A","addr2":"DAMANSARA JAYA","addr3":"47700, PETALING JAYA","addr4":"","birthday":"12/25/1980","nric":"","created":"05/10/2019","expired":"05/10/2020"},
    {"id":"0123536669","name":"MOHD REZA B EMBI","tel":"0123536669","email":"mohd.reza@gmail.com","addr1":"2-1, PLAZA RIVERWALK","addr2":"JALAN SELVADURAI","addr3":"OFF JALAN KUCHING","addr4":"51100, KUALA LUMPUR","birthday":"03/09/1990","nric":"","created":"03/10/2019","expired":"03/10/2020"}
    ]}
    */
    //echo count($DWRegisterData);
    
	
	if ( count($DWRegisterData) > 0 ) {
    	for ($i=0; $i<count($DWRegisterData); $i++) {
    		$DWUserContact = ReturnValidContact($DWRegisterData[$i]->id);
    		if ( empty($DWRegisterData[$i]->extend_year) || $DWRegisterData[$i]->extend_year == 0 ) {
				$APIData["status"] = 0;
				$APIData["status_message"] = "No Extend Year Selection";
				$APIData["id"] = $DWRegisterData[$i]->id;
				
				$ReturnData[] = $APIData;
			} else {

	    	    if ( !empty($DWRegisterData[$i]->id) ) {
	        	    $SqlCust_Select = "SELECT * FROM `data_customer` WHERE sbclient_id = '".$DWUserContact."' ";
	        	    $RstCust_Select = mysql_query($SqlCust_Select);
	        	    if ( mysql_num_rows($RstCust_Select) > 0 ) {

	        	    	/*
	        	    	*
							Need Check how to renew data
							?
							?
							?
							?
							?
							? Need Check if Existing how ?
							?
							?
							?
							?
							?
							?
							Suppose in sales_transaction.php
	        	    	*
	        	    	*/
	        	    	$DWExpired = mysql_result($RstCust_Select, 0, "expired");
	        	    	/*
	        	    	if ( $DWExpired >= date("Y-m-d") ) {
	        	    		$DWExpired = date("Y-m-d", strtotime($DWExpired . " + ".$DWRegisterData[$i]->extend_year." year"));
	        	    	} else {
	        	    		$DWExpired = date("Y-m-d", strtotime(date("Y-m-d") . " + ".$DWRegisterData[$i]->extend_year." year"));
	        	    	}
	        	    	*/

	        	    	$DWExtraQuery = "";
	        	    	if ( !empty($DWRegisterData[$i]->email) ) {
	        	    		$DWExtraQuery = " , email = '".$DWRegisterData[$i]->email."' ";
	        	    	}

	        	        $SqlCust_Update = "UPDATE `data_customer` SET name = '".$DWRegisterData[$i]->name."' ".$DWExtraQuery." , addr1 = '".$DWRegisterData[$i]->addr1."', addr2 = '".$DWRegisterData[$i]->addr2."', addr3 = '".$DWRegisterData[$i]->addr3."', addr4 = '".$DWRegisterData[$i]->addr4."', birthday = '".date("Y-m-d", strtotime($DWRegisterData[$i]->birthday))."', nric = '".$DWRegisterData[$i]->nric."', gender = '".$DWRegisterData[$i]->gender."', race = '".$DWRegisterData[$i]->race."', expired = '".date("Y-m-d", strtotime(date("Y-m-d") . " + ".$DWRegisterData[$i]->extend_year." year"))."', vouchercode = '".$DWRegisterData[$i]->vouchercode."', updated = NOW() WHERE sbclient_id = '".$DWUserContact."' ";
	        	        $RstCust_Update = mysql_query($SqlCust_Update);
	        	        
	        	        $APIData["status"] = 1;
	            		$APIData["status_message"] = "Done Update";
	            		$APIData["id"] = $DWRegisterData[$i]->id;
	            		
	            		$ReturnData[] = $APIData;
	        	    } else {
	        	    	//
	        	    	// 2020-05-19 : direct insert info as 'member' account
	        	    	//date("Y-m-d", strtotime(date("Y-m-d", strtotime($StaringDate)) . " + 1 year"));
	        	        $SqlCust_Insert = "INSERT INTO `data_customer` (sbclient_id, name, tel, email, addr1, addr2, addr3, addr4, birthday, nric, gender, race, expired, vouchercode, updated, created, active) VALUES ('".$DWUserContact."', '".$DWRegisterData[$i]->name."', '".$DWUserContact."', '".$DWRegisterData[$i]->email."', '".$DWRegisterData[$i]->addr1."', '".$DWRegisterData[$i]->addr2."', '".$DWRegisterData[$i]->addr3."', '".$DWRegisterData[$i]->addr4."', '".date("Y-m-d", strtotime($DWRegisterData[$i]->birthday))."', '".$DWRegisterData[$i]->nric."', '".$DWRegisterData[$i]->gender."', '".$DWRegisterData[$i]->race."', '".date("Y-m-d", strtotime(date("Y-m-d") . " + ".$DWRegisterData[$i]->extend_year." year"))."', '".$DWRegisterData[$i]->vouchercode."', NOW(), NOW(), 1) ";
	        	        $RstCust_Insert = mysql_query($SqlCust_Insert);
	        	        $DWCustID = mysql_insert_id();

	        	        //
	        	        // 2020-05-19 : insert RM5 Voucher in 'Member' Customer Account
	        	        $DWVoucherCode = getRandVoucher();
						$SqlVou_Insert = "INSERT INTO data_voucher (event_id, info_id, customer_id, voucher_code, updated, created, active) VALUES ('4', '4', '".$DWCustID."', '".$DWVoucherCode."', NOW(), NOW(), 1)  ";
						$RstVou_Insert = mysql_query($SqlVou_Insert);
	        	        
	        	        $APIData["status"] = 1;
	            		$APIData["status_message"] = "Done Insert";
	            		$APIData["id"] = $DWRegisterData[$i]->id;
	            		
	            		$ReturnData[] = $APIData;
	        	    }
	        	} else {
	        	    $APIData["status"] = 0;
	        		$APIData["status_message"] = "Error ID";
	        		$APIData["id"] = $DWRegisterData[$i]->id;
	        		
	        		$ReturnData[] = $APIData;
	        	}

        	}
    	}
	} else {
	    $APIData["status"] = 0;
		$APIData["status_message"] = "Not Data Pass";
		$APIData["id"] = $DWRegisterData[$i]->id;
		
		$ReturnData[] = $APIData;
	}
	
	

	
	
	echo json_encode($ReturnData);
	exit;

?>