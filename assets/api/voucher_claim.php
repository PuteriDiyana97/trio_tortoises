<?php
	include 'conf.php';
	include 'barcode.php';

	require 'vendor/autoload.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/voucher_claim.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://cloone.my".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************

		Query Function & Print JSON Data
		810 Member Voucher Claim API
		Sample URL: http://810speedmart.com/api/voucher_claim.php?contactno=[CONTACTNO or '' (EMPTY)]&vid=[VOUCHER INFO ID]

		Return Info

	****************************************************************** */
	$DWUserContact = ReturnValidContact($_REQUEST["contactno"]);
	$DWVoucherInfoID = $_REQUEST["voucher_id"];

	$con = getdb();

	function find_group_id($contact_no) //untuk cari contact no tu punya group kalau ada
	{
		$con = getdb();
		$sql_find_group = "SELECT * FROM data_customer WHERE contact_no = '".$contact_no."' AND active = 1";
		
		$q_find_group = mysqli_query($con,$sql_find_group);
		// $col_parent_contact_no = '';
		$col_group_id = '';

		if (mysqli_num_rows($q_find_group) > 0) {
			$row = mysqli_fetch_assoc($q_find_group);
			$col_group_id = $row['group_id'];//mysqli_fetch_assoc($q_find_parent, 0, "parent_contact_no");
			// $col_contact_no = $row['contact_no'];//mysqli_fetch_assoc($q_find_parent, 0, "contact_no");
		}
		else
		{
			return 0;
		}

		return $col_group_id;
		// if($col_parent_contact_no == $col_contact_no)
		// {
		// 	return $col_contact_no;
		// }
		// else
		// {
		// 	return $col_parent_contact_no;
		// }
		
	}

	///////////////////////////////////////////////////GROUP/////////////////////////////////////////////////////////
	function getGroup_add_point($contact_no)
	{
		$group_id = find_group_id($contact_no);
		if($group_id == 0)
		{
			return 0;
		}

		$sql = "SELECT SUM(points) as pts FROM data_customer_points WHERE group_id = '".$group_id."' AND active = 1 and point_type='1'";
		$con = getdb();
		$q = mysqli_query($con,$sql);
		$col_pts = 0;
		if (mysqli_num_rows($q) > 0) {
			$row = mysqli_fetch_assoc($q);
			$col_pts = $row['pts'];//mysqli_fetch_assoc($q, 0, "pts");
		}

		return $col_pts;
	}

	function getGroup_deduct_point($contact_no)
	{
		$group_id = find_group_id($contact_no);
		if($group_id == 0)
		{
			return 0;
		}

		$sql = "SELECT SUM(points) as pts FROM data_customer_points WHERE group_id = '".$group_id."' AND active = 1 and point_type='0'";
		$con = getdb();
		$q = mysqli_query($con,$sql);
		$col_pts = 0;
		if (mysqli_num_rows($q) > 0) {
			$row = mysqli_fetch_assoc($q);
			$col_pts = $row['pts'];//mysqli_fetch_assoc($q, 0, "pts");
		}

		return $col_pts;
	}

	function getGroup_point($contact_no)
	{
		$group_add_point = getGroup_add_point($contact_no);
	
		$group_deduct_point = getGroup_deduct_point($contact_no);
		
		$balance_point = $group_add_point - $group_deduct_point;
		
		return $balance_point;
	}
	///////////////////////////////////////////////////GROUP/////////////////////////////////////////////////////////



	///////////////////////////////////////////////////SINGLE/////////////////////////////////////////////////////////
	function getIndividual_add_point($contact_no)
	{
		$sql = "SELECT SUM(points) as pts FROM data_customer_points WHERE contact_no = '".$contact_no."' AND active = 1 and point_type='1'";
		$con = getdb();
		$q = mysqli_query($con,$sql);
		$col_pts = 0;
		if (mysqli_num_rows($q) > 0) {
			$row = mysqli_fetch_assoc($q);
			$col_pts = $row['pts'];//mysqli_fetch_assoc($q, 0, "pts");
		}

		return $col_pts;
	}

	function getIndividual_deduct_point($contact_no)
	{
		$sql = "SELECT SUM(points) as pts FROM data_customer_points WHERE contact_no = '".$contact_no."' AND active = 1 and point_type='0'";
		$con = getdb();
		$q = mysqli_query($con,$sql);
		$col_pts = 0;
		if (mysqli_num_rows($q) > 0) {
			$row = mysqli_fetch_assoc($q);
			$col_pts = $row['pts'];//mysqli_fetch_assoc($q, 0, "pts");
		}

		return $col_pts;
	}

	function getIndividual_point($contact_no)
	{
		$individual_add_point = getIndividual_add_point($contact_no);
	
		$individual_deduct_point = getIndividual_deduct_point($contact_no);
		
		$balance_point = $individual_add_point - $individual_deduct_point;
		
		return $balance_point;
	}
	///////////////////////////////////////////////////SINGLE/////////////////////////////////////////////////////////


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

	

	if ( $DWUserContact != "" && $DWVoucherInfoID > 0 ) {

		$con = getdb();
		$DWCustPointSingle = 0;
		$group_id = 0;
		$DWCustPointSingle = getIndividual_point($DWUserContact);
		$group_id = find_group_id($DWUserContact);

		$SqlInfo_Select = "SELECT v.* FROM data_voucher v WHERE v.id = '".$DWVoucherInfoID."' AND DATE(v.start_date) <= '".date("Y-m-d")."' AND DATE(v.end_date) >= '".date("Y-m-d")."' AND v.exchange_point <= '".$DWCustPointSingle."' AND v.active = 1 ";
		$RstInfo_Select = mysqli_query($con,$SqlInfo_Select);

		if (mysqli_num_rows($RstInfo_Select) > 0) { //means cukup takyah pinjam sapa2
			while ($InfoData = mysqli_fetch_assoc($RstInfo_Select)) {

				$con = getdb();

				//////////////BAHAGIAN CREATE VOUCHER CODE BERSERTA BARCODE//////////////////////////////
				$DWVoucherCode = "";
				$DWVoucherCode = getRandVoucher();

				// generate then save -- https://github.com/picqer/php-barcode-generator
				$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
				$path_to_save_barcode = '../voucher_barcode/';
				$barcode_img_name = $DWVoucherCode.'_'.uniqid().'.png';
				// $barcode_value = $DWVoucherCode;
				file_put_contents($path_to_save_barcode.$barcode_img_name, $generator->getBarcode($DWVoucherCode, $generator::TYPE_CODE_128));
				//////////////BAHAGIAN CREATE VOUCHER CODE BERSERTA BARCODE//////////////////////////////

				$SqlVou_Insert = "INSERT INTO data_voucher_cust (voucher_id, contact_no, voucher_code, barcode, trxvalue, updated, created, claim_date, voucher_status) VALUES ('".$InfoData["id"]."', '".$DWUserContact."', '".$DWVoucherCode."', '".$barcode_img_name."', '".$InfoData["voucher_value"]."', NOW(), NOW(), NOW(), 1)  ";
				$RstVou_Insert = mysqli_query($con,$SqlVou_Insert);

				$check_group_id = find_group_id($DWUserContact);
				$Sql_SelectParent = "SELECT d.* FROM data_customer d WHERE d.group_id = '".$check_group_id."'";
				$Rst_SelectParent = mysqli_query($con,$Sql_SelectParent);

				
				if ( mysqli_num_rows($Rst_SelectParent) > 0 ) { //means dah ada group
					$SqlPoint_InsertGroup = "INSERT INTO data_customer_points (group_id, contact_no, points, point_type, description, transaction_date, created, active) VALUES ('".$check_group_id."', '".$DWUserContact."', '".$InfoData["exchange_point"]."', 0, 'Voucher Claim', NOW(), NOW(), 1)  ";
					$RstPoint_InsertGroup = mysqli_query($con,$SqlPoint_InsertGroup);
				}
				else{ //takda group
					$SqlPoint_InsertIndividual = "INSERT INTO data_customer_points (group_id, contact_no, points, point_type, description, transaction_date, created, active) VALUES (NULL, '".$DWUserContact."', '".$InfoData["exchange_point"]."', 0, 'Voucher Claim', NOW(), NOW(), 1)  ";
					$RstPoint_InsertIndividual = mysqli_query($con,$SqlPoint_InsertIndividual);
				}

			}
			$MainData["status"] = "1";
			$MainData["status_message"] = "Successfully claim voucher";
		} else { //point individu tak cukup, kena check point group cukup ke tak

			$con = getdb();
			$DWCustPointGroups = 0;
			$DWCustPointGroups = getGroup_point($DWUserContact);

			$SqlInfo_SelectGroupPoint = "SELECT v.* FROM data_voucher v WHERE v.id = '".$DWVoucherInfoID."' AND DATE(v.start_date) <= '".date("Y-m-d")."' AND DATE(v.end_date) >= '".date("Y-m-d")."' AND v.exchange_point <= '".$DWCustPointGroups."' AND v.active = 1";
			$RstInfo_SelectGroupPoint = mysqli_query($con,$SqlInfo_SelectGroupPoint);

			$InfoDataVoucher = mysqli_fetch_assoc($RstInfo_SelectGroupPoint);
			$exchange_point = $InfoDataVoucher["exchange_point"];

			if (mysqli_num_rows($RstInfo_SelectGroupPoint) > 0) { //means group cukup point so boleh proceed, then kena cari siapa highest
				$con = getdb();
				$group_idFirst = 0;
				$group_idFirst = find_group_id($DWUserContact);
				
				$SqlInfo_SelectContact = "SELECT v.* FROM data_customer v WHERE v.group_id = '".$group_idFirst."' AND v.active = 1 ";
				$RstInfo_SelectContact = mysqli_query($con,$SqlInfo_SelectContact);

				// $remaining_pending = $exchange_point - $DWCustPointSingle;
				$pending = $exchange_point - $DWCustPointSingle;

				if (mysqli_num_rows($RstInfo_SelectContact) > 0) { //means group exist so boleh proceed
					$sql_get_sum_totall = "SELECT data_customer_points.contact_no, SUM(data_customer_points.points) as total_sum_point
											FROM data_customer_points
											LEFT JOIN data_customer ON data_customer.contact_no = data_customer_points.contact_no
											WHERE data_customer_points.active = 1
											AND data_customer.active = 1
											AND data_customer.contact_no != '".$DWUserContact."'
											AND data_customer_points.point_type = 1
											AND data_customer.group_id = '".$group_idFirst."'
											GROUP BY data_customer_points.contact_no
											ORDER BY total_sum_point DESC, data_customer.created ASC";
					$RstInfo_Search = mysqli_query($con,$sql_get_sum_totall);

					while ($InfoDataCustomer = mysqli_fetch_assoc($RstInfo_Search)) { //Listing group punya detail
						$lender_contactno = $InfoDataCustomer["contact_no"];
						$lender_point = getIndividual_point($lender_contactno);

						$remaining_pending = $pending - $lender_point;
						
						if ($remaining_pending <= 0){ //dah takda hutang
							//kena update pasal org last
							$SqlPoint_InsertLast = "INSERT INTO data_customer_points (group_id, contact_no, points, point_type, description, transaction_date, created, active) VALUES ('".$group_idFirst."', '".$lender_contactno."', '".$pending."', 0, 'Used for Voucher Claim by ".$DWUserContact."', NOW(), NOW(), 1)  ";
							$RstPoint_InsertLast = mysqli_query($con,$SqlPoint_InsertLast);

							break;
						}
						else {
							//kena update pasal org yg kita pinjam
							$SqlPoint_InserSecond = "INSERT INTO data_customer_points (group_id, contact_no, points, point_type, description, transaction_date, created, active) VALUES ('".$group_idFirst."', '".$lender_contactno."', '".$lender_point."', 0, 'Used for Voucher Claim by ".$DWUserContact."', NOW(), NOW(), 1)  ";
							$RstPoint_InserSecond = mysqli_query($con,$SqlPoint_InserSecond);

							$pending = $remaining_pending;
						}
					}

					//////////////BAHAGIAN CREATE VOUCHER CODE BERSERTA BARCODE//////////////////////////////
					$con = getdb();
					$DWVoucherCode = "";
					$DWVoucherCode = getRandVoucher();

					// generate then save -- https://github.com/picqer/php-barcode-generator
					$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
					$path_to_save_barcode = '../voucher_barcode/';
					$barcode_img_name = $DWVoucherCode.'_'.uniqid().'.png';
					// $barcode_value = $DWVoucherCode;
					file_put_contents($path_to_save_barcode.$barcode_img_name, $generator->getBarcode($DWVoucherCode, $generator::TYPE_CODE_128));
					//////////////BAHAGIAN CREATE VOUCHER CODE BERSERTA BARCODE//////////////////////////////

					$SqlVou_Insert = "INSERT INTO data_voucher_cust (voucher_id, contact_no, voucher_code, barcode, trxvalue, updated, created, claim_date, voucher_status) VALUES ('".$InfoDataVoucher["id"]."', '".$DWUserContact."', '".$DWVoucherCode."', '".$barcode_img_name."', '".$InfoDataVoucher["voucher_value"]."', NOW(), NOW(), NOW(), 1)  ";
					$RstVou_Insert = mysqli_query($con,$SqlVou_Insert);

					$SqlPoint_InsertFirst = "INSERT INTO data_customer_points (group_id, contact_no, points, point_type, description, transaction_date, created, active) VALUES ('".$group_idFirst."', '".$DWUserContact."', '".$DWCustPointSingle."', 0, 'Voucher Claim', NOW(), NOW(), 1)  ";
					$RstPoint_InsertFirst = mysqli_query($con,$SqlPoint_InsertFirst);
					
					$MainData["status"] = "1";
					$MainData["status_message"] = "Successfully claim voucher";
				}
				else { //takda group so jadah apa memang insufficient la anat
					$MainData["status"] = "2";
					$MainData["status_message"] = "Insufficient points to claim voucher";
				}
			}
			else{//means group pun tak cukup so memang takleh proceed claim
				$MainData["status"] = "2";
				$MainData["status_message"] = "Insufficient points to claim voucher";
			}
			// $MainData["status"] = "2";
			// $MainData["status_message"] = "Insufficient points to claim voucher";
		}//kat sini kena hantar message tak cukup point
		
	} else {
		$MainData["ACCOUNT_IMAGE"] = "http://810speedmart.com/api/images/member_login_2.png";
		$MainData["status"] = "0";
		$MainData["status_message"] = "Need Login";
	}
	
	echo json_encode($MainData);
	exit;
?>