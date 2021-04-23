<?php
    include 'conf.php';
	
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/voucher_check_'.date("Y-m-d").'.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - https://810speedmart.com".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************

		Query Function & Print JSON Data
		810 Voucher Check QAPI
		- Only for normal voucher checking
		Sample URL: http://810speedmart.com/qapi/voucher_check.php?apikey-access=api810:lTL0FraU!QzSTM2^XN
		Sample Send to API
		{"voucher":[{"code":"NORJHAK71K1","id":"0163660905","type":""}]}
			- Testing Voucher NORJHAK71K1 ~ NORJHAK71K39 (total 39 Vouchers)
			- API Parameter: type: "REGISTER" / "RENEW" / ""

		Return Info
		- status - Info = 0: Error, 1: Success
		- status_message - Will display message once *status* = 0
		- id - ID Send from Qube

	****************************************************************** */
	$DWAPIKey = $_REQUEST["apikey-access"];
    //$_REQUEST["voucher"] = '[{"code":"REGJHAK71K6","id":"0163660905"}]';
	$DWVoucherData = json_decode($_REQUEST["voucher"]);
	
	if ( $DWAPIKey != "api810:lTL0FraU!QzSTM2^XN" ) {
		$ReturnData["status"] = 0;
		$ReturnData["status_message"] = "Wrong API Key";
		
		echo json_encode($ReturnData);
		exit;
	}
	
	if ( count($DWVoucherData) > 0 ) {
    	for ($i=0; $i<count($DWVoucherData); $i++) {

    		$DWCustID = 0;
    		unset($ResultData);
    		//
			// Check Customer is Valid to Redeem
			$DWUserContact = ReturnValidContact($DWVoucherData[$i]->id);
			if ( $DWUserContact != "" && $DWVoucherData[$i]->type != "REGISTER" && $DWVoucherData[$i]->type != "RENEW" ) {
				$SqlCust_Select = "SELECT * FROM data_customer WHERE sbclient_id = '".$DWUserContact."' ";
		    	$RstCust_Select = mysql_query($SqlCust_Select);
		    	if ( mysql_num_rows($RstCust_Select) > 0 ) {

		    		$DWCustID = mysql_result($RstCust_Select, 0, "id");
		    		$DWActive = mysql_result($RstCust_Select, 0, "active");

		    		if ( $DWActive == 2 ) {
		    			$ResultData["status"] = 0;
						$ResultData["status_message"] = "This customer is not 810 VIP, please ask customer to join as 810 VIP";
						$ResultData["id"] = $DWVoucherData[$i]->id;

						$ReturnData[] = $ResultData;
		    		} else if ( $DWVoucherData[$i]->type == "REGISTER" ) {
						//
						// Register Voucher
						$SqlCustVou_Select = "SELECT * FROM data_voucher WHERE customer_id = '".$DWCustID."' AND info_id = 2 ";
			    		$RstCustVou_Select = mysql_query($SqlCustVou_Select);
			    		if ( mysql_num_rows($RstCustVou_Select) > 0 ) {
							$ResultData["status"] = 0;
							$ResultData["status_message"] = "Sorry, this customer '".$DWUserContact."' has redeemed a voucher before.";
							$ResultData["id"] = $DWVoucherData[$i]->id;

							$ReturnData[] = $ResultData;
			    		}
			    	} else if ( $DWVoucherData[$i]->type == "RENEW" ) {

					} else {
						//
						// Only Check for Register / Renew Voucher
						$SqlVouType_Select = "SELECT v.* FROM `data_voucher` v WHERE v.voucher_code = '".$DWVoucherData[$i]->code."' AND v.info_id = 2 LIMIT 1 ";
						$RstVouType_Select = mysql_query($SqlVouType_Select);
			    		if ( mysql_num_rows($RstVouType_Select) > 0 ) {
			    			//
							// Register Voucher
							$SqlCustVou_Select = "SELECT * FROM data_voucher WHERE customer_id = '".$DWCustID."' AND info_id = 2 ";
				    		$RstCustVou_Select = mysql_query($SqlCustVou_Select);
				    		if ( mysql_num_rows($RstCustVou_Select) > 0 ) {
								$ResultData["status"] = 0;
								$ResultData["status_message"] = "Sorry, this customer '".$DWUserContact."' has redeemed a voucher before.";
								$ResultData["id"] = $DWVoucherData[$i]->id;

								$ReturnData[] = $ResultData;
				    		}
			    		}
						
					}

		        } else {
		        	//
		        	// If NOT Cust ID Found, it may from Register with Voucher Check Page
		        	// but it only for "REG" Voucher Code
		        	if ( substr($DWVoucherData[$i]->code, 0, 3) == "REG" ) {

		        	} else {
		        		if ( $DWVoucherData[$i]->type == "REGISTER" ) {
		        			//
		        			// Call from Register / Renewal Page, Ignore the Member ID Checking
		        		} else {
		        			$ResultData["status"] = 0;
							$ResultData["status_message"] = "Invalid Customer ID";
							$ResultData["id"] = $DWVoucherData[$i]->id;

							$ReturnData[] = $ResultData;
		        		}
		        	}
		        }
			} else if ( $DWVoucherData[$i]->type != "REGISTER" && $DWVoucherData[$i]->type != "RENEW" ) {
				$ResultData["status"] = 0;
				$ResultData["status_message"] = "No ID";
				$ResultData["id"] = $DWVoucherData[$i]->id;

				$ReturnData[] = $ResultData;
			}

			if ( count($ResultData) == 0 ) {
				if ( $DWVoucherData[$i]->code != "" ) {
					if ( $DWVoucherData[$i]->type == "REGISTER" || $DWVoucherData[$i]->type == "RENEW" ) {
						$SqlVou_Select = "SELECT v.voucher_code, i.info_validity_from, i.info_validity_to, i.info_value FROM `data_voucher` v INNER JOIN `data_voucher_info` i ON (i.id=v.info_id AND i.active=1) WHERE v.voucher_code = '".$DWVoucherData[$i]->code."' AND i.info_validity_from <= '".date("Y-m-d")."' AND i.info_validity_to >= '".date("Y-m-d")."' AND v.active = 3 LIMIT 1 ";
					} else {
						$SqlVou_Select = "SELECT v.voucher_code, i.info_validity_from, i.info_validity_to, i.info_value FROM `data_voucher` v INNER JOIN `data_voucher_info` i ON (i.id=v.info_id AND i.active=1) WHERE v.voucher_code = '".$DWVoucherData[$i]->code."' AND i.info_validity_from <= '".date("Y-m-d")."' AND i.info_validity_to >= '".date("Y-m-d")."' AND v.active = 1 LIMIT 1 ";
					}
					//$SqlVou_Select = "SELECT v.voucher_code, i.info_validity_from, i.info_validity_to, i.info_value FROM `data_voucher` v INNER JOIN `data_voucher_info` i ON (i.id=v.info_id AND i.active=1) WHERE v.voucher_code = '".$DWVoucherData[$i]->code."' AND i.info_validity_from <= '".date("Y-m-d")."' AND i.info_validity_to >= '".date("Y-m-d")."' AND v.active = 1 LIMIT 1 ";
			    	$RstVou_Select = mysql_query($SqlVou_Select);
			    	if ( mysql_num_rows($RstVou_Select) > 0 ) {
			            while ( $RowData = mysql_fetch_assoc($RstVou_Select) ) {
			            	$ResultData = $RowData;
			            	$ResultData["status"] = 1;
							$ResultData["status_message"] = "Voucher Valid";
							$ResultData["id"] = $DWVoucherData[$i]->id;

							$ReturnData[] = $ResultData;
			            }
			        } else {
						$ResultData["status"] = 0;
						$ResultData["status_message"] = "Invalid Voucher Code / Voucher Code has been activated before.";
						$ResultData["id"] = $DWVoucherData[$i]->id;

						$ReturnData[] = $ResultData;
			        }
				} else {
					$ResultData["status"] = 0;
					$ResultData["status_message"] = "No Voucher Code";
					$ResultData["id"] = $DWVoucherData[$i]->id;

					$ReturnData[] = $ResultData;
				}
			}

    	}
    }




	
	
	echo json_encode($ReturnData);
	exit;

?>