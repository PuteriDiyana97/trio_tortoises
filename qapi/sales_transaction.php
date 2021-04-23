<?php
    include 'conf.php';
	
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/sales_transaction_'.date("Y-m-d").'.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - https://810speedmart.com".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************

		Query Function & Print JSON Data
		810 Sales Transaction QAPI
		Sample URL: https://810speedmart.com/qapi/sales_transaction.php?apikey-access=api810:lTL0FraU!QzSTM2^XN
        Sample Send to API
        - Sales
        {"sales":[{"id":"0163621446","trxdate":"3/12/2019","trxnum":"THQ-T1-0000000133","trxtotal":"129.9"}]}
        - Redeem
        {"Redeem":[{"id":"0163621446","trxdate":"3/12/2019","trxnum":"THQ-T1-0000001234","trxpoint":"50"}]}
        - Void
        {“sales”:[{"id":"0163621446","trxdate":"06/07/2019","trxnum":"THQ-T1-0000000135","trxtotal":"100"}]}
        {“void”:[{"id":"0163621446","trxdate": "06/07/2019","trxnum":"THQ-T1-0000000135","trxtotal":"-100"}]}
        - Fees
        {"sales":[{"id":"0163621446","trxdate":"3/12/2019","trxnum":"THQ-T1-0000001236","trxtotal":"100"}]}
        {"fees":[{"id":"0163621446","trxdate":"3/12/2019","trxnum":"THQ-T1-0000001236","trxtotal":"10"}]}

		Return Info
		- status - Info = 0: Error, 1: Success
        - status_message - Will display message once *status* = 0
        - id - ID Send from Qube

	****************************************************************** */
	$DWAPIKey = $_REQUEST["apikey-access"];
	//$_REQUEST["sales"] = '[{"id":"0163621446","trxdate":"3/12/2019","trxnum":"ZJ29-T1-0000001236","trxtotal":"129.9"},{"id":"0163621446","trxdate":"3/12/2019","trxnum":"ZJ29-T1-0000001247","trxtotal":"29.9"},{"id":"0163621446","trxdate":"3/12/2019","trxnum":"ZJ29-T1-0000001251","trxtotal":"19.9"}]';
	//
	// Sales Trasaction
	// if minus value = refund
	$DWSalesData = json_decode($_REQUEST["sales"]);
	//
	// Redemption
	// Once got Redeem, deduct point for Customer ID
	$DWRedeemData = json_decode($_REQUEST["Redeem"]);
	//
	// Transaction Void
	// Once got void, deduct trx for Customer ID with Trn Number
	$DWVoidData = json_decode($_REQUEST["void"]);
	//
	// Member Fees
	// Once got void, deduct trx for Customer ID with Trn Number
	$DWFeesData = json_decode($_REQUEST["fees"]);
	
	if ( $DWAPIKey != "api810:lTL0FraU!QzSTM2^XN" ) {
		$ReturnData["status"] = 0;
		$ReturnData["status_message"] = "Wrong API Key";
		
		echo json_encode($ReturnData);
		exit;
	}
	
	if ( count($DWSalesData) > 0 ) {
    	for ($i=0; $i<count($DWSalesData); $i++) {
    	    if ( !empty($DWSalesData[$i]->trxnum) ) {
                $SqlCust_Select = "SELECT * FROM `data_customer` WHERE sbclient_id = '".$DWSalesData[$i]->id."' AND active = 1 AND expired >= NOW() ";
                $RstCust_Select = mysql_query($SqlCust_Select);
                if ( mysql_num_rows($RstCust_Select) == 0 ) {
                    //exit;
                }

        	    $SqlSales_Select = "SELECT * FROM `data_sales_transaction` WHERE trxnum = '".$DWSalesData[$i]->trxnum."' AND active = 1 ";
        	    $RstSales_Select = mysql_query($SqlSales_Select);
        	    if ( mysql_num_rows($RstSales_Select) > 0 ) {
        	        /*
        	        $SqlCust_Update = "UPDATE `data_sales_transaction` SET sbclient_id = '".$DWSalesData[$i]->id."', trxdate = '".date("Y-m-d", strtotime($DWSalesData[$i]->trxdate))."', trxtotal = '".$DWSalesData[$i]->trxtotal."', updated = NOW() WHERE trxnum = '".$DWSalesData[$i]->trxnum."' ";
        	        $RstCust_Update = mysql_query($SqlCust_Update);
        	        */
        	        
        	        $APIData["status"] = 1;
            		$APIData["status_message"] = "Done Update";
            		$APIData["id"] = $DWSalesData[$i]->id;
            		
            		$ReturnData[] = $APIData;
        	    } else {
                    //echo "<br />".
        	        $SqlSales_Insert = "INSERT INTO `data_sales_transaction` (sbclient_id, trxdate, trxnum, trxtotal, updated, created, active) VALUES ('".$DWSalesData[$i]->id."', '".date("Y-m-d", strtotime($DWSalesData[$i]->trxdate))."', '".$DWSalesData[$i]->trxnum."', '".$DWSalesData[$i]->trxtotal."', NOW(), NOW(), 1) ";
        	        $RstSales_Insert = mysql_query($SqlSales_Insert);
                    $DWSalesTranID = mysql_insert_id();

                    //
                    // Select Previous Redeem Voucher
                    $DWTotalVoucherValue = 0;
                    $DWDeductPoint = 0;
                    //echo "<br />".
                    $SqlSalesRec_Select = "SELECT * FROM `data_sales_transaction` WHERE trxnum = '".$DWSalesData[$i]->trxnum."' AND adjustment = 0 AND active = 5 ";
                    $RstSalesRec_Select = mysql_query($SqlSalesRec_Select);
                    while ( $SalesRecord = mysql_fetch_assoc($RstSalesRec_Select) ) {
                        $DWTotalVoucherValue += $SalesRecord["trxtotal"];

                        //echo "<br />".
                        $SqlSalesRec_Update = "UPDATE `data_sales_transaction` SET adjustment = 1 WHERE id = '".$SalesRecord["id"]."' ";
                        $RstSalesRec_Update = mysql_query($SqlSalesRec_Update);
                    }
                    if ( $DWTotalVoucherValue > 0 ) {
                        //echo "<br />DWTotalVoucherValue: ".$DWTotalVoucherValue;
                        //echo "<br />trxtotal: ".$DWSalesData[$i]->trxtotal;
                        if ( $DWTotalVoucherValue > $DWSalesData[$i]->trxtotal ) {
                            $DWDeductPoint = round($DWSalesData[$i]->trxtotal);
                        } else {
                            $DWDeductPoint = round($DWTotalVoucherValue);
                        }
                        //echo "<br />DWDeductPoint: ".$DWDeductPoint;
                    }
                    /*
                    *
                        We Need Add / Deduct Point in Customer Record
                        Check Valid / Before Expiry Member
                        ?
                        ?
                        ?
                    *
                    */
                    if ( $DWSalesData[$i]->trxtotal > 0 ) {
                        $DWPoint = PointCal($DWSalesData[$i]->trxtotal);
                        $DWExQuery = " point = point + ".($DWPoint - $DWDeductPoint)." ";

                        $SqlSalesRec_Update = "UPDATE `data_sales_transaction` SET trxpoint_desc = '+ ".($DWPoint - $DWDeductPoint)." pts' WHERE id = '".$DWSalesTranID."' ";
                        $RstSalesRec_Update = mysql_query($SqlSalesRec_Update);
                    } else {
                        $DWPoint = PointCal($DWSalesData[$i]->trxtotal);
                        $DWExQuery = " point = point - ".($DWPoint - $DWDeductPoint)." ";

                        $SqlSalesRec_Update = "UPDATE `data_sales_transaction` SET trxpoint_desc = '- ".($DWPoint - $DWDeductPoint)." pts' WHERE id = '".$DWSalesTranID."' ";
                        $RstSalesRec_Update = mysql_query($SqlSalesRec_Update);
                    }

                    


                    //echo "<br />".
                    $SqlCustPoint_Update = "UPDATE `data_customer` SET ".$DWExQuery." WHERE sbclient_id = '".$DWSalesData[$i]->id."' AND active = 1 AND expired >= '".date("Y-m-d")."' ";
                    $RstCustPoint_Update = mysql_query($SqlCustPoint_Update);
        	        
        	        $APIData["status"] = 1;
            		$APIData["status_message"] = "Done Insert";
            		$APIData["id"] = $DWSalesData[$i]->id;
            		
            		$ReturnData[] = $APIData;
        	    }
        	} else {
        	    $APIData["status"] = 0;
        		$APIData["status_message"] = "Error trxnum";
        		$APIData["id"] = $DWSalesData[$i]->id;
        		
        		$ReturnData[] = $APIData;
        	}
    	}
	} else {
	    /*
        $APIData["status"] = 0;
		$APIData["status_message"] = "Not Data Pass";
		$APIData["id"] = $DWSalesData[$i]->id;
		
		$ReturnData[] = $APIData;
        */
	}
	
	
	
	if ( count($DWRedeemData) > 0 ) {
    	for ($i=0; $i<count($DWRedeemData); $i++) {
    	    if ( !empty($DWRedeemData[$i]->trxnum) ) {
        	    $SqlSales_Select = "SELECT * FROM `data_sales_transaction` WHERE trxnum = '".$DWRedeemData[$i]->trxnum."' AND active = 2 ";
        	    $RstSales_Select = mysql_query($SqlSales_Select);
        	    if ( mysql_num_rows($RstSales_Select) > 0 ) {
        	        $APIData["status"] = 1;
            		$APIData["status_message"] = "Done Update";
            		$APIData["id"] = $DWRedeemData[$i]->id;
            		
            		$ReturnData[] = $APIData;
        	    } else {
        	        $SqlSales_Insert = "INSERT INTO `data_sales_transaction` (sbclient_id, trxdate, trxnum, trxpoint, updated, created, active) VALUES ('".$DWRedeemData[$i]->id."', '".date("Y-m-d", strtotime($DWRedeemData[$i]->trxdate))."', '".$DWRedeemData[$i]->trxnum."', '".$DWRedeemData[$i]->trxpoint."', NOW(), NOW(), 2) ";
        	        $RstSales_Insert = mysql_query($SqlSales_Insert);
        	        
        	        $APIData["status"] = 1;
            		$APIData["status_message"] = "Done Insert";
            		$APIData["id"] = $DWRedeemData[$i]->id;
            		
            		$ReturnData[] = $APIData;
        	    }
        	} else {
        	    $APIData["status"] = 0;
        		$APIData["status_message"] = "Error trxnum";
        		$APIData["id"] = $DWRedeemData[$i]->id;
        		
        		$ReturnData[] = $APIData;
        	}
    	}
	} else {
        /*
	    $APIData["status"] = 0;
		$APIData["status_message"] = "Not Data Pass";
		$APIData["id"] = $DWRedeemData[$i]->id;
		
		$ReturnData[] = $APIData;
        */
	}
	
	
	
	if ( count($DWVoidData) > 0 ) {
    	for ($i=0; $i<count($DWVoidData); $i++) {
    	    if ( !empty($DWVoidData[$i]->trxnum) ) {
                //echo "<br />Select Sales Transaction: ".
        	    $SqlSales_Select = "SELECT * FROM `data_sales_transaction` WHERE trxnum = '".$DWVoidData[$i]->trxnum."' AND active = 3 ";
        	    $RstSales_Select = mysql_query($SqlSales_Select);
        	    if ( mysql_num_rows($RstSales_Select) > 0 ) {
        	        $APIData["status"] = 1;
            		$APIData["status_message"] = "Done Update";
            		$APIData["id"] = $DWVoidData[$i]->id;
            		
            		$ReturnData[] = $APIData;
        	    } else {
                    //echo "<br />Insert Sales Transaction: ".
        	        $SqlSales_Insert = "INSERT INTO `data_sales_transaction` (sbclient_id, trxdate, trxnum, trxtotal, updated, created, active) VALUES ('".$DWVoidData[$i]->id."', '".date("Y-m-d", strtotime($DWVoidData[$i]->trxdate))."', '".$DWVoidData[$i]->trxnum."', '".$DWVoidData[$i]->trxtotal."', NOW(), NOW(), 3) ";
        	        $RstSales_Insert = mysql_query($SqlSales_Insert);
                    $DWSalesTranID = mysql_insert_id();

                    /*
                    *
                        We Need Add / Deduct Point in Customer Record
                        Check Valid / Before Expiry Member
                    *
                    */
                    //echo "<br />DWPoint: ".
                    $DWPoint = PointCal($DWVoidData[$i]->trxtotal);
                    $DWExQuery = " point = point - ".$DWPoint." ";

                    //echo "<br />Update: ".
                    $SqlSalesRec_Update = "UPDATE `data_sales_transaction` SET trxpoint_desc = '- ".($DWPoint)." pts' WHERE id = '".$DWSalesTranID."' ";
                    $RstSalesRec_Update = mysql_query($SqlSalesRec_Update);

                    $SqlCustPoint_Update = "UPDATE `data_customer` SET ".$DWExQuery." WHERE sbclient_id = '".$DWVoidData[$i]->id."' AND active = 1 AND expired >= '".date("Y-m-d")."' ";
                    $RstCustPoint_Update = mysql_query($SqlCustPoint_Update);
        	        
        	        $APIData["status"] = 1;
            		$APIData["status_message"] = "Done Insert";
            		$APIData["id"] = $DWVoidData[$i]->id;
            		
            		$ReturnData[] = $APIData;
        	    }
        	} else {
        	    $APIData["status"] = 0;
        		$APIData["status_message"] = "Error trxnum";
        		$APIData["id"] = $DWVoidData[$i]->id;
        		
        		$ReturnData[] = $APIData;
        	}
    	}
	} else {
        /*
	    $APIData["status"] = 0;
		$APIData["status_message"] = "Not Data Pass";
		$APIData["id"] = $DWVoidData[$i]->id;
		
		$ReturnData[] = $APIData;
        */
	}
	
	
	
	if ( count($DWFeesData) > 0 ) {
    	for ($i=0; $i<count($DWFeesData); $i++) {
    	    if ( !empty($DWFeesData[$i]->trxnum) ) {
                //echo "<br />Update Voucher: ".
        	    $SqlSales_Select = "SELECT * FROM `data_sales_transaction` WHERE trxnum = '".$DWFeesData[$i]->trxnum."' AND active = 4 ";
        	    $RstSales_Select = mysql_query($SqlSales_Select);
        	    if ( mysql_num_rows($RstSales_Select) > 0 ) {
        	        $APIData["status"] = 1;
            		$APIData["status_message"] = "Done Update";
            		$APIData["id"] = $DWFeesData[$i]->id;
            		
            		$ReturnData[] = $APIData;
        	    } else {
        	        $SqlSales_Insert = "INSERT INTO `data_sales_transaction` (sbclient_id, trxdate, trxnum, trxtotal, updated, created, active) VALUES ('".$DWFeesData[$i]->id."', '".date("Y-m-d", strtotime($DWFeesData[$i]->trxdate))."', '".$DWFeesData[$i]->trxnum."', '".$DWFeesData[$i]->trxtotal."', NOW(), NOW(), 4) ";
        	        $RstSales_Insert = mysql_query($SqlSales_Insert);

                    //echo "<br />Update Voucher: ".
                    $SqlSales_Select = "SELECT * FROM `data_customer` WHERE sbclient_id = '".$DWFeesData[$i]->id."' ";
                    $RstSales_Select = mysql_query($SqlSales_Select);
                    if ( mysql_num_rows($RstSales_Select) > 0 ) {
                        $DWCustVoucherCode = mysql_result($RstSales_Select, 0, "vouchercode");

                        //
                        // Activate Voucher Code
                        //echo "<br />Update Voucher: ".
                        //$SqlVou_Update = "UPDATE data_voucher SET active = 1 WHERE voucher_code = '".$DWCustVoucherCode."' AND active = 3 ";
                        $SqlVou_Update = "UPDATE data_voucher SET active = 1 WHERE (voucher_code = '".$DWCustVoucherCode."' OR voucher_code = '*".$DWCustVoucherCode."*') AND active = 3 ";
                        $RstVou_Update = mysql_query($SqlVou_Update);
                    }
        	        //
                    // Activate Customer to Paid Member
                    $SqlSales_Update = "UPDATE `data_customer` SET active = 1 WHERE sbclient_id = '".$DWFeesData[$i]->id."' ";
                    $RstSales_Update = mysql_query($SqlSales_Update);
                    

        	        $APIData["status"] = 1;
            		$APIData["status_message"] = "Done Insert";
            		$APIData["id"] = $DWFeesData[$i]->id;
            		
            		$ReturnData[] = $APIData;
        	    }
        	} else {
        	    $APIData["status"] = 0;
        		$APIData["status_message"] = "Error trxnum";
        		$APIData["id"] = $DWFeesData[$i]->id;
        		
        		$ReturnData[] = $APIData;
        	}
    	}
	} else {
        /*
	    $APIData["status"] = 0;
		$APIData["status_message"] = "Not Data Pass";
		$APIData["id"] = $DWFeesData[$i]->id;
		
		$ReturnData[] = $APIData;
        */
	}
	
	
	echo json_encode($ReturnData);
	exit;

?>