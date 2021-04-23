<?php
    include 'conf.php';
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
	$DWVoucherCustID = $_REQUEST["voucher_customer_id"];
	$DWVoucherInfoID = $_REQUEST["voucher_id"];
	$DWVoucherCodeID = $_REQUEST["voucher_code"];

	$con = getdb();

	function find_parent_contact_no($contact_no)
	{
		$con = getdb();
		$sql_find_parent = "SELECT * FROM data_customer WHERE contact_no = '".$contact_no."' AND active = 1 LIMIT 1";
		
		$q_find_parent = mysqli_query($con,$sql_find_parent);
		$col_parent_contact_no = '';
		$col_contact_no = '';

		if (mysqli_num_rows($q_find_parent) > 0) {
			$row = mysqli_fetch_assoc($q_find_parent);
			$col_parent_contact_no = $row['parent_contact_no'];//mysqli_fetch_assoc($q_find_parent, 0, "parent_contact_no");
			$col_contact_no = $row['contact_no'];//mysqli_fetch_assoc($q_find_parent, 0, "contact_no");
		}
		else
		{
			return 0;
		}

		if($col_parent_contact_no == $col_contact_no)
		{
			return $col_contact_no;
		}
		else
		{
			return $col_parent_contact_no;
		}
		
	}

	function getTotal_add_point($contact_no)
	{
		$parent_contact_no = find_parent_contact_no($contact_no);
		if($parent_contact_no == 0)
		{
			return 0;
		}

		$sql = "SELECT SUM(points) as pts FROM data_customer_points WHERE parent_contact_no = '".$parent_contact_no."' AND active = 1 and point_type='1' LIMIT 1";
		$con = getdb();
		$q = mysqli_query($con,$sql);
		$col_pts = 0;
		if (mysqli_num_rows($q) > 0) {
			$row = mysqli_fetch_assoc($q);
			$col_pts = $row['pts'];//mysqli_fetch_assoc($q, 0, "pts");
		}

		return $col_pts;
	}

	function getTotal_deduct_point($contact_no)
	{
		$parent_contact_no = find_parent_contact_no($contact_no);
		if($parent_contact_no == 0)
		{
			return 0;
		}

		$sql = "SELECT SUM(points) as pts FROM data_customer_points WHERE parent_contact_no = '".$parent_contact_no."' AND active = 1 and point_type='0'";
		$con = getdb();
		$q = mysqli_query($con,$sql);
		$col_pts = 0;
		if (mysqli_num_rows($q) > 0) {
			$row = mysqli_fetch_assoc($q);
			$col_pts = $row['pts'];//mysqli_fetch_assoc($q, 0, "pts");
		}

		return $col_pts;
	}

	function getTotal_point($contact_no)
	{
		$add_point = getTotal_add_point($contact_no);
	
		$deduct_point = getTotal_deduct_point($contact_no);
		
		$balance_point = $add_point - $deduct_point;
		
		return $balance_point;
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
		$con = getdb();

		if ($VoucherCode == "") {
			$VoucherCode = strtoupper(izrand());
		}
		$VoucherCode = "*".$VoucherCode."*";
		$SqlVou_Select = "SELECT * FROM data_voucher_cust WHERE voucher_code = '".$VoucherCode."' LIMIT 1 ";
		$RstVou_Select = mysqli_query($con,$SqlVou_Select);
		if (mysqli_num_rows($RstVou_Select) > 0) {
			$VoucherCode = getRandVoucher();
		}

		return $VoucherCode;
	}

	

	if ( $DWUserContact != "" && $DWVoucherInfoID > 0 ) {

		$con = getdb();

		
		///////////UNTUK TAHU POINT CUSTOMER//////////////////
		$DWCustPoint = 0;
		$SqlCust_Select = "SELECT d.* FROM data_customer d WHERE d.active > 0 AND d.contact_no = '".$DWUserContact."' LIMIT 1";
		$RstCust_Select = mysqli_query($con,$SqlCust_Select);

		if (mysqli_num_rows($RstCust_Select) > 0) {
			$DWCustPoint = getTotal_point($DWUserContact);
		}
		$MainData["POINT"] = $DWCustPoint;
		///////////UNTUK TAHU POINT CUSTOMER//////////////////

		///////////////SAMPAI SINI DAH OKAY//////////////////////

		$SqlInfo_Select = "SELECT v.* FROM data_voucher_cust v WHERE v.id = '".$DWVoucherCustID."' AND v.voucher_id = '".$DWVoucherInfoID."' AND v.voucher_code = '".$DWVoucherCodeID."' AND v.voucher_status = 1 ";
		$RstInfo_Select = mysqli_query($con,$SqlInfo_Select);

		if (mysqli_num_rows($RstInfo_Select) > 0) {
			while ($InfoData = mysqli_fetch_assoc($RstInfo_Select)) {

				$con = getdb();

				$SqlVoucher_Update = "UPDATE data_voucher_cust SET voucher_status = 0, redeem_date = NOW() WHERE id = '".$DWVoucherCustID."' ";
				// echo $SqlVoucher_Update;
				// die();
				$RstDeduct_Update = mysqli_query($con,$SqlVoucher_Update);

			}

			$MainData["status"] = "1";
			$MainData["status_message"] = "Successfully use voucher";
		} else {
			$MainData["status"] = "2";
			$MainData["status_message"] = "Insufficient points to claim voucher";
		}
		
	} else {
		$MainData["ACCOUNT_IMAGE"] = "http://810speedmart.com/api/images/member_login_2.png";
		$MainData["status"] = "0";
		$MainData["status_message"] = "Need Login";
	}
	
	echo json_encode($MainData);
	exit;
?>