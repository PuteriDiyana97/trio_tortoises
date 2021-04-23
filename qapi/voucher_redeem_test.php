<?php
    include 'conf.php';
	
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/voucher_redeem_'.date("Y-m-d").'.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - https://810speedmart.com".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************

		Query Function & Print JSON Data
		810 Voucher Redeem QAPI
		Sample URL: http://810speedmart.com/qapi/voucher_redeem.php?apikey-access=api810:lTL0FraU!QzSTM2^XN
		Sample Send to API
		{"voucher":[{"code":"REGJHAK71K","id":"0163660905","value":"20","trxdate":"3/12/2019","trxnum":"ZJ29-T1-0000001236"}]}

		Return Info
		- status - Info = 0: Error, 1: Success
		- status_message - Will display message once *status* = 0

	****************************************************************** */
	$DWAPIKey = $_REQUEST["apikey-access"];
    //$_REQUEST["voucher"] = '[{"code":"REGJHAK71K1","id":"0163660905","value":"20","trxdate":"3/12/2019","trxnum":"ZJ29-T1-0000001236"}]';
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
    		//
			// Check Customer is Valid to Redeem
			$DWUserContact = ReturnValidContact($DWVoucherData[$i]->id);
			if ( $DWUserContact != "" ) {
				$SqlCust_Select = "SELECT * FROM data_customer WHERE sbclient_id = '".$DWUserContact."' ";
		    	$RstCust_Select = mysql_query($SqlCust_Select);
		    	if ( mysql_num_rows($RstCust_Select) > 0 ) {

		    		$DWCustID = mysql_result($RstCust_Select, 0, "id");

		        } else {
		        	$ResultData["status"] = 0;
					$ResultData["status_message"] = "Invalid Customer ID";
					$ResultData["id"] = $DWVoucherData[$i]->id;

					$ReturnData[] = $ResultData;
		        }
			} else {
				$ResultData["status"] = 0;
				$ResultData["status_message"] = "No ID";
				$ResultData["id"] = $DWVoucherData[$i]->id;

				$ReturnData[] = $ResultData;
			}

			if ( $DWCustID > 0 ) {
				//
				// Alfred - Same voucher got * some no , need hardcode check and add
				if ( substr($DWVoucherData[$i]->code, 0, 1) != "*" ) $DWVoucherData[$i]->code = "*".$DWVoucherData[$i]->code."*";
				
				if ( $DWVoucherData[$i]->code != "" ) {
					//echo "<br />".
					$SqlVou_Select = "SELECT v.id, v.voucher_code, v.customer_id, i.info_validity_from, i.info_validity_to, i.info_value FROM `data_voucher` v INNER JOIN `data_voucher_info` i ON (i.id=v.info_id AND i.active=1) WHERE v.voucher_code = '".$DWVoucherData[$i]->code."' ";
			    	$RstVou_Select = mysql_query($SqlVou_Select);
			    	if ( mysql_num_rows($RstVou_Select) > 0 ) {

			    		echo "---".$DWVouID = mysql_result($RstVou_Select, 0, "id");
			    		echo "---".$DWCustID = mysql_result($RstVou_Select, 0, "customer_id");


	        	        /*
	        	        //
	        	        // Select Previous Sales Record out
	        	        $DWTotalSales = 0;
	        	        $DWDeductPoint = 0;
	        	        $SqlSalesRec_Select = "SELECT * FROM `data_sales_transaction` WHERE trxnum = '".$DWVoucherData[$i]->trxnum."' AND active = 1 ";
	        	        $RstSalesRec_Select = mysql_query($SqlSalesRec_Select);
	        	        while ( $SalesRecord = mysql_fetch_assoc($RstSalesRec_Select) ) {
	        	        	$DWTotalSales += $SalesRecord["trxtotal"];
	        	        }
	        	        if ( $DWTotalSales > $DWVoucherData[$i]->value ) {
	        	        	$DWDeductPoint = round($DWVoucherData[$i]->value);
	        	        } else {
	        	        	$DWDeductPoint = round($DWTotalSales);
	        	        }
	        	        */

	        	        /*
	                    *
	                        We Need Add / Deduct Point in Customer Record
	                        Check Valid / Before Expiry Member

	                        Deduct Point based on the TNC
	                        if Sales Value > voucher value , 
	                        	then deduct voucher value in Point
	                        else
	                        	then deduct Sales Value in Point
	                    *
	                    */
	                    /*if ( $DWDeductPoint > 0 ) {
	                    	$DWExQuery = " point = point - ".$DWDeductPoint." ";
		                    $SqlCustPoint_Update = "UPDATE `data_customer` SET ".$DWExQuery." WHERE sbclient_id = '".$DWVoucherData[$i]->id."' AND active = 1 AND expired >= '".date("Y-m-d")."' ";
		                    $RstCustPoint_Update = mysql_query($SqlCustPoint_Update);

		                    $SqlSalesRec_Update = "UPDATE `data_sales_transaction` SET adjustment = 1 WHERE id = '".$DWSalesTranID."' ";
	        	        	$RstSalesRec_Update = mysql_query($SqlSalesRec_Update);
	                    }*/
	                    


			            $ResultData["status"] = 1;
						$ResultData["status_message"] = "Done Updated";
						$ResultData["id"] = $DWVoucherData[$i]->id;

						$ReturnData[] = $ResultData;
			        } else {
						$ResultData["status"] = 0;
						$ResultData["status_message"] = "Invalid Voucher Code";
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

    /*
	//
	// Default Value
	$ReturnData["status"] = 2;
	$ReturnData["status_message"] = "Unknown Error!";

	//
	// Check Customer is Valid to Redeem
	$DWUserContact = ReturnValidContact($DWVoucherData->id);
	if ( $DWUserContact != "" ) {
		$SqlCust_Select = "SELECT * FROM data_customer WHERE sbclient_id = '".$DWUserContact."' ";
    	$RstCust_Select = mysql_query($SqlCust_Select);
    	if ( mysql_num_rows($RstCust_Select) > 0 ) {

    		$DWCustID = mysql_result($RstCust_Select, 0, "id");

        } else {
        	$ReturnData["status"] = 0;
			$ReturnData["status_message"] = "Invalid Customer ID";
        }
	} else {
		$ReturnData["status"] = 0;
		$ReturnData["status_message"] = "No ID";
	}
	
	if ( $ReturnData["status"] == 2 ) {
		if ( $DWVoucherData->code != "" ) {
			$SqlVou_Select = "SELECT v.id, v.voucher_code, i.info_validity_from, i.info_validity_to, i.info_value FROM `data_voucher` v INNER JOIN `data_voucher_info` i ON (i.id=v.info_id AND i.active=1) WHERE v.voucher_code = '".$DWVoucherData->code."' AND v.active = 1 ";
	    	$RstVou_Select = mysql_query($SqlVou_Select);
	    	if ( mysql_num_rows($RstVou_Select) > 0 ) {

	    		$DWVouID = mysql_result($RstVou_Select, 0, "id");

	    		$SqlCust_Update = "UPDATE data_voucher SET customer_id = '".$DWCustID."', active = 2, trxvalue = '".$DWVoucherData->value."', trxdate = '".$DWVoucherData->trxdate."', trxnum = '".$DWVoucherData->trxnum."' WHERE id = '".$DWVouID."' ";
    			$RstCust_Update = mysql_query($SqlCust_Update);

    			$ReturnData["status"] = 1;
	            $ReturnData["status_message"] = "Done Updated";

	        } else {
	        	$ReturnData["status"] = 0;
				$ReturnData["status_message"] = "Invalid Voucher Code";
	        }
		} else {
			$ReturnData["status"] = 0;
			$ReturnData["status_message"] = "No Voucher Code";
		}
	}
	*/
	
	echo json_encode($ReturnData);
	exit;

?>