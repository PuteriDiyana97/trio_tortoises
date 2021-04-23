<?php
    include 'conf.php';
	
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/sales_transaction_detail'.date("Y-m-d").'.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - https://810speedmart.com".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************

		Query Function & Print JSON Data
		810 Sales Transaction Detail Data QAPI
		Sample URL: http://810speedmart.com/qapi/sales_transaction_detail.php?apikey-access=api810:lTL0FraU!QzSTM2^XN&salesdtl=[{"id":"60123371500","outlet":"THQ","trxdate":"06/26/2019","trxnum":"THQ-T1-0000000208","seq":"1","plucode":"10010101001","barcode":"9555589209220","desc":"100PLUS ","qty":"2","netprice":"5.80"},{"id":"60123371500","outlet":"THQ","trxdate":"06/26/2019","trxnum":"THQ-T1-0000000208","seq":"2","plucode":"10010101018","barcode":"9555589209320","desc":" GOAT MILK SOAP","qty":"1","netprice":"2.00"},{"id":"60123371500","outlet":"THQ","trxdate":"06/26/2019","trxnum":"THQ-T1-0000000208","seq":"3","plucode":"10010101321","barcode":"9555589219335","desc":" TABLE ABS ","qty":"1","netprice":"22.50","category":""}]

		Return Info
		- status - Info = 0: Error, 1: Success
        - status_message - Will display message once *status* = 0
        - id - ID Send from Qube

	****************************************************************** */
	$DWAPIKey = $_REQUEST["apikey-access"];

	//$DWProductData = json_decode($_REQUEST["salesdtl"]);
    $DWProductData = json_decode(str_replace(array("'"), "", $_REQUEST["salesdtl"]));

	/*
	echo "<pre>";
	print_r($DWProductData);
	echo "</pre>";
	exit;
	
	[id] => 60123371500
    [outlet] => THQ
    [trxdate] => 06/26/2019
    [trxnum] => THQ-T1-0000000208
    [seq] => 1
    [plucode] => 10010101001
    [barcode] => 9555589209220
    [desc] => 100PLUS 
    [qty] => 2
    [netprice] => 5.80
	*/
	
	if ( $DWAPIKey != "api810:lTL0FraU!QzSTM2^XN" ) {
		$ReturnData["status"] = 0;
		$ReturnData["status_message"] = "Wrong API Key";
		
		echo json_encode($ReturnData);
		exit;
	}
	
	if ( count($DWProductData) > 0 ) {
    	for ($i=0; $i<count($DWProductData); $i++) {
    		$DWProductData[$i]->trxdate = date("Y-m-d", strtotime($DWProductData[$i]->trxdate));

    		$DWTranID = 0;
    		$SqlPro_Select = "SELECT * FROM `data_sales_transaction` WHERE trxnum = '".$DWProductData[$i]->trxnum."' ";
            $RstPro_Select = mysql_query($SqlPro_Select);
            if ( mysql_num_rows($RstPro_Select) > 0 ) {
            	$DWTranID = mysql_result($RstPro_Select, 0, "id");
            }

    	    $SqlPro_Select = "SELECT * FROM `data_sales_transaction_detail` WHERE trxnum = '".$DWProductData[$i]->trxnum."' AND seq = '".$DWProductData[$i]->seq."' ";
            $RstPro_Select = mysql_query($SqlPro_Select);
            if ( mysql_num_rows($RstPro_Select) > 0 ) {
            	$DWDetailID = mysql_result($RstPro_Select, 0, "detail_id");

            	//echo "<br />Update: ".
            	$SqlPro_Update = "UPDATE `data_sales_transaction_detail` SET sbclient_id = '".$DWProductData[$i]->id."', outlet = '".$DWProductData[$i]->outlet."', trxdate = '".$DWProductData[$i]->trxdate."', trxnum = '".$DWProductData[$i]->trxnum."', plucode = '".$DWProductData[$i]->plucode."', barcode = '".$DWProductData[$i]->barcode."', description = '".$DWProductData[$i]->desc."', qty = '".$DWProductData[$i]->qty."', netprice = '".$DWProductData[$i]->netprice."', category = '".$DWProductData[$i]->category."', updated = NOW() WHERE detail_id = '".$DWDetailID."' ";
            	$RstPro_Update = mysql_query($SqlPro_Update);

            	$DWProductData[$i]->status = "1";
            } else {
            	//echo "<br />".
            	$SqlPro_Insert = "INSERT INTO `data_sales_transaction_detail` (sales_transaction_id, sbclient_id, outlet, trxdate, trxnum, seq, plucode, barcode, description, qty, netprice, category, updated, created, active) VALUES ('".$DWTranID."', '".$DWProductData[$i]->id."', '".$DWProductData[$i]->outlet."', '".$DWProductData[$i]->trxdate."', '".$DWProductData[$i]->trxnum."', '".$DWProductData[$i]->seq."', '".$DWProductData[$i]->plucode."', '".$DWProductData[$i]->barcode."', '".$DWProductData[$i]->desc."', '".$DWProductData[$i]->qty."', '".$DWProductData[$i]->netprice."', '".$DWProductData[$i]->category."', NOW(), NOW(), 1) ";
            	$RstPro_Insert = mysql_query($SqlPro_Insert);

            	$DWProductData[$i]->status = "1";
            }

            unset($DWProductInfo);
            $DWProductInfo["status"] = $DWProductData[$i]->status;
            $DWProductInfo["status_message"] = "DONE";
    		$DWProductInfo["trxnum"] = $DWProductData[$i]->trxnum;
            $DWReturn[] = $DWProductInfo;
    	}
	}
	
	echo json_encode($DWReturn);
	exit;

?>