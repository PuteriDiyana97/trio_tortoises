<?php
	include 'conf.php';
	require 'vendor/autoload.php';
// 	ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
    /* ******************************************************************

        Write Request Data to Server

    ****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
    $fp = fopen('logs/voucher_birthday_check.txt', 'a');
    fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://stargloryasia.com/".$_SERVER['REQUEST_URI']."\n".$req_dump);
    fclose($fp);
    
    /* ******************************************************************

        Query Function & Print JSON Data
        810 Member Voucher Claim API
        Sample URL: http://810speedmart.com/api/voucher_claim.php?contactno=[CONTACTNO or '' (EMPTY)]&vid=[VOUCHER INFO ID]

        Return Info

    ****************************************************************** */

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
		$con = getdb();

		if ($VoucherCode == "") {
			$VoucherCode = strtoupper(izrand());
		}
		// $VoucherCode = "*".$VoucherCode."*";
		$SqlVou_Select = "SELECT * FROM data_voucher_cust WHERE voucher_code = '".$VoucherCode."' LIMIT 1 ";
		$RstVou_Select = mysqli_query($con,$SqlVou_Select);
		if (mysqli_num_rows($RstVou_Select) > 0) {
			$VoucherCode = getRandVoucher();
		}

		return $VoucherCode;
	}

        $con = getdb();
        mysqli_set_charset($con, "utf8");

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $SqlInfo_CheckCust = "SELECT c.* FROM data_customer c WHERE MONTH(c.date_of_birth) < MONTH('".date("Y-m-d")."') AND c.birthday_voucher = 1 AND c.active > 0 ";
        $RstInfo_CheckCust = mysqli_query($con,$SqlInfo_CheckCust);

        if (mysqli_num_rows($RstInfo_CheckCust) > 0) {
            while ($InfoCheckCust = mysqli_fetch_assoc($RstInfo_CheckCust)) {
                $con = getdb();

                $Sql_UpdateCust = "UPDATE data_customer SET birthday_voucher = 0 WHERE tel = '".$InfoCheckCust["tel"]."'";
	            $Rst_UpdateCust = mysqli_query($con,$Sql_UpdateCust);
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $Sql_SelectBirthday = "SELECT v.* FROM data_voucher v WHERE v.active = 1 AND v.voucher_type = 1 AND DATE(v.start_date) <= '".date("Y-m-d")."' AND DATE(v.end_date) >= '".date("Y-m-d")."' LIMIT 1";
        $Rst_Select = mysqli_query($con,$Sql_SelectBirthday);
        $InfoDataBirthday = mysqli_fetch_assoc($Rst_Select);

        if (mysqli_num_rows($Rst_Select) > 0) {//Maksudnya wujud voucher untuk bulan tu

            $SqlInfo_SelectCust = "SELECT c.* FROM data_customer c WHERE MONTH(c.date_of_birth) = MONTH('".date("Y-m-d")."') AND c.birthday_voucher = 0 AND c.active > 0 ";
            $RstInfo_SelectCust = mysqli_query($con,$SqlInfo_SelectCust);
			
            if (mysqli_num_rows($RstInfo_SelectCust) > 0) {//maksudnya ada user yg hari jadi dia pada hari itu
                while ($InfoDataCust = mysqli_fetch_assoc($RstInfo_SelectCust)) {
                    $con = getdb();

                    //////////////BAHAGIAN CREATE VOUCHER CODE BERSERTA BARCODE//////////////////////////////
                    $DWVoucherCode = "";
					$DWVoucherCode = getRandVoucher();

					
                    $SqlVou_Insert = "INSERT INTO data_voucher_cust (voucher_id, contact_no, voucher_code, trxvalue, updated, created, claim_date, voucher_status) VALUES ('".$InfoDataBirthday["id"]."', '".$InfoDataCust["contact_no"]."', '".$DWVoucherCode."', '".$InfoDataBirthday["voucher_value"]."', NOW(), NOW(), NOW(), 1)  ";
					$RstVou_Insert = mysqli_query($con,$SqlVou_Insert);
                    
                    $Sql_UpdateCust = "UPDATE data_customer SET birthday_voucher = 1 WHERE contact_no = '".$InfoDataCust["contact_no"]."'";
	                $Rst_UpdateCust = mysqli_query($con,$Sql_UpdateCust);
				}
				
				$MainData["status"] = "1";
                $MainData["status_message"] = "Successfully send birthday voucher";

                
            } else {
                $MainData["status"] = "2";
                $MainData["status_message"] = "There are no customer's birthday";
            }
        }
        else { //Tak wujud voucher
            $MainData["status"] = "2";
            $MainData["status_message"] = "There are no birthday voucher created";
        }
        
    
    echo json_encode($MainData);
    exit;
?>
