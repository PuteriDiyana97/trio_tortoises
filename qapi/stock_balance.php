<?php
    include 'conf.php';
	
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/stock_balance'.date("Y-m-d").'.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - https://810speedmart.com".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************

		Query Function & Print JSON Data
		810 Stock Balance Data QAPI
		Sample URL: http://810speedmart.com/qapi/stock_balance.php?apikey-access=api810:lTL0FraU!QzSTM2^XN&stockbalance=[{"outlet":"THQ","plucode":"10010101001","barcode":"9555589209220","balance":"100"},{"outlet":"THQ","plucode":"10010101018","barcode":"9555589209320","balance":"80"},{"outlet":"THQ","plucode":"10010101321","barcode":"9555589219335","balance":"50"}]

		Return Info
		- status - Info = 0: Error, 1: Success
        - status_message - Will display message once *status* = 0
        - plucode - plucode Send from Qube
        - outlet - outlet Send from Qube

	****************************************************************** */
	$DWAPIKey = $_REQUEST["apikey-access"];
	$DWProductData = json_decode($_REQUEST["stockbalance"]);
	$DWProductData = json_decode(str_replace(array("'"), "", $_REQUEST["stockbalance"]));

	/*
	echo "<pre>";
	print_r($DWProductData);
	echo "</pre>";
	exit;

	[outlet] => THQ
    [plucode] => 10010101321
    [barcode] => 9555589219335
    [balance] => 50
	*/
	
	if ( $DWAPIKey != "api810:lTL0FraU!QzSTM2^XN" ) {
		$ReturnData["status"] = 0;
		$ReturnData["status_message"] = "Wrong API Key";
		
		echo json_encode($ReturnData);
		exit;
	}
	
	if ( count($DWProductData) > 0 ) {
    	for ($i=0; $i<count($DWProductData); $i++) {

    		//
            // Alfred Hardcode , because QUBE pass 0 , should 810 no update !
            $DWProductData[$i]->reordqty = 12;
            
    	    $SqlPro_Select = "SELECT * FROM `data_product_balance` WHERE plucode = '".$DWProductData[$i]->plucode."' AND outlet = '".$DWProductData[$i]->outlet."' ";
            $RstPro_Select = mysql_query($SqlPro_Select);
            if ( mysql_num_rows($RstPro_Select) > 0 ) {
            	$DWBalanceID = mysql_result($RstPro_Select, 0, "balance_id");

            	//echo "<br />Update: ".
            	$SqlPro_Update = "UPDATE `data_product_balance` SET outlet = '".$DWProductData[$i]->outlet."', plucode = '".$DWProductData[$i]->plucode."', plulinkid = '".$DWProductData[$i]->plulinkid."', barcode = '".$DWProductData[$i]->barcode."', balance = '".$DWProductData[$i]->balance."', unit_minimum_order = '".$DWProductData[$i]->reordqty."', minimum_reorder_leavel = '".$DWProductData[$i]->minlevel."', maximum_reorder_leavel = '".$DWProductData[$i]->maxlevel."', updated = NOW() WHERE balance_id = '".$DWBalanceID."' ";
            	$RstPro_Update = mysql_query($SqlPro_Update);

            	$DWProductData[$i]->status = "1";
            } else {
            	$SqlPro_Insert = "INSERT INTO `data_product_balance` (outlet, plucode, plulinkid, barcode, unit_minimum_order, minimum_reorder_leavel, maximum_reorder_leavel, balance, updated, created, active) VALUES ('".$DWProductData[$i]->outlet."', '".$DWProductData[$i]->plucode."', '".$DWProductData[$i]->plulinkid."', '".$DWProductData[$i]->barcode."', '".$DWProductData[$i]->reordqty."', '".$DWProductData[$i]->minlevel."', '".$DWProductData[$i]->maxlevel."', '".$DWProductData[$i]->balance."', NOW(), NOW(), 1) ";
            	$RstPro_Insert = mysql_query($SqlPro_Insert);

            	$DWProductData[$i]->status = "1";
            }

            unset($DWProductInfo);
            $DWProductInfo["status"] = $DWProductData[$i]->status;
            $DWProductInfo["status_message"] = "DONE";
    		$DWProductInfo["plucode"] = $DWProductData[$i]->plucode;
    		$DWProductInfo["outlet"] = $DWProductData[$i]->outlet;
            $DWReturn[] = $DWProductInfo;
    	}
	}
	
	echo json_encode($DWReturn);
	exit;

?>