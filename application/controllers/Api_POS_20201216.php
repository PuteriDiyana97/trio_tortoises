<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_POS extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('');
		error_reporting (E_WARNING);
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
	}

	function ReturnValidContact($DWCustContact) {
		$DWCustContact = str_replace(array(" ", "-", ".", ",", "+"), "", $DWCustContact);
		if ( substr($DWCustContact, 0, 1) != "6" ) {
			$DWCustContact = "6".$DWCustContact;
		}

		if ( substr($DWCustContact, 0, 4) == "6060" ) {
			$DWCustContact = substr($DWCustContact, 2);
		}
		return $DWCustContact;
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
		if ($VoucherCode == "") {
			$VoucherCode = strtoupper(izrand());
		}
		$VoucherCode = "*".$VoucherCode."*";
		$SqlVou_Select = "SELECT * FROM data_voucher WHERE voucher_code = '".$VoucherCode."' LIMIT 1 ";
		$RstVou_Select = mysql_query($SqlVou_Select);
		if (mysql_num_rows($RstVou_Select) > 0) {
			$VoucherCode = getRandVoucher();
		}

		return $VoucherCode;
	}


	function PointCal($DWTotal) {
		if ( $DWTotal > 0 ) {
			$DWTotalPoint = round($DWTotal, 0);
		} else {
			$DWTotalPoint = round($DWTotal * -1, 0);
		}
		return $DWTotalPoint;
	}

	function PointDisplay($DWTotal, $DWActive) {
		return $DWTotal;
	}

	function DWPriceLevel($DWPriceLevel) {
		if ( $DWPriceLevel == 0 ) {
			return "";
		} else {
			return "4.MB";
		}
	}


	function getIndividual_add_point($contact_no)
	{
		//$sql = "SELECT SUM(points) as pts FROM data_customer_points WHERE contact_no = '".$contact_no."' AND active = 1 and point_type='1'";
		$db = $this->db;
		$db->select('SUM(points) as pts');
		$db->where('contact_no',$contact_no);
		$db->where('active',1);
		$db->where('point_type',1);
		$q = $db->get('data_customer_points')->row();
		// $con = getdb();
		// $q = mysqli_query($con,$sql);
		// $q = $this->db->query($sql);
		$col_pts = 0;
		if (!empty($q)){
			// $row = mysqli_fetch_assoc($q);
			$col_pts = $q->pts;//mysqli_fetch_assoc($q, 0, "pts");
		}

		return $col_pts;
	}

	function getIndividual_deduct_point($contact_no)
	{
		//$sql = "SELECT SUM(points) as pts FROM data_customer_points WHERE contact_no = '".$contact_no."' AND active = 1 and point_type='0'";
		// $con = getdb();
		// $q = mysqli_query($con,$sql);
		//$q = $this->db->query($sql);
		$db = $this->db;
		$db->select('SUM(points) as pts');
		$db->where('contact_no',$contact_no);
		$db->where('active',1);
		$db->where('point_type',0);
		$q = $db->get('data_customer_points')->row();
		$col_pts = 0;
		if (!empty($q)){
			// $row = mysqli_fetch_assoc($q);
			$col_pts = $q->pts;//mysqli_fetch_assoc($q, 0, "pts");
		}

		return $col_pts;
	}

	function getIndividual_point($contact_no)
	{
		$individual_add_point = $this->getIndividual_add_point($contact_no);

		$individual_deduct_point = $this->getIndividual_deduct_point($contact_no);
		
		$balance_point = $individual_add_point - $individual_deduct_point;
		
		return $balance_point;
	}

	public function member_data(){

	/* ******************************************************************

		Write Request Data to Server

		****************************************************************** */
		$req_dump = print_r($_REQUEST, TRUE);
		$fp = fopen('logs/customer_data_'.date("Y-m-d").'.txt', 'a');
		fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://www.starglorygroup.com/admin_sg/".$_SERVER['REQUEST_URI']."\n".$req_dump);
		fclose($fp);


		$DWAPIKey = $_REQUEST["apikey-access"];
		$DWCustomerData = json_decode($_REQUEST["customer"]);

		if ( $DWAPIKey != "apistarglory:lTL0FraU!QzSTM2^XN" ) {
			$ReturnData["status"] = -2;
			$ReturnData["status_message"] = "Wrong API Key";

			echo json_encode($ReturnData);
			exit;
		}

		if ( count($DWCustomerData) > 0 ) {
			for ($i=0; $i<count($DWCustomerData); $i++) {
    		//
    		// Only pass Paid Member Data to Qube , Free Member not pass
				$db = $this->db;
				$db->select('*');
				$db->where('contact_no',$DWCustomerData[$i]->id);
				$db->where('active <>',0);
				$customer = $db->get('data_customer')->row();

				if ( !empty($customer) && count($customer) > 0 ) {

					$RowData["id"] = $customer->contact_no;
					$RowData["birthday"] = date("m/d/Y", strtotime($customer->date_of_birth));

					$RowData["created"] = date("m/d/Y", strtotime($customer->created));
					$RowData["point"] = $customer->point;
					$RowData["active"] = $customer->active;

					$RowData["active_message"] = "This member is not activated yet, please proceed with member fee payment. Thank you.";

					$RowData["status"] = 1;
					$RowData["status_message"] = "Request done";
					$RowData["pricelevel"] = DWPriceLevel($customer->pricelevel);

					$ReturnData[] = $RowData;

				} else {
					$APIData["status"] = 0;
					$APIData["status_message"] = "Error ID";
					$APIData["id"] = $DWCustomerData[$i]->id;

					$ReturnData[] = $APIData;
				}
			}
		}

		echo json_encode($ReturnData);
		exit;
	}

	public function member_register_check(){

    /* ******************************************************************

		Write Request Data to Server

		****************************************************************** */
		$req_dump = print_r($_REQUEST, TRUE);
		$fp = fopen('logs/customer_register_check_'.date("Y-m-d").'.txt', 'a');
		fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://www.starglorygroup.com/admin_sg/".$_SERVER['REQUEST_URI']."\n".$req_dump);
		fclose($fp);

		$DWAPIKey = $_REQUEST["apikey-access"];
		$DWCustomerData = json_decode($_REQUEST["customer"]);

		if ( $DWAPIKey != "apistarglory:lTL0FraU!QzSTM2^XN" ) {
			$ReturnData["status"] = -2;
			$ReturnData["status_message"] = "Wrong API Key";

			echo json_encode($ReturnData);
			exit;
		}

		if ( count($DWCustomerData) > 0 ) {
			for ($i=0; $i<count($DWCustomerData); $i++) {

				$DWUserContact = $DWCustomerData[$i]->id;
    		//
				$db = $this->db;
				$db->select('*');
				$db->where('contact_no',$DWCustomerData[$i]->id);
				$db->where('vouchercode IS NOT NULL',NULL, FALSE);
				$customer = $db->get('data_customer')->row();

				if ( !empty($customer) && count($customer) > 0 ) {

					$RowData["id"] = $customer->contact_no;
					$RowData["birthday"] = date("m/d/Y", strtotime($customer->date_of_birth));

					$RowData["created"] = date("m/d/Y", strtotime($customer->created));
					$RowData["point"] = $RowData["point"];

                    // Not Allow Register
					$RowData["status"] = 0;
					$RowData["status_message"] = "Not Allow to Register";

					$ReturnData[] = $RowData;

				} else {

                // Allow Register
					$APIData["status"] = 1;
					$APIData["status_message"] = "Allow to Register";
					$APIData["id"] = $DWUserContact;

					$ReturnData[] = $APIData;
				}
			}
		}

		echo json_encode($ReturnData);
		exit;

	}


	public function member_register(){

    /* ******************************************************************

		Write Request Data to Server

		****************************************************************** */
		$req_dump = print_r($_REQUEST, TRUE);
		$fp = fopen('logs/customer_register_new_'.date("Y-m-d").'.txt', 'a');
		fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://www.starglorygroup.com/admin_sg/".$_SERVER['REQUEST_URI']."\n".$req_dump);
		fclose($fp);

		$DWAPIKey = $_REQUEST["apikey-access"];

		$DWRegisterData = json_decode($_REQUEST["registration"]);

		if($DWAPIKey != "apistarglory:lTL0FraU!QzSTM2^XN" ) {

			$Member["status"] = -2;
			$Member["status_message"] = "Wrong API Key";

			$ReturnData[] = $Member;

			echo json_encode($ReturnData);
			exit;
		}


		if(!empty($DWRegisterData)){
		if ( count($DWRegisterData) > 0 ) {
			for ($i=0; $i<count($DWRegisterData); $i++) {

				$DWUserContact = $DWRegisterData[$i]->tel;


				if ( !empty($DWRegisterData[$i]->tel) ) {
					$active = array('1','2');
					$db = $this->db;
					$db->select('*');
					$db->where('contact_no',$DWUserContact);
					$db->where_in('active',$active);
					$customer = $db->get('data_customer')->row();

					if ( !empty($customer) ) {


						$DWExtraQuery = "";
						if ( !empty($DWRegisterData[$i]->email) ) {
							$DWExtraQuery = " , email = '".$DWRegisterData[$i]->email."' ";
							$DWExtraQuery1 = " email => '".$DWRegisterData[$i]->email."' ";
						}

						if($DWRegisterData[$i]->membership_type == 'SGS'){

							$membership_type = '2';


						}else if($DWRegisterData[$i]->membership_type == 'SGG'){

							$membership_type = '3';

						}else if($DWRegisterData[$i]->membership_type == 'SGV'){

							$membership_type = '4';

						}else{

							$membership_type = '1';

						}



						$SqlCust_Update = "UPDATE `data_customer` SET name = '".$DWRegisterData[$i]->name."' ".$DWExtraQuery." , address = '".$DWRegisterData[$i]->addr1."', city = '".$DWRegisterData[$i]->city."',state = '".$DWRegisterData[$i]->state."', country = '".$DWRegisterData[$i]->country."',	zipcode = '".$DWRegisterData[$i]->zipcode."', date_of_birth = '".date("Y-m-d", strtotime($DWRegisterData[$i]->birthday))."', ic_no = '".$DWRegisterData[$i]->nric."', gender = '".$DWRegisterData[$i]->gender."',race = '".$DWRegisterData[$i]->race."',customer_type = '".$membership_type."',updated = NOW() WHERE contact_no = '".$DWUserContact."' ";
						$RstCust_Update = $this->db->query($SqlCust_Update);

						$APIData["status"] = 1;
						$APIData["status_message"] = "Done Update";
						$APIData["id"] = $DWRegisterData[$i]->tel;

						$ReturnData[] = $APIData;

					} else {


						if($DWRegisterData[$i]->membership_type == 'SGS'){

							$membership_type = '2';


						}else if($DWRegisterData[$i]->membership_type == 'SGG'){

							$membership_type = '3';

						}else if($DWRegisterData[$i]->membership_type == 'SGV'){

							$membership_type = '4';

						}else{

							$membership_type = '1';

						}

						$SqlCust_Insert = "INSERT INTO `data_customer` (name, contact_no,profile_picture, email, address, city, state, country,zipcode, date_of_birth, ic_no, gender,race,customer_type, updated, created, active) VALUES ('".$DWRegisterData[$i]->name."', '".$DWUserContact."','default-profile.png', '".$DWRegisterData[$i]->email."', '".$DWRegisterData[$i]->addr1."', '".$DWRegisterData[$i]->city."', '".$DWRegisterData[$i]->state."', '".$DWRegisterData[$i]->country."','".$DWRegisterData[$i]->zipcode."', '".date("Y-m-d", strtotime($DWRegisterData[$i]->birthday))."', '".$DWRegisterData[$i]->nric."', '".$DWRegisterData[$i]->gender."', '".$DWRegisterData[$i]->race."','".$membership_type."','".date("Y-m-d", strtotime($DWRegisterData[$i]->created))."', NOW(), 1) ";
						$RstCust_Insert = $this->db->query($SqlCust_Insert);
						$DWCustID = $this->db->insert_id();

						$SqlPoint_Insert = "INSERT INTO data_customer_points (contact_no, points, group_id, point_type, description, transaction_date, created, active) VALUES ('".$DWUserContact."', 300, NULL, 1, 'Welcome Point', NOW(), NOW(), 1)  ";
						$RstPoint_Insert = $this->db->query($SqlPoint_Insert);


						$APIData["status"] = 1;
						$APIData["status_message"] = "Done Insert";
						$APIData["id"] = $DWRegisterData[$i]->tel;

						$ReturnData[] = $APIData;
					}
				} else {
					$APIData["status"] = 0;
					$APIData["status_message"] = "Error ID";
					$APIData["id"] = $DWRegisterData[$i]->tel;

					$ReturnData[] = $APIData;
				}


			}
		} else {
			$APIData["status"] = -1;
			$APIData["status_message"] = "Not Data Pass";
			$APIData["id"] = $DWRegisterData[$i]->tel;

			$ReturnData[] = $APIData;
		}


	}else{

		    $APIData["status"] = -1;
			$APIData["status_message"] = "Not Data Pass";
			$APIData["id"] = $DWRegisterData[$i]->tel;

			$ReturnData[] = $APIData;

	}


		echo json_encode($ReturnData);
		exit;
	}

	public function sales_transaction_detail(){

		$req_dump = print_r($_REQUEST, TRUE);
		$fp = fopen('logs/sales_transaction_detail'.date("Y-m-d").'.txt', 'a');
		fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://www.starglorygroup.com/admin_sg/".$_SERVER['REQUEST_URI']."\n".$req_dump);
		fclose($fp);


		$DWAPIKey = $_REQUEST["apikey-access"];
		$DWProductData = json_decode(str_replace(array("'"), "", $_REQUEST["salesdtl"]));


		if ( $DWAPIKey != "apistarglory:lTL0FraU!QzSTM2^XN" ) {
			$Key["status"] = -2;
			$Key["status_message"] = "Wrong API Key";

			$ReturnData[] = $Key;

			echo json_encode($ReturnData);
			exit;
		}

		if ( count($DWProductData) > 0 ) {
			for ($i=0; $i<count($DWProductData); $i++) {
				$DWProductData[$i]->trxdate = date("Y-m-d H:i:s", strtotime($DWProductData[$i]->trxdate));

				$DWTranID = 0;

				$db = $this->db;
				$db->select('*');
				$db->where('trxnum',$DWProductData[$i]->trxnum);
				$data_st = $db->get('data_sales_transaction')->row();

				if(!empty($data_st)){

					$DWTranID = $data_st->id;

				}

				$db = $this->db;
				$db->select('*');
				$db->where('trxnum',$DWProductData[$i]->trxnum);
				$db->where('seq',$DWProductData[$i]->seq);
				$data_sales = $db->get('data_sales_transaction_detail')->row();

				if(!empty($data_sales) ){

					$DWDetailID = $data_sales->detail_id;


					$data = array(

						"sbclient_id" => $DWProductData[$i]->id,
						"outlet"      => $DWProductData[$i]->outlet,
						"trxdate"     => date("Y-m-d H:i:s", strtotime($DWProductData[$i]->trxdate)),
						"trxnum"      => $DWProductData[$i]->trxnum,
						"plucode"     => $DWProductData[$i]->plucode,
						"barcode"     => $DWProductData[$i]->barcode,
						"description" => $DWProductData[$i]->desc,
						"qty"         => $DWProductData[$i]->qty,
						"netprice"    => $DWProductData[$i]->netprice,
						"category"    => $DWProductData[$i]->category,
						"updated"     => getDateTime(),
					);

					$q = $this->db->where('detail_id',$DWDetailID)->update('data_sales_transaction_detail', $data);


					$DWProductData[$i]->status = "1";

				} else {

					$data = array(

						"sales_transaction_id" => $DWTranID,
						"sbclient_id"          => $DWProductData[$i]->id,
						"outlet"               => $DWProductData[$i]->outlet,
						"trxdate"              => date("Y-m-d H:i:s", strtotime($DWProductData[$i]->trxdate)),
						"trxnum"               => $DWProductData[$i]->trxnum,
						"seq"                  => $DWProductData[$i]->seq,
						"plucode"              => $DWProductData[$i]->plucode,
						"barcode"              => $DWProductData[$i]->barcode,
						"description"          => $DWProductData[$i]->desc,
						"qty"                  => $DWProductData[$i]->qty,
						"netprice"             => $DWProductData[$i]->netprice,
						"category"             => $DWProductData[$i]->category,
						"updated"              => getDateTime(),
						"created"              => getDateTime(),
						"active"               => 1,
					);

					$q = $this->db->insert('data_sales_transaction_detail', $data);

					$DWProductData[$i]->status = "1";
				}

				unset($DWProductInfo);
				$DWProductInfo["status"] = $DWProductData[$i]->status;
				$DWProductInfo["status_message"] = "DONE";
				$DWProductInfo["trxnum"] = $DWProductData[$i]->trxnum;
				$DWReturn[] = $DWProductInfo;
			}
		}else{

			$DWProductInfo["status"] = '0';
			$DWProductInfo["status_message"] = "Failed";

			$DWReturn[] = $DWProductInfo;

		}

		echo json_encode($DWReturn);
		exit;


	}

	public function sales_transaction(){


		/*	****************************************************************** */
		$req_dump = print_r($_REQUEST, TRUE);
		$fp = fopen('logs/sales_transaction_'.date("Y-m-d").'.txt', 'a');
		fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://www.starglorygroup.com/admin_sg/".$_SERVER['REQUEST_URI']."\n".$req_dump);
		fclose($fp);



		$DWAPIKey = $_REQUEST["apikey-access"];



	// Sales Trasaction
	// if minus value = refund
		$DWSalesData = json_decode($_REQUEST["sales"]);

	// Redemption
	// Once got Redeem, deduct point for Customer ID
	//$DWRedeemData = json_decode($_REQUEST["Redeem"]);

	// Transaction Void
	// Once got void, deduct trx for Customer ID with Trn Number
		$DWVoidData = json_decode($_REQUEST["void"]);

	// Member Fees
	// Once got void, deduct trx for Customer ID with Trn Number
	//$DWFeesData = json_decode($_REQUEST["fees"]);

		if ( $DWAPIKey != "apistarglory:lTL0FraU!QzSTM2^XN" ) {
			$Sales["status"] = -2;
			$Sales["status_message"] = "Wrong API Key";
			$ReturnData[] = $Sales;
			echo json_encode($ReturnData);
			exit;
		}
		  if(!empty($DWSalesData)){
		if ( count($DWSalesData) > 0 ) {
			for ($i=0; $i<count($DWSalesData); $i++) {

				if ( !empty($DWSalesData[$i]->trxnum) ) {


					$db = $this->db;
					$db->select('*');
					$db->where('contact_no',$DWSalesData[$i]->id);
					$db->where('active',1);
					$data_cust = $db->get('data_customer')->row();

					if ( empty($data_cust) && $data_cust == 0 ) {

					}


					$db = $this->db;
					$db->select('*');
					$db->where('trxnum',$DWSalesData[$i]->trxnum);
					$db->where('active',1);
					$data_st = $db->get('data_sales_transaction')->row();

					if ( !empty($data_st) ) {


						$APIData["status"] = 1;
						$APIData["status_message"] = "Transaction Already Exist";
						$APIData["id"] = $DWSalesData[$i]->id;
						$APIData["trxnum"] =$DWSalesData[$i]->trxnum;
						$APIData["type"] = 'Sales';
						$ReturnData[] = $APIData;
					} else {


						$data = array(

							"sbclient_id" => $DWSalesData[$i]->id,
							"trxdate"     => date("Y-m-d H:i:s", strtotime($DWSalesData[$i]->trxdate)),
							"trxnum"      => $DWSalesData[$i]->trxnum,
							"trxtotal"    => $DWSalesData[$i]->trxtotal,
							"updated"     => getDateTime(),
							"created"     => getDateTime(),
							"active"      => '1',
						);

						$q = $this->db->insert('data_sales_transaction', $data);
						$DWSalesTranID = $this->db->insert_id();

                        // Select Previous Redeem Voucher
						$DWTotalVoucherValue = 0;
						$DWDeductPoint = 0;
                        //echo "<br />".
						$db = $this->db;
						$db->select('*');
						$db->where('trxnum',$DWSalesData[$i]->trxnum);
						$db->where('adjustment',0);
						$db->where('active',5);
						$data_st = $db->get('data_sales_transaction')->result();

						foreach ($data_st as $ds) {

							$DWTotalVoucherValue += $ds->trxtotal;

							$data = array(

								"adjustment"  => 1,

							);

							$q = $this->db->where('id',$ds->id)->update('data_sales_transaction', $data);



						}
						if ( $DWTotalVoucherValue > 0 ) {

							if ( $DWTotalVoucherValue > $DWSalesData[$i]->trxtotal ) {
								$DWDeductPoint = round($DWSalesData[$i]->trxtotal);
							} else {
								$DWDeductPoint = round($DWTotalVoucherValue);
							}

						}

						if ( $DWSalesData[$i]->trxtotal > 0 ) {
							$DWPoint = $this->PointCal($DWSalesData[$i]->trxtotal);
							$DWExQuery = " point = point + ".($DWPoint - $DWDeductPoint)." ";
							$DWExQuery2 = " point => point + ".($DWPoint - $DWDeductPoint)." ";

							$data = array(

								"trxpoint_desc"  => '+ '.($DWPoint - $DWDeductPoint).' pts',

							);

							$q = $this->db->where('id',$DWSalesTranID)->update('data_sales_transaction', $data);


							$status_point = '1';
							$point_user = $DWPoint - $DWDeductPoint;


						} else {
							$DWPoint = $this->PointCal($DWSalesData[$i]->trxtotal);
							$DWExQuery = " point = point - ".($DWPoint - $DWDeductPoint)." ";
							$DWExQuery2 = " point => point - ".($DWPoint - $DWDeductPoint)." ";

							$data = array(

								"trxpoint_desc"  => '- '.($DWPoint - $DWDeductPoint).' pts',

							);

							$q = $this->db->where('id',$DWSalesTranID)->update('data_sales_transaction', $data);



							$status_point = '0';
							$point_user = $DWPoint - $DWDeductPoint;
						}


						$data_point = array(

							"contact_no"        => $DWSalesData[$i]->id,
							"group_id"          => '',
							"points"            => $point_user,
							"point_type"        => $status_point,
							"description"       => 'Sales for '.$DWSalesData[$i]->trxnum,
							"transaction_date"  => date("Y-m-d H:i:s", strtotime($DWSalesData[$i]->trxdate)),
							"created"           => getDateTime(),
							"active"            => '1',

						);

						$insert_data_customer_points = $this->db->insert('data_customer_points', $data_point);

						$SqlCustPoint_Update = "UPDATE `data_customer` SET ".$DWExQuery." WHERE contact_no = '".$DWSalesData[$i]->id."' AND active = 1 ";
						$RstCustPoint_Update = $this->db->query($SqlCustPoint_Update);

						$notification_title       = 'Sales for '.$DWSalesData[$i]->trxnum;
						$notification_short       = 'Sales for '.$DWSalesData[$i]->trxnum;
						$notification_long        = 'Sales for '.$DWSalesData[$i]->trxnum;
						$notification_image       = "";
						$notification_url         = "";

						$data_notification = array(

							"notification_id"    => $DWSalesTranID,
							"notification_title" => $notification_title,
							"short_description"  => $notification_short,
							"long_description"   => $notification_long,
							"notification_image" => $notification_image,
							"url"                => $notification_url,
							"start_date"         => getTodayDate(),
							"end_date"           => getTodayDate(),
							"created"            => getDateTime(),
							"updated"            => getDateTime(),
							"active"             => '1',
							"contact_no"         => $DWSalesData[$i]->id,

						);

						$insert_data_customer_points = $this->db->insert('notification_receiver', $data_notification);
						$APIData["status"] = 1;
						$APIData["status_message"] = "Done Insert";
						$APIData["trxnum"]         = $DWSalesData[$i]->trxnum;
						$APIData["id"] = $DWSalesData[$i]->id;
						$APIData["type"] = 'Sales';
						$ReturnData[] = $APIData;
					}
				} else {

					$APIData["status"] = 0;
					$APIData["status_message"] = "Error trxnum";
					$APIData["id"] = $DWSalesData[$i]->id;
					$APIData["trxnum"]         = $DWSalesData[$i]->trxnum;
					$APIData["type"] = 'Sales';

					$ReturnData[] = $APIData;
				}
			}
		} else {

		}
}


	


        if(!empty($DWVoidData)){
		if ( count($DWVoidData) > 0 ) {
			for ($i=0; $i<count($DWVoidData); $i++) {
				if ( !empty($DWVoidData[$i]->trxnum) ) {

					$db = $this->db;
					$db->select('*');
					$db->where('trxnum',$DWVoidData[$i]->trxnum);
					$db->where('active',3);
					$void = $db->get('data_sales_transaction')->row();

					if ( !empty($void)) {
						$APIData["status"] = 1;
						$APIData["status_message"] = "Transaction Already Exist";
						$APIData["id"] = $DWVoidData[$i]->id;
						$APIData["trxnum"] =  $DWVoidData[$i]->trxnum;
						$APIData["type"] = 'Void';
						$ReturnData[] = $APIData;
					} else {

						$data = array(

							"sbclient_id"  => $DWVoidData[$i]->id,
							"trxdate"      => date("Y-m-d H:i:s", strtotime($DWVoidData[$i]->trxdate)),
							"trxnum"       => $DWVoidData[$i]->trxnum,
							"trxpoint"     => $DWVoidData[$i]->trxtotal,
							"updated"      => getDateTime(),
							"created"      => getDateTime(),
							"active"       => 3,
							
						);

						$q = $this->db->insert('data_sales_transaction', $data);
						$DWSalesTranID = $this->db->insert_id();

						$DWPoint = $this->PointCal($DWVoidData[$i]->trxtotal);
						$DWExQuery = " point = point - ".$DWPoint." ";
						$DWExQuery2 = " point => point - ".$DWPoint." ";

						$data = array(

							"trxpoint_desc"  => '- '.($DWPoint).' pts',
							
						);

						$q = $this->db->where('id',$DWSalesTranID)->update('data_sales_transaction', $data);

						$SqlCustPoint_Update = "UPDATE `data_customer` SET ".$DWExQuery." WHERE contact_no = '".$DWVoidData[$i]->id."' AND active = 1 ";
						$RstCustPoint_Update = $this->db->query($SqlCustPoint_Update);

						$data_point = array(

							"contact_no"        => $DWVoidData[$i]->id,
							"group_id"          => '',
							"points"            => $DWPoint,
							"point_type"        => '0',
							"description"       => 'Void for '.$DWVoidData[$i]->trxnum,
							"transaction_date"  => date("Y-m-d H:i:s", strtotime($DWVoidData[$i]->trxdate)),
							"created"           => getDateTime(),
							"active"            => '1',

						);

						$insert_data_customer_points = $this->db->insert('data_customer_points', $data_point);

						$notification_title       = 'Void for '.$DWVoidData[$i]->trxnum;
						$notification_short       = 'Void for '.$DWVoidData[$i]->trxnum;
						$notification_long        = 'Void for '.$DWVoidData[$i]->trxnum;
						$notification_image       = "";
						$notification_url         = "";

						$data_notification = array(

							"notification_id"    => $DWSalesTranID,
							"notification_title" => $notification_title,
							"short_description"  => $notification_short,
							"long_description"   => $notification_long,
							"notification_image" => $notification_image,
							"url"                => $notification_url,
							"start_date"         => getTodayDate(),
							"end_date"           => getTodayDate(),
							"created"            => getDateTime(),
							"updated"            => getDateTime(),
							"active"             => '1',
							"contact_no"         => $DWVoidData[$i]->id,

						);

						$insert_data_customer_points = $this->db->insert('notification_receiver', $data_notification);

						$APIData["status"] = 1;
						$APIData["status_message"] = "Done Insert";
						$APIData["trxnum"]         = $DWVoidData[$i]->trxnum;
						$APIData["id"] = $DWVoidData[$i]->id;
						$APIData["type"] = 'Void';

						$ReturnData[] = $APIData;
					}
				} else {
					$APIData["status"] = 0;
					$APIData["status_message"] = "Error trxnum";
					$APIData["trxnum"]         = $DWVoidData[$i]->trxnum;
					$APIData["id"] = $DWVoidData[$i]->id;
					$APIData["type"] = 'Void';

					$ReturnData[] = $APIData;
				}
			}
		} else {

		}

	}




		echo json_encode($ReturnData);
		exit;
	}


	public function stock_balance(){

		/******************************************************************* */
		$req_dump = print_r($_REQUEST, TRUE);
		$fp = fopen('logs/stock_balance'.date("Y-m-d").'.txt', 'a');
		fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://www.starglorygroup.com/admin_sg/".$_SERVER['REQUEST_URI']."\n".$req_dump);
		fclose($fp);



		$DWAPIKey = $_REQUEST["apikey-access"];
		$DWProductData = json_decode($_REQUEST["stockbalance"]);
		$DWProductData = json_decode(str_replace(array("'"), "", $_REQUEST["stockbalance"]));


		if ( $DWAPIKey != "apistarglory:lTL0FraU!QzSTM2^XN" ) {
			$ReturnData["status"] = -2;
			$ReturnData["status_message"] = "Wrong API Key";

			echo json_encode($ReturnData);
			exit;
		}

		if ( count($DWProductData) > 0 ) {
			for ($i=0; $i<count($DWProductData); $i++) {


            // Alfred Hardcode , because QUBE pass 0 , should 810 no update !
				$DWProductData[$i]->reordqty = 12;

				$db = $this->db;
				$db->select('*');
				$db->where('plucode',$DWProductData[$i]->plucode);
				$db->where('outlet',$DWProductData[$i]->outlet);
				$balance = $db->get('data_product_balance')->row();


				if ( !empty($balance) && count($balance)>0) {
					$DWBalanceID = $balance->balance_id;

					$data = array(

						"outlet"                  => $DWProductData[$i]->outlet,
						"plucode"                 => $DWProductData[$i]->plucode,
						"plulinkid"               => $DWProductData[$i]->plulinkid,
						"barcode"                 => $DWProductData[$i]->barcode,
						"balance"                 => $DWProductData[$i]->balance,
						"unit_minimum_order"      => $DWProductData[$i]->reordqty,
						"minimum_reorder_leavel"  => $DWProductData[$i]->minlevel,
						"maximum_reorder_leavel"  => $DWProductData[$i]->maxlevel,
						"updated"                 => getDateTime(),


					);

					$q = $this->db->where('balance_id',$DWBalanceID)->update('data_product_balance', $data);



					$DWProductData[$i]->status = "1";
				} else {

					$data = array(

						"outlet"                  => $DWProductData[$i]->outlet,
						"plucode"                 => $DWProductData[$i]->plucode,
						"plulinkid"               => $DWProductData[$i]->plulinkid,
						"barcode"                 => $DWProductData[$i]->barcode,
						"balance"                 => $DWProductData[$i]->balance,
						"unit_minimum_order"      => $DWProductData[$i]->reordqty,
						"minimum_reorder_leavel"  => $DWProductData[$i]->minlevel,
						"maximum_reorder_leavel"  => $DWProductData[$i]->maxlevel,
						"updated"                 => getDateTime(),
						"created"                 => getDateTime(),
						"active"                  => 1,


					);

					$q = $this->db->insert('data_product_balance', $data);
					$DWProductData[$i]->status = "1";
				}

				unset($DWProductInfo);
				$DWProductInfo["status"] = $DWProductData[$i]->status;
				$DWProductInfo["status_message"] = "DONE";
				$DWProductInfo["plucode"] = $DWProductData[$i]->plucode;
				$DWProductInfo["outlet"] = $DWProductData[$i]->outlet;
				$DWReturn[] = $DWProductInfo;
			}
		}else{

			$DWProductInfo["status"] = '-1';
			$DWProductInfo["status_message"] = "Failed";

			$DWReturn[] = $DWProductInfo;

		}

		echo json_encode($DWReturn);
		exit;
	}


	public function stock_product_master(){

		$req_dump = print_r($_REQUEST, TRUE);
		$fp = fopen('logs/stock_product_master'.date("Y-m-d").'.txt', 'a');
		fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://www.starglorygroup.com/admin_sg/".$_SERVER['REQUEST_URI']."\n".$req_dump);
		fclose($fp);



		$DWAPIKey = $_REQUEST["apikey-access"];
		$DWProductData = json_decode(str_replace(array("'"), "", $_REQUEST["onlinestock"]));


		if ( $DWAPIKey != "apistarglory:lTL0FraU!QzSTM2^XN" ) {
			$Key["status"] = -2;
			$Key["status_message"] = "Wrong API Key";
			$ReturnData[] = $Key;
			echo json_encode($ReturnData);
			exit;
		}

		if ( count($DWProductData) > 0 ) {
			for ($i=0; $i<count($DWProductData); $i++) {

				$db = $this->db;
				$db->select('*');
				$db->where('plucode',$DWProductData[$i]->plucode);
				$db->where('pricelevel',$DWProductData[$i]->pricelevel);
				$product = $db->get('data_product')->row();

				if ( !empty($product) && count($product) > 0 ) {
					$DWProductID = $product->product_id;

					$data = array(

						"group"                       => $DWProductData[$i]->group,
						"group_desc"                  => $DWProductData[$i]->group_desc,
						"department"                  => $DWProductData[$i]->department,
						"department_desc"             => $DWProductData[$i]->department_desc,
						"brand"                       => $DWProductData[$i]->brand,
						"brand_desc"                  => $DWProductData[$i]->brand_desc,
						"category"                    => $DWProductData[$i]->category,
						"category_desc"               => $DWProductData[$i]->category_desc,
						"plulinkid"                   => $DWProductData[$i]->plulinkid,
						"barcode"                     => $DWProductData[$i]->barcode,
						"description"                 => $DWProductData[$i]->desc,
						"supplier"                    => $DWProductData[$i]->supplier,
						"supplier_desc"               => $DWProductData[$i]->supplier_desc,
						"pricelevel"                  => $DWProductData[$i]->pricelevel,
						"unit_minimum_order"          => $DWProductData[$i]->reordqty,
						"minimum_reorder_leavel"      => $DWProductData[$i]->minlevel,
						"maximum_reorder_leavel"      => $DWProductData[$i]->maxlevel,
						"price"                       => $DWProductData[$i]->price,
						"cost"                        => $DWProductData[$i]->unitcost,
						"updated"                     => getDateTime(),
						"active_qube"                 => $DWProductData[$i]->active,


					);

					$q = $this->db->where('product_id',$DWProductID)->update('data_product', $data);
					$DWProductData[$i]->status = "1";
				} else {


					$data = array(

						"group"                       => $DWProductData[$i]->group,
						"group_desc"                  => $DWProductData[$i]->group_desc,
						"department"                  => $DWProductData[$i]->department,
						"department_desc"             => $DWProductData[$i]->department_desc,
						"brand"                       => $DWProductData[$i]->brand,
						"brand_desc"                  => $DWProductData[$i]->brand_desc,
						"category"                    => $DWProductData[$i]->category,
						"category_desc"               => $DWProductData[$i]->category_desc,
						"plulinkid"                   => $DWProductData[$i]->plulinkid,
						"plucode"                   => $DWProductData[$i]->plucode,
						"barcode"                     => $DWProductData[$i]->barcode,
						"description"                 => $DWProductData[$i]->desc,
						"supplier"                    => $DWProductData[$i]->supplier,
						"supplier_desc"               => $DWProductData[$i]->supplier_desc,
						"pricelevel"                  => $DWProductData[$i]->pricelevel,
						"unit_minimum_order"          => $DWProductData[$i]->reordqty,
						"minimum_reorder_leavel"      => $DWProductData[$i]->minlevel,
						"maximum_reorder_leavel"      => $DWProductData[$i]->maxlevel,
						"price"                       => $DWProductData[$i]->price,
						"cost"                        => $DWProductData[$i]->unitcost,
						"updated"                     => getDateTime(),
						"created"                     => getDateTime(),
						"active_qube"                 => $DWProductData[$i]->active,


					);

					$q = $this->db->insert('data_product', $data);
					$DWProductData[$i]->status = "1";
				}

				unset($DWProductInfo);
				$DWProductInfo["status"] = $DWProductData[$i]->status;
				$DWProductInfo["status_message"] = "DONE";
				$DWProductInfo["plucode"] = $DWProductData[$i]->plucode;
				$DWProductInfo["pricelevel"] = $DWProductData[$i]->pricelevel;
				$DWReturn[] = $DWProductInfo;
			}
		}else{

			$DWProductInfo["status"] = '-1';
			$DWProductInfo["status_message"] = "Failed";
			$DWReturn[] = $DWProductInfo;

		}

		echo json_encode($DWReturn);
		exit;
	}

	public function voucher_check_register(){


		$req_dump = print_r($_REQUEST, TRUE);
		$fp = fopen('logs/voucher_check_register.txt', 'a');
		fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://www.starglorygroup.com/admin_sg/".$_SERVER['REQUEST_URI']."\n".$req_dump);
		fclose($fp);


		$DWAPIKey = $_REQUEST["apikey-access"];

		$DWVoucherData = json_decode($_REQUEST["voucher"]);

		if ( $DWAPIKey != "apistarglory:lTL0FraU!QzSTM2^XN" ) {
			$Key["status"] = -2;
			$Key["status_message"] = "Wrong API Key";
			$ReturnData[] = $Key;

			echo json_encode($ReturnData);
			exit;
		}


	// Default Value
	// $Voucher["status"] = 2;
	// $Voucher["status_message"] = "Unknown Error!";



	// Check Customer is Qua to Redeem
	//$DWUserContact = $this->ReturnValidContact($DWVoucherData->id);
		if(!empty($DWVoucherData)){


			if ( count($DWVoucherData) > 0 ) {
				for ($i=0; $i<count($DWVoucherData); $i++) {
					$DWUserContact = $DWVoucherData[$i]->id;
					if ( $DWUserContact != "" ) {


						$db = $this->db;
						$db->select('v.voucher_code, i.start_date, i.end_date, i.voucher_value,"fixed value" as voucher_type');
						$db->join('data_voucher i','i.id=v.voucher_id AND i.active=1','inner');
						$db->where('v.voucher_code',$DWVoucherData[$i]->code);
						$db->where('v.contact_no',$DWUserContact);
						$db->where('v.voucher_status',1);
						$data_vouc = $db->get('data_voucher_cust v')->row();

						if ( !empty($data_vouc)) {


							$Voucher["status"] = 1;
							$Voucher["status_message"] = "Voucher Valid";
							$Voucher["voucher_code"] = $data_vouc->voucher_code;
							$Voucher["start_date"] = $data_vouc->start_date;
							$Voucher["end_date"] = $data_vouc->end_date;
							$Voucher["voucher_value"] = $data_vouc->voucher_value;
							$Voucher["voucher_type"] = $data_vouc->voucher_type;
							$ReturnData[] = $Voucher;



						} else {
							$Voucher["status"] = 0;
							$Voucher["status_message"] = "Invalid Voucher Code";

							$ReturnData[] = $Voucher;

						}





					} else {
						$Voucher["status"] = 0;
						$Voucher["status_message"] = "No ID";

						$ReturnData[] = $Voucher;
					}




				}
			}else{

				$Voucher["status"] = 0;
				$Voucher["status_message"] = "No Data";

				$ReturnData[] = $Voucher;

			}

		}else{
			$Voucher["status"] = 0;
			$Voucher["status_message"] = "No Data";

			$ReturnData[] = $Voucher;
		}
		echo json_encode($ReturnData);
		exit;
	}

	public function voucher_check_register_old(){


		$req_dump = print_r($_REQUEST, TRUE);
		$fp = fopen('logs/voucher_check_register.txt', 'a');
		fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://www.starglorygroup.com/admin_sg/".$_SERVER['REQUEST_URI']."\n".$req_dump);
		fclose($fp);


		$DWAPIKey = $_REQUEST["apikey-access"];

		$DWVoucherData = json_decode($_REQUEST["voucher"]);

		if ( $DWAPIKey != "apistarglory:lTL0FraU!QzSTM2^XN" ) {
			$ReturnData["status"] = -2;
			$ReturnData["status_message"] = "Wrong API Key";

			echo json_encode($ReturnData);
			exit;
		}


	// Default Value
		$ReturnData["status"] = 2;
		$ReturnData["status_message"] = "Unknown Error!";



	// Check Customer is Qua to Redeem
	//$DWUserContact = $this->ReturnValidContact($DWVoucherData->id);
		if ( count($DWVoucherData) > 0 ) {
			for ($i=0; $i<count($DWVoucherData); $i++) {
				$DWUserContact = $DWVoucherData[$i]->id;
				if ( $DWUserContact != "" ) {

					$db = $this->db;
					$db->select('*');
					$db->where('contact_no',$DWUserContact);
					$customer = $db->get('data_customer')->row();


					if ( !empty($customer) ) {

						$DWCustID =$customer->id;

						$db = $this->db;
						$db->select('*');
						$db->where('contact_no',$DWUserContact);
						$db->where('info_id',2);
						$voucher = $db->get('data_voucher_cust')->row();

						if (!empty($voucher) && count($voucher) > 0 ) {
							$ReturnData["status"] = 0;
							$ReturnData["status_message"] = "Sorry, Customer '".$DWUserContact."' has been redeemed Register Voucher before.";
						}

					} else {
						$ReturnData["status"] = 0;
						$ReturnData["status_message"] = "Invalid Customer ID";
					}
				} else {
					$ReturnData["status"] = 0;
					$ReturnData["status_message"] = "No ID";
				}


				if ( $ReturnData["status"] != 0 ) {

		// Alfred - Same voucher got * some no , need hardcode check and add
					if ( substr($DWVoucherData[$i]->code, 0, 1) != "*" ) $DWVoucherData[$i]->code = "*".$DWVoucherData[$i]->code."*";


		// Check Voucher Code Valid ?
					if ( $DWVoucherData[$i]->code != "" ) {

						$db = $this->db;
						$db->select('v.voucher_code, i.start_date, i.end_date, i.voucher_value, "fixed value" as voucher_type');
						$db->join('data_voucher i','i.id=v.info_id AND i.active=1','inner');
						$db->where('v.voucher_code',$DWVoucherData[$i]->code);
						$db->where('v.active',1);
						$data_vouc = $db->get('data_voucher_cust v')->result();

						if ( !empty($data_vouc) && count($data_vouc) > 0) {
							foreach($data_vouc as $dv){

								$ReturnData["status"] = 1;
								$ReturnData["status_message"] = "Voucher Valid";

								$ReturnData[] = $RowData;
							}
						} else {
							$ReturnData["status"] = 0;
							$ReturnData["status_message"] = "Invalid Voucher Code";
						}
					} else {
						$ReturnData["status"] = 0;
						$ReturnData["status_message"] = "No Voucher Code";
					}
				}

			}
		}
		echo json_encode($ReturnData);
		exit;
	}


	public function voucher_check(){


		$req_dump = print_r($_REQUEST, TRUE);
		$fp = fopen('logs/voucher_check_'.date("Y-m-d").'.txt', 'a');
		fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://www.starglorygroup.com/admin_sg/".$_SERVER['REQUEST_URI']."\n".$req_dump);
		fclose($fp);

		$_REQUEST["apikey-access"] = "api810:lTL0FraU!QzSTM2^XN";
		$DWAPIKey = $_REQUEST["apikey-access"];

		$DWVoucherData = json_decode($_REQUEST["voucher"]);

		if ( $DWAPIKey != "api810:lTL0FraU!QzSTM2^XN" ) {
			$Key["status"] = -2;
			$Key["status_message"] = "Wrong API Key";
			$ReturnData[] = $Key;
			echo json_encode($ReturnData);
			exit;
		}

		if ( count($DWVoucherData) > 0 ) {
			for ($i=0; $i<count($DWVoucherData); $i++) {

				$DWCustID = 0;
				unset($ResultData);
    		//
			// Check Customer is Valid to Redeem
			// $DWUserContact = $this->ReturnValidContact($DWVoucherData[$i]->id);
				$DWUserContact = $DWVoucherData[$i]->id;
				if ( $DWUserContact != "" && $DWVoucherData[$i]->type != "REGISTER" && $DWVoucherData[$i]->type != "RENEW" ) {

					$db = $this->db;
					$db->select('*');
					$db->where('contact_no',$DWUserContact);
					$cust = $db->get('data_customer')->row();

					if ( !empty($cust) && count($cust) > 0 ) {

						$DWCustID = $cust->id;
						$DWActive = $cust->active;

						if ( $DWActive == 2 ) {

							$ResultData["status"] = 0;
							$ResultData["status_message"] = "This customer is not verify, please ask customer to verify.";
							$ResultData["id"] = $DWVoucherData[$i]->id;

							$ReturnData[] = $ResultData;
						} else if ( $DWVoucherData[$i]->type == "REGISTER" ) {
						//
						// Register Voucher
							$db = $this->db;
							$db->select('*');
							$db->where('customer_id',$DWCustID);
							$vouch = $db->get('data_voucher')->row();

							if ( !empty($vouch) && count($vouch) > 0 ) {
								$ResultData["status"] = 0;
								$ResultData["status_message"] = "Sorry, this customer '".$DWUserContact."' has redeemed a voucher before.";
								$ResultData["id"] = $DWVoucherData[$i]->id;

								$ReturnData[] = $ResultData;
							}
						} else if ( $DWVoucherData[$i]->type == "RENEW" ) {

						} else {
						//
						// Alfred - Same voucher got * some no , need hardcode check and add
							if ( substr($DWVoucherData[$i]->code, 0, 1) != "*" ) $DWVoucherData[$i]->code = "*".$DWVoucherData[$i]->code."*";

						//
						// Only Check for Register / Renew Voucher
							$db = $this->db;
							$db->select('*');
							$db->where('voucher_code',$DWVoucherData[$i]->code);
							$db->where('info_id',2);
							$db->limit(1);
							$vouch_reg = $db->get('data_voucher')->row();

							if ( !empty($vouch_reg) && count($vouch_reg) > 0 ) {
			    			//
							// Register Voucher
								$db = $this->db;
								$db->select('*');
								$db->where('customer_id',$DWCustID);
								$db->where('info_id',2);
								$db->limit(1);
								$vouch_reg = $db->get('data_voucher')->row();


								if ( !empty($vouch_reg) && count($vouch_reg) > 0 ) {
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

				//
				// Alfred - Same voucher got * some no , need hardcode check and add
					if ( substr($DWVoucherData[$i]->code, 0, 1) != "*" ) $DWVoucherData[$i]->code = "*".$DWVoucherData[$i]->code."*";

					if ( $DWVoucherData[$i]->code != "" ) {
						if ( $DWVoucherData[$i]->type == "REGISTER" || $DWVoucherData[$i]->type == "RENEW" ) {

							$db = $this->db;
							$db->select('v.voucher_code, i.start_date, i.end_date, i.voucher_value');
							$db->join('data_voucher i','i.id=v.info_id AND i.active=1','inner');
							$db->where('v.voucher_code',$DWVoucherData[$i]->code);
							$db->where('i.start_date <=',date("Y-m-d"));
							$db->where('i.end_date >=',date("Y-m-d"));
							$db->where('v.active',3);
							$db->limit(1);

						} else {

							$db = $this->db;
							$db->select('v.voucher_code, i.start_date, i.end_date, i.voucher_value');
							$db->join('data_voucher i','i.id=v.info_id AND i.active=1','inner');
							$db->where('v.voucher_code',$DWVoucherData[$i]->code);
							$db->where('i.start_date <=',date("Y-m-d"));
							$db->where('i.end_date >=',date("Y-m-d"));
							$db->where('v.active',1);
							$db->limit(1);


						}

						$data_vouc = $db->get('data_voucher_cust v')->row();
						if ( !empty($data_vouc) && count($data_vouc) > 0 ) {

							$ResultData = $data_vouc ;
							$ResultData["status"] = 1;
							$ResultData["status_message"] = "Voucher Valid...";
							$ResultData["id"] = $DWVoucherData[$i]->id;

							$ReturnData[] = $ResultData;

						} else {
							$ResultData["status"] = 0;
							$ResultData["status_message"] = "Invalid Voucher Code / Voucher Code has been activated before.";
							$ResultData["id"] = $DWVoucherData[$i]->id;

							$ReturnData[] = $ResultData;
						}
					} else {
						$ResultData["status"] = 0;
						$ResultData["status_message"] = "No Voucher Code...";
						$ResultData["id"] = $DWVoucherData[$i]->id;

						$ReturnData[] = $ResultData;
					}
				}

			}
		}


		echo json_encode($ReturnData);
		exit;

	}


	public function  voucher_redeem(){


		$req_dump = print_r($_REQUEST, TRUE);
		$fp = fopen('logs/voucher_redeem_'.date("Y-m-d").'.txt', 'a');
		fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://www.starglorygroup.com/admin_sg/".$_SERVER['REQUEST_URI']."\n".$req_dump);
		fclose($fp);

		$DWAPIKey = $_REQUEST["apikey-access"];
		$DWVoucherData = json_decode($_REQUEST["voucher"]);

		if ( $DWAPIKey != "apistarglory:lTL0FraU!QzSTM2^XN" ) {
			$Key["status"] = -2;
			$Key["status_message"] = "Wrong API Key";
			$ReturnData[] = $Key;
			echo json_encode($ReturnData);
			exit;
		}

		if ( count($DWVoucherData) > 0 ) {
			for ($i=0; $i<count($DWVoucherData); $i++) {
				$DWCustID = 0;
    		//
			// Check Customer is Valid to Redeem
			//$DWUserContact = $this->ReturnValidContact($DWVoucherData[$i]->id);
				$DWUserContact = $DWVoucherData[$i]->id;
				if ( $DWUserContact != "" ) {

					$db = $this->db;
					$db->select('*');
					$db->where('contact_no',$DWUserContact);
					$customer = $db->get('data_customer')->row();


					if (!empty($customer) ) {

						$DWCustID = $customer->id;

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
				// if ( substr($DWVoucherData[$i]->code, 0, 1) != "*" ) $DWVoucherData[$i]->code = "*".$DWVoucherData[$i]->code."*";

					if ( $DWVoucherData[$i]->code != "" ) {

						$db = $this->db;
						$db->select(' v.id,v.voucher_code, v.contact_no, i.start_date, i.end_date, i.voucher_value');
						$db->join('data_voucher i','i.id=v.voucher_id AND i.active=1','inner');
						$db->where('v.voucher_code',$DWVoucherData[$i]->code);
						$db->where('v.contact_no',$DWUserContact);
						$db->where('v.trxvalue',$DWVoucherData[$i]->value);
						$db->where('v.voucher_status',1);
						$db->limit(1);
						$data_vouc = $db->get('data_voucher_cust v')->row();

						if( !empty($data_vouc)) {

							$DWVouID = $data_vouc->id;

							$data = array(

								"redeem_date"    => getDateTime(),
								"voucher_status" => 0,
								"trxnum"         => $DWVoucherData[$i]->trxnum,
								"trxdate"         => date("Y-m-d H:i:s", strtotime($DWVoucherData[$i]->trxdate)),


							);

							$q = $this->db->where('id',$DWVouID)->update('data_voucher_cust', $data);
						// $DWPoint = '';

						// $data_point = array(

						// 	"contact_no"        => $DWUserContact,
						// 	"group_id"          => '',
						// 	"points"            => $DWPoint,
						// 	"point_type"        => '0',
						// 	"description"       => 'Redeem for '.$DWVoucherData[$i]->trxnum,
						// 	"transaction_date"  => date("Y-m-d H:i:s", strtotime($DWVoucherData[$i]->trxdate)),
						// 	"created"           => getDateTime(),
						// 	"active"            => '1',

						// );

					 //    $insert_data_customer_points = $this->db->insert('data_customer_points', $data_point);

							$ResultData["status"] = 1;
							$ResultData["status_message"] = "Done Updated";
							$ResultData["id"] = $DWVoucherData[$i]->id;

							$ReturnData[] = $ResultData;






						}else {

							$ResultData["status"] = 0;
							$ResultData["status_message"] = "Invalid Voucher Code..";
							$ResultData["id"] = $DWVoucherData[$i]->id;

							$ReturnData[] = $ResultData;
						}
					} else {

						$ResultData["status"] = 0;
						$ResultData["status_message"] = "No Voucher Code..";
						$ResultData["id"] = $DWVoucherData[$i]->id;

						$ReturnData[] = $ResultData;
					}
				}
			}
		}

		echo json_encode($ReturnData);
		exit;

	}




	public function all_member_register(){


		$DWAPIKey = $_REQUEST["apikey-access"];



		if ( $DWAPIKey != "apistarglory:lTL0FraU!QzSTM2^XN" ) {
			$customers["status"] = -2;
			$customers["status_message"] = "Wrong API Key";
			$ReturnData[] = $customers;
			echo json_encode($ReturnData);
			exit;
		}

		$db = $this->db;
		$db->select('*');
		$db->where('active ',1);
		$customers = $db->get('data_customer')->result();
    	   // pre($customer );
    	   // die();
		if ( !empty($customers) && count($customers) > 0 ) {

			foreach ($customers as $customer) {
            			# code...
				if($customer->customer_type == '2'){

					$membership_type = 'SGS';


				}else if($customer->customer_type == '3'){

					$membership_type = 'SGG';

				}else if($customer->customer_type == '4'){

					$membership_type = 'SGV';

				}else{

					$membership_type = 'SGL';

				}


				$RowData["name"]              = $customer->name;
				$RowData["profile_picture"]   = base_url('assets/upload_files/profile_picture/'.$customer->profile_picture);
				$RowData["membership_type"]   = $membership_type;
				$RowData["email"]             = $customer->email;
				$RowData["contact_no"]        = $customer->contact_no;
				$RowData["group_id"]          = $customer->group_id;
				$RowData["barcode"]           = $customer->barcode;
				$RowData["ic_no"]             = $customer->ic_no;
				$RowData["joined_by"]         = $customer->joined_by;
				$RowData["joined_date"]       = $customer->joined_date;
				$RowData["date_of_birth"]     = $customer->date_of_birth;
				$RowData["address"]           = $customer->address;
				$RowData["city"]              = $customer->city;
				$RowData["state"]             = $customer->state;
				$RowData["country"]           = $customer->country;
				$RowData["zipcode"]           = $customer->zipcode;
				$RowData["gender"]            = $customer->gender;
				$RowData["race"]              = $customer->race;
				$RowData["point"]             = $this->getIndividual_point($customer->contact_no);
				$RowData["firsttime"]         = $customer->firsttime;
				$RowData["year"]              = $customer->year;
				$RowData["last_login"]        = $customer->last_login;
				$RowData["created"]           = $customer->created;
				$RowData["updated"]           = $customer->updated;


				$ReturnData[] = $RowData;
                $status_message = 'Success';
                $status = '1';


			}

                  //$ReturnData["status"] = 1;

		} else {
			// $APIData["status"] = 0;
			// $APIData["status_message"] = "No Data";


			// $ReturnData[] = $APIData;
			$ReturnData[] = '';
			$status_message = 'No Data';
            $status = '0';
		}

		$MainData["Member"] = $ReturnData;
		
		$MainData["status"] = $status;
		$MainData["status_message"] = $status_message;

		$ReturnDatas[]=$MainData;
		echo json_encode($ReturnDatas);
		
		exit;
		echo json_encode($ReturnData);
		exit;
	}



	public function member_today_register(){



		$DWAPIKey = $_REQUEST["apikey-access"];


		if ( $DWAPIKey != "apistarglory:lTL0FraU!QzSTM2^XN" ) {
			$customers["status"] = -2;
			$customers["status_message"] = "Wrong API Key";

			$ReturnData[] =$customers;

			echo json_encode($ReturnData);
			exit;
		}



		$db = $this->db;
		$db->select('*');
		$db->where('active ',1);
		$db->where('date(created)',getTodayDate());
		$customers = $db->get('data_customer')->result();
    	   // pre($customer );
    	   // die();
		if ( !empty($customers) && count($customers) > 0 ) {
			
			foreach ($customers as $customer) {
            			# code...

				if($customer->customer_type == '2'){

					$membership_type = 'SGS';


				}else if($customer->customer_type == '3'){

					$membership_type = 'SGG';

				}else if($customer->customer_type == '4'){

					$membership_type = 'SGV';

				}else{

					$membership_type = 'SGL';

				}


				$RowData["name"]              = $customer->name;
				$RowData["profile_picture"]   = base_url('assets/upload_files/profile_picture/'.$customer->profile_picture);
				$RowData["membership_type"]   = $membership_type;
				$RowData["email"]             = $customer->email;
				$RowData["contact_no"]        = $customer->contact_no;
				$RowData["group_id"]          = $customer->group_id;
				$RowData["barcode"]           = $customer->barcode;
				$RowData["ic_no"]             = $customer->ic_no;
				$RowData["joined_by"]         = $customer->joined_by;
				$RowData["joined_date"]       = $customer->joined_date;
				$RowData["date_of_birth"]     = $customer->date_of_birth;
				$RowData["address"]           = $customer->address;
				$RowData["city"]              = $customer->city;
				$RowData["state"]             = $customer->state;
				$RowData["country"]           = $customer->country;
				$RowData["zipcode"]           = $customer->zipcode;
				$RowData["gender"]            = $customer->gender;
				$RowData["race"]              = $customer->race;
				$RowData["point"]             = $this->getIndividual_point($customer->contact_no);
				$RowData["firsttime"]         = $customer->firsttime;
				$RowData["year"]              = $customer->year;
				$RowData["last_login"]        = $customer->last_login;
				$RowData["created"]           = $customer->created;
				$RowData["updated"]           = $customer->updated;

				$ReturnData[] = $RowData;
				$status = '1';
				$status_message = 'Success';
                     //$ReturnData["status"] = 1;

			}

                  // $ReturnData["status"] = 1;      		

		} else {


			// $APIData["status"] = 0;
			// $APIData["status_message"] = "No Data";

			// $ReturnData[] = $APIData;

			$ReturnData[] = '';
			$status = '0';
			$status_message = 'No Data';
		}

		$MainData["Member"] = $ReturnData;
		
		$MainData["status"] = $status;
		$MainData["status_message"] = $status_message;

		$ReturnDatas[]=$MainData;
		echo json_encode($ReturnDatas);
		exit;
	}


	public function member_voucher(){


		$req_dump = print_r($_REQUEST, TRUE);
		$fp = fopen('logs/member_voucher'.date("Y-m-d").'.txt', 'a');
		fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://www.starglorygroup.com/admin_sg/".$_SERVER['REQUEST_URI']."\n".$req_dump);
		fclose($fp);

		$DWAPIKey = $_REQUEST["apikey-access"];
		$DWCustomerData = json_decode($_REQUEST["customer"]);

		if ( $DWAPIKey != "apistarglory:lTL0FraU!QzSTM2^XN" ) {
			$RowData["status"] = -2;
			$RowData["status_message"] = "Wrong API Key";

			$ReturnData[] = $RowData;
			echo json_encode($ReturnData);
			exit;
		}
		
		if ( count($DWCustomerData) > 0 ) {
			for ($i=0; $i<count($DWCustomerData); $i++) {

				$DWUserContact = $DWCustomerData[$i]->id;

				$db = $this->db;
				$db->select('dvc.contact_no,dvc.voucher_code,dvc.barcode,dvc.trxvalue,dvc.claim_date,dvc.redeem_date,dvc.voucher_status,dv.voucher_name,dv.exchange_point,dv.voucher_img_before,dv.voucher_img_after,dv.start_date,dv.end_date');
				$db->join('data_voucher dv','dvc.voucher_id=dv.id','left');
				$db->where('active ',1);
				$db->where('dvc.contact_no',$DWUserContact);
				$customers = $db->get('data_voucher_cust dvc')->result();
				$str = $db->last_query();

				if ( !empty($customers) && count($customers) > 0 ) {

					foreach ($customers as $customer) {


						$RowData["contact_no"]              = $customer->contact_no;
						$RowData["voucher_code"]            = $customer->voucher_code;
						$RowData["barcode"]                 = $customer->barcode;
						$RowData["voucher_value"]           = $customer->trxvalue;
						$RowData["claim_date"]              = $customer->claim_date;
						$RowData["redeem_date"]             = $customer->redeem_date;
						$RowData["voucher_status"]          = $customer->voucher_status;
						$RowData["voucher_name"]            = $customer->voucher_name;
						$RowData["exchange_point"]          = $customer->exchange_point;
						$RowData["voucher_img_before"]      = $customer->voucher_img_before;
						$RowData["voucher_img_after"]       = $customer->voucher_img_after;
						$RowData["start_date"]              = $customer->start_date;
						$RowData["end_date"]                = $customer->end_date;
						$RowData["voucher_type"]            = 'fix value';

						$ReturnData[] = $RowData;
						$status = 1;
						$status_message = 'Success';
                    // $ReturnData["status"] = 1;

					}


				} else {

					// $APIData["status"] = 0;
					// $APIData["status_message"] = "No Data";

					// $ReturnData[] = $APIData;
					$ReturnData[] = '';
					$status = 0;
				    $status_message = 'No Data';
				}
			}
		}else{


			// $APIData["status"] = -1;
			// $APIData["status_message"] = "Invalid Data";

			// $ReturnData[] = $APIData;

			$ReturnData[] = '';
		    $status = '-1';
		    $status_message = 'Invalid Data';

		}

		$MainData["Voucher"] = $ReturnData;
		
		$MainData["status"] = $status;
		$MainData["status_message"] = $status_message;

		$ReturnDatas[]=$MainData;
		echo json_encode($ReturnDatas);
		 
		exit;
    


	}


	
}