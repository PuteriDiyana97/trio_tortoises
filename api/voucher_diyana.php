<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/voucher.txt'.date("Y-m-d").'.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://stargloryasia.com/".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************

		Query Function & Print JSON Data
		810 Member Voucher API
		Sample URL: http://810speedmart.com/api/voucher.php?contactno=[CONTACTNO or '' (EMPTY)]

		Return Info

	****************************************************************** */
	$DWUserContact = ReturnValidContact($_REQUEST["contactno"]);

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

	///////////UNTUK TAHU POINT CUSTOMER//////////////////
	$con = getdb();
	mysqli_set_charset($con, "utf8");
	$group_id = find_group_id($DWUserContact);
	$DWCustPoint = 0;
	$SqlCust_Select = "SELECT d.* FROM data_customer d WHERE d.active > 0 AND d.group_id = '".$group_id."'";
	$RstCust_Select = mysqli_query($con,$SqlCust_Select);

	if (mysqli_num_rows($RstCust_Select) > 0) {
		$DWCustPoint = getGroup_point($DWUserContact);
	}
	else{
		$DWCustPoint = getIndividual_point($DWUserContact);
	}
	///////////UNTUK TAHU POINT CUSTOMER//////////////////

	$Sql_Select = "SELECT v.* FROM data_voucher v WHERE v.active = 1 AND v.exchange_point > 0 AND v.voucher_type = 0 AND 
	(DATE(v.start_date) <= '".date("Y-m-d")."' AND DATE(v.end_date) >= '".date("Y-m-d")."')  
	ORDER BY v.created DESC";
	$Rst_Select = mysqli_query($con,$Sql_Select);
	
	if(mysqli_num_rows($Rst_Select) > 0)
		while($row = mysqli_fetch_array($Rst_Select)) {

		$data['voucher_id'] = $row["id"]; 
		$data['voucher_name'] 		  = $row["voucher_name"]; 
		$data['description'] 		  = str_replace("\r\n", "<br>", $row["description"]); 
		$data['voucher_value']  = $row["voucher_value"]; 
		$data['voucher_img_before'] = $_URL."assets/upload_files/voucher/". $row["voucher_img_before"];
		$data['start_date']   = $row["start_date"];
		$data['end_date']  = $row["end_date"]; 
		$data['exchange_point'] = $row["exchange_point"]; //0:not publish 1:published

		$rowAll[] = $data;
		$status = 1;
		$status_message = 'Success display voucher details.';
		$firstpage = '/tabs/home' ;

	}else{

		$rowAll[] = ''; 
		$status   = 0;
		$status_message = 'No data found';
		$firstpage = '' ;

	}

	////////////////UNTUK myVoucher//////////////////////

	$con = getdb();
	mysqli_set_charset($con, "utf8");
	// $Sql_SelectVoucher = "SELECT vc.*, v.*, vc.id as voucher_customer_id FROM data_voucher_cust vc LEFT JOIN data_voucher v ON (v.id = vc.voucher_id) WHERE vc.contact_no = '".$DWUserContact."' ORDER BY vc.claim_date DESC";
	// $Rst_SelectVoucher = mysqli_query($con,$Sql_SelectVoucher);

	// $Sql_SelectVoucherCount = "SELECT vc.*, v.*, vc.id as voucher_customer_id FROM data_voucher_cust vc LEFT JOIN data_voucher v ON (v.id = vc.voucher_id) WHERE vc.contact_no = '".$DWUserContact."' AND vc.voucher_status = 1 ORDER BY vc.claim_date DESC";
	// $Rst_SelectVoucherCount = mysqli_query($con,$Sql_SelectVoucherCount);
	// $myVoucher_count = mysqli_num_rows($Rst_SelectVoucherCount);

	$Sql_SelectVoucher = "SELECT vc.*, v.*, vc.id as voucher_customer_id FROM data_voucher_cust vc LEFT JOIN data_voucher v ON (v.id = vc.voucher_id) WHERE vc.contact_no = '".$DWUserContact."' AND 
	(DATE(v.start_date) <= '".date("Y-m-d")."' AND DATE(v.end_date) >= '".date("Y-m-d")."') ORDER BY vc.claim_date DESC";
	$Rst_SelectVoucher = mysqli_query($con,$Sql_SelectVoucher);

	$Sql_claimVoucher = "SELECT vc.*, v.*, vc.id as voucher_customer_id FROM data_voucher_cust vc LEFT JOIN data_voucher v ON (v.id = vc.voucher_id) WHERE vc.contact_no = '".$DWUserContact."' AND vc.voucher_status = 1 AND 
	(DATE(v.start_date) <= '".date("Y-m-d")."' AND DATE(v.end_date) >= '".date("Y-m-d")."') ORDER BY vc.claim_date DESC";
	$Rst_claimVoucher = mysqli_query($con,$Sql_claimVoucher);

	$Sql_SelectVoucherCount = "SELECT vc.*, v.*, vc.id as voucher_customer_id FROM data_voucher_cust vc LEFT JOIN data_voucher v ON (v.id = vc.voucher_id) WHERE vc.contact_no = '".$DWUserContact."' AND vc.voucher_status = 1 AND 
	(DATE(v.start_date) <= '".date("Y-m-d")."' AND DATE(v.end_date) >= '".date("Y-m-d")."')
	ORDER BY vc.claim_date DESC";
			$myVoucher_count = mysqli_num_rows($Rst_claimVoucher);

			if (empty(($myVoucher_count) || $myVoucher_count == 0 || $myVoucher_count ="")) {
				$myVoucher_count = 0;
			}
			else{
				$myVoucher_count = $myVoucher_count;
			}

	if(mysqli_num_rows($Rst_SelectVoucher) > 0){
		while($row = mysqli_fetch_array($Rst_SelectVoucher)) {

		$dataVoucher['voucher_id'] = $row["voucher_id"]; 
		$dataVoucher['voucher_customer_id'] = $row["voucher_customer_id"]; 
		$dataVoucher['voucher_name'] 		  = $row["voucher_name"]; 
		$dataVoucher['description'] 		  = str_replace("\r\n", "<br>", $row["description"]); 
		$dataVoucher['voucher_value']  = $row["voucher_value"]; 
		$dataVoucher['voucher_img_before'] = $_URL."assets/upload_files/voucher/". $row["voucher_img_before"];
		$dataVoucher['voucher_img_after'] = $_URL."assets/upload_files/voucher/". $row["voucher_img_after"];
		$dataVoucher['start_date']   = $row["start_date"];
		$dataVoucher['end_date']  = $row["end_date"]; 
		// $dataVoucher['exchange_point'] = $row["exchange_point"]; //0:not publish 1:published
		$dataVoucher['voucher_code']  = $row["voucher_code"]; 
		$dataVoucher['barcode'] = $_URL."api/barcode.php?size=30&text=". $row["voucher_code"]."&print=true";
		$dataVoucher['voucher_status']  = $row["voucher_status"]; 

		$rowAllVoucher[] = $dataVoucher;

		
		$status = 1;
		$status_message = 'Success display voucher details.';
		$firstpage = '/tabs/home' ;
		}
	}else{

		$rowAllVoucher[] = ''; 
		$status   = 0;
		$status_message = 'You have not claimed any voucher yet at the moment';
		$firstpage = '' ;

	}

	////////////////UNTUK myVoucher//////////////////////

	$MainData["VOUCHER"] = $rowAll;
	$MainData["myVoucher"] = $rowAllVoucher;
	$MainData["count_voucher"] = $myVoucher_count;
	$MainData["firstpage"] = $firstpage;
	$MainData["status"] = $status;
	$MainData["status_message"] = $status_message;
	$MainData["POINT"] = $DWCustPoint;
			
	echo json_encode($MainData);
	exit;


//////////////////////////////////////////



/*
	Add Voucher Claim Option NI UNTUK MYVOUCHER
*/
// $SqlVou_Select = "SELECT v.*, i.info_validity_from, i.info_validity_to, i.info_value, i.redeem_image, i.redeem_image_used, i.redeem_image_header, i.redeem_tnc FROM `data_voucher` v INNER JOIN `data_voucher_info` i ON (i.id=v.info_id AND i.active=1) WHERE i.allow_claim = 0 AND i.info_validity_from <= '".date("Y-m-d")."' AND i.info_validity_to >= '".date("Y-m-d")."' AND v.active IN (1,2) AND v.customer_id = '".$DWCustID."' ORDER BY v.active, i.info_display_from ";
// $RstVou_Select = mysql_query($SqlVou_Select);
// while ($VouData = mysql_fetch_assoc($RstVou_Select)) {
// 	$MyData["id"] = $VouData["id"];
// 	$MyData["active"] = $VouData["active"];
// 	if ( $VouData["active"] == 2 ) {
// 		$MyData["image"] = $VouData["redeem_image_used"];
// 		$MyData["id"] = 0;
// 	} else {
// 		$MyData["image"] = $VouData["redeem_image"];
// 	}
// 	$MyData["image_detail"] = $VouData["redeem_image_header"];
// 	$MyData["image_barcode"] = "http://sys.senheng.com.my/senhengmobile/senhengapps/cms/php-barcode/barcode.php?size=45&text=".$VouData["voucher_code"]."&print=false";
// 	$MyData["image_barcode_v"] = "http://sys.senheng.com.my/senhengmobile/senhengapps/cms/php-barcode/barcode.php?size=45&text=".$VouData["voucher_code"]."&print=true";
// 	$MyData["image_detail_tnc"] = $VouData["redeem_tnc"];
// 	$MainData["VOUCHER_MY"][] = $MyData;
// }
//////////////////////////////////////////////////////
?>



