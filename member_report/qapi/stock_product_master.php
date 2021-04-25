<?php
    include 'conf.php';
	
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/stock_product_master'.date("Y-m-d").'.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - https://810speedmart.com".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************

		Query Function & Print JSON Data
		810 Product Master Data QAPI
		Sample URL: http://810speedmart.com/qapi/stock_product_master.php?apikey-access=api810:lTL0FraU!QzSTM2^XN&onlinestock=[{"plucode":"10010101001","barcode":"9555589209220","desc":"100PL'US","supplier":"DM","pricelevel": "810VIP1","price": "2.90","offerdateactive1":"T","offerdatefrom1":"10/01/2019","offerdateto1":"10/13/2019","offertimeactive1":"T","offertimefrom1":"10:00","offertimeto1":"22:00","offerprice1":"2.50","offerdateactive2":"T","offerdatefrom2":"12/31/2019","offerdateto2":"12/31/2019","offertimeactive2":"T","offertimefrom2":"10:00","offertimeto2":"22:00","offerprice2":"2.00"}]

		Return Info
		- status - Info = 0: Error, 1: Success
        - status_message - Will display message once *status* = 0
        - plucode - plucode Send from Qube
        - pricelevel - pricelevel Send from Qube

	****************************************************************** */
	$DWAPIKey = $_REQUEST["apikey-access"];
    //$_REQUEST["onlinestock"] = '[{"plucode":"10010101001","barcode":"9555589209220","desc":"100PLUS","supplier":"DM","pricelevel": "810VIP1","price": "2.90","offerdateactive1":"T","offerdatefrom1":"10/01/2019","offerdateto1":"10/13/2019","offertimeactive1":"T","offertimefrom1":"10:00","offertimeto1":"22:00","offerprice1":"2.50","offerdateactive2":"T","offerdatefrom2":"12/31/2019","offerdateto2":"12/31/2019","offertimeactive2":"T","offertimefrom2":"10:00","offertimeto2":"22:00","offerprice2":"2.00"},{"plucode":"10010101018","barcode":"9555589209320","desc":"GOAT MILK SOAP","supplier":"","pricelevel": "810VIP1","price": "2.00","offerdateactive1":"F","offerdatefrom1":"01/01/1900","offerdateto1":"01/01/1900","offertimeactive1":"F","offertimefrom1":"00:00","offertimeto1":"00:00","offerprice1":"0.00","offerdateactive2":"F","offerdatefrom2":"01/01/1900","offerdateto2":"01/01/1900","offertimeactive2":"F","offertimefrom2":"00:00","offertimeto2":"00:00","offerprice2":"0.00"},{"plucode":"10010101321","barcode":"9555589219335","desc":"TABLE ABS","supplier":"EX","pricelevel": "810VIP1","price": "22.50","offerdateactive1":"T","offerdatefrom1":"10/31/2019","offerdateto1":"10/31/2019","offertimeactive1":"F","offertimefrom1":"00:00","offertimeto1":"00:00","offerprice1":"22.00","offerdateactive2":"F","offerdatefrom2":"01/01/1900","offerdateto2":"01/01/1900","offertimeactive2":"F","offertimefrom2":"00:00","offertimeto2":"00:00","offerprice2":"0.00"}]';
	//$DWProductData = json_decode($_REQUEST["onlinestock"]);
    $DWProductData = json_decode(str_replace(array("'"), "", $_REQUEST["onlinestock"]));

	/*
	echo "<pre>";
	print_r($DWCustomerData);
	echo "</pre>";
	exit;

	[plucode] => 10010101001
    [barcode] => 9555589209220
    [desc] => 100PLUS
    [supplier] => DM
    [pricelevel] => 810VIP1
    [price] => 2.90
    [offerdateactive1] => T
    [offerdatefrom1] => 10/01/2019
    [offerdateto1] => 10/13/2019
    [offertimeactive1] => T
    [offertimefrom1] => 10:00
    [offertimeto1] => 22:00
    [offerprice1] => 2.50
    [offerdateactive2] => T
    [offerdatefrom2] => 12/31/2019
    [offerdateto2] => 12/31/2019
    [offertimeactive2] => T
    [offertimefrom2] => 10:00
    [offertimeto2] => 22:00
    [offerprice2] => 2.00
	*/
	
	if ( $DWAPIKey != "api810:lTL0FraU!QzSTM2^XN" ) {
		$ReturnData["status"] = 0;
		$ReturnData["status_message"] = "Wrong API Key";
		
		echo json_encode($ReturnData);
		exit;
	}
	
	if ( count($DWProductData) > 0 ) {
    	for ($i=0; $i<count($DWProductData); $i++) {

    	    $SqlPro_Select = "SELECT * FROM `data_product` WHERE plucode = '".$DWProductData[$i]->plucode."' AND pricelevel = '".$DWProductData[$i]->pricelevel."' ";
            $RstPro_Select = mysql_query($SqlPro_Select);
            if ( mysql_num_rows($RstPro_Select) > 0 ) {
            	$DWProductID = mysql_result($RstPro_Select, 0, "product_id");

            	//echo "<br /><br />Update '".$DWProductData[$i]->plucode."': ".
            	$SqlPro_Update = "UPDATE `data_product` SET `group` = '".$DWProductData[$i]->group."', group_desc = '".$DWProductData[$i]->group_desc."', department = '".$DWProductData[$i]->department."', department_desc = '".$DWProductData[$i]->department_desc."', brand = '".$DWProductData[$i]->brand."', brand_desc = '".$DWProductData[$i]->brand_desc."', category = '".$DWProductData[$i]->category."', category_desc = '".$DWProductData[$i]->category_desc."', plulinkid = '".$DWProductData[$i]->plulinkid."', barcode = '".$DWProductData[$i]->barcode."', description = '".$DWProductData[$i]->desc."', supplier = '".$DWProductData[$i]->supplier."', supplier_desc = '".$DWProductData[$i]->supplier_desc."', pricelevel = '".$DWProductData[$i]->pricelevel."', unit_minimum_order = '".$DWProductData[$i]->reordqty."', minimum_reorder_leavel = '".$DWProductData[$i]->minlevel."', maximum_reorder_leavel = '".$DWProductData[$i]->maxlevel."', price = '".$DWProductData[$i]->price."', cost = '".$DWProductData[$i]->unitcost."', updated = NOW(), active_qube = '".$DWProductData[$i]->active."' WHERE product_id = '".$DWProductID."' ";
            	$RstPro_Update = mysql_query($SqlPro_Update);

            	$DWProductData[$i]->status = "1";
            } else {
                //echo "<br /><br />Insert '".$DWProductData[$i]->plucode."': ".
            	$SqlPro_Insert = "INSERT INTO `data_product` (`group`, group_desc, department, department_desc, brand, brand_desc, category, category_desc, plucode, plulinkid, barcode, description, supplier, supplier_desc, pricelevel, unit_minimum_order, minimum_reorder_leavel, maximum_reorder_leavel, price, cost, active_qube, updated, created, active) VALUES ('".$DWProductData[$i]->group."', '".$DWProductData[$i]->group_desc."', '".$DWProductData[$i]->department."', '".$DWProductData[$i]->department_desc."', '".$DWProductData[$i]->brand."', '".$DWProductData[$i]->brand_desc."', '".$DWProductData[$i]->category."', '".$DWProductData[$i]->category_desc."', '".$DWProductData[$i]->plucode."', '".$DWProductData[$i]->plulinkid."', '".$DWProductData[$i]->barcode."', '".$DWProductData[$i]->desc."', '".$DWProductData[$i]->supplier."', '".$DWProductData[$i]->supplier_desc."', '".$DWProductData[$i]->pricelevel."', '".$DWProductData[$i]->reordqty."', '".$DWProductData[$i]->minlevel."', '".$DWProductData[$i]->maxlevel."', '".$DWProductData[$i]->price."', '".$DWProductData[$i]->unitcost."', '".$DWProductData[$i]->active."', NOW(), NOW(), 1) ";
            	$RstPro_Insert = mysql_query($SqlPro_Insert);

            	$DWProductData[$i]->status = "1";
            }

            unset($DWProductInfo);
            $DWProductInfo["status"] = $DWProductData[$i]->status;
            $DWProductInfo["status_message"] = "DONE";
    		$DWProductInfo["plucode"] = $DWProductData[$i]->plucode;
            $DWProductInfo["pricelevel"] = $DWProductData[$i]->pricelevel;
            $DWReturn[] = $DWProductInfo;
    	}
	}
	
	echo json_encode($DWReturn);
	exit;

?>