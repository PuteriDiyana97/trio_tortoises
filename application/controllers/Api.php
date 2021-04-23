<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class API extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('');
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
	}
	//checking antara no phone tu dah ada 6 kt depan ke belum..atau ada symbol yg xpenting
	public function ReturnValidContact($contact_no) {
		$contact_no = str_replace(array(" ", "-", ".", ",", "+"), "", $contact_no);
		if ( substr($contact_no, 0, 1) != "6" && !empty($contact_no) ) {
			$contact_no = "6".$contact_no;
		}

		return $contact_no;
	}

	//routes:customer
	public function api_register_otp()
	{	
		// $phone = '0123456789'; 
		// $contact_no = $this->ReturnValidContact($phone);
		$_REQUEST['contactno'];
		$contact_no = $this->ReturnValidContact($_REQUEST["contactno"]);
		$otp_no = rand(1000, 9999);
                                                                                                //not verify
		$Sql_Select = "SELECT d.* FROM data_customer d WHERE d.contact_no = '".$contact_no."' AND active =2";
		$Rst_Select = $this->db->query($Sql_Select)->row();
		//pre($Rst_Select);
		//die();
		if (!empty($Rst_Select)) 
		{

			$DWID = $Rst_Select->id;
			$DWActive = $Rst_Select->active;

			if ( 1 ) {
					//echo "<br>".
					$Sql_Update = " UPDATE data_customer SET otp = '".$otp_no."',active =2 WHERE id = '".$DWID."'";
					$Rst_Update =  $this->db->query($Sql_Update);
					//
					// Send SMS Function
					// SendSMS($contact_no, $otp_no);
					//
					// Contact Existing in DB with Pending as Activate
					$MainData["contactno"] = $contact_no;
					$MainData["status"] = "1";
					$MainData["status_message"] = "You will receive your OTP code via SMS.";
				} else {
					//
					// Contact is Activated
					$MainData["contactno"] = $contact_no;
					$MainData["status"] = "0";
					$MainData["status_message"] = "Sorry, contact no. already existing, please try another. Thank you.";
				}
				
		} else {//new customer
				$Sql_Insert = "INSERT INTO data_customer (contact_no, otp, updated, created, active) VALUES ('".$contact_no."','".$otp_no."', NOW(), NOW(), 2)";
				$Rst_Insert =  $this->db->query($Sql_Insert);
			//
			// Send SMS Function
			// SendSMS($contact_no, $otp_no);
			//
			// Return TRUE
			$MainData["contactno"] = $contact_no;
			$MainData["status"] = "1";
			$MainData["status_message"] = "You will receive your OTP code via SMS.";
	    }

			
		echo json_encode($MainData);
	}
	//register.php
	public function api_otp_verification()
	{
		// $phone = '0123456789'; 
		// $contact_no = $this->ReturnValidContact($phone);
		// $otp 	= '9884';
		$_REQUEST['contactno'];
		$contact_no = $this->ReturnValidContact($_REQUEST["contactno"]);

		$otp 	= $_REQUEST["otp"];

		$sql_otp = "SELECT d.* FROM data_customer d WHERE d.contact_no = '".$contact_no."' AND d.otp = '".$otp."' AND d.active =2 LIMIT 1";
		$rst_otp =  $this->db->query($sql_otp);

		if (!empty($rst_otp)) 
		{
			$Sql_Select = "SELECT d.* FROM data_customer d WHERE d.contact_no = '".$contact_no."' AND d.otp = '".$otp."' AND d.active =2 LIMIT 1";
			$Rst_Select = $this->db->query($Sql_Select)->row();
			//pre($Rst_Select);
			//die();
			if (!empty($Rst_Select)) 
			{
				$DWID = $Rst_Select->id;
				$DWActive = $Rst_Select->active;

				// Update Info and Disable First Time Setting
				$Sql_Update = "UPDATE data_customer SET contact_no = '".$contact_no."', otp = '".$otp."', firsttime = NOW(),active = 1 WHERE id = '".$DWID."'";
				$Rst_Update =  $this->db->query($Sql_Update);

				$MainData["contact_no"] = $Rst_Select->contact_no;
				$MainData["otp"] = $Rst_Select->otp;

				//$MainData["firstpage"] = "/tabs/member";
				$MainData["firstpage"] = "/tabs/register";
					
				$MainData["status"] = "1";
				$MainData["status_message"] = "Register successfully.";
			} else {
				$MainData["status"] = "0";
				$MainData["status_message"] = "Verification code incorrect, please try again.";
			}
		}else{
				$MainData["status"] = "0";
				$MainData["status_message"] = "Please enter the verification code.";
			}	
		
		echo json_encode($MainData);
	}
	//register.php
	public function api_register()
	{
		$phone = '0123456789'; 
		$contact_no1 = $this->ReturnValidContact($phone);
		$name1       = 'pds';
		$email1 		= 'diyana@cloone.com.my';
		// $password1 		= '123';
		// $re_pswrd1 	= '123';
		$ic_no1 		= '1234567';
		$date_of_birth1 = '1976/08/29';
		$address1	= 'Kampung Air';
		$country1 	= 'Indonesia';
		$state1 		= 'Bandung';
		$zipcode1 	= '24434';
		$gender1 	= 'Female';

		$name       = $name1;
		$contact_no = $contact_no1;
		$email 		= $email1;
		// $password 		= $password1;
		// $re_password 	= $re_pswrd1;
		$ic_no 		= $ic_no1;
		$date_of_birth = $date_of_birth1;
		$address 	= $address1;
		$country 	= $country1;
		$state 		= $state1;
		$zipcode 	= $zipcode1;
		$gender 	= $gender1;

		if (!empty($rst_no)) 
		{
			$Sql_Select = "SELECT d.* FROM data_customer d WHERE d.contact_no = '".$contact_no."'  AND d.active =1 LIMIT 1";
			$Rst_Select = $this->db->query($Sql_Select)->row();
			//pre($Rst_Select);
			//die();
			if (!empty($Rst_Select)) {
				$DWID = $Rst_Select->id;
				$DWNO = $Rst_Select->contact_no;

				// Update Info and Disable First Time Setting
				$Sql_Update = "UPDATE data_customer SET name = '".$name."', contact_no = '".$DWNO."', email = '".$email."', ic_no = '".$ic_no."', date_of_birth = '".$date_of_birth."' , address = '".$address."', country = '".$country."', state = '".$state."', zipcode = '".$zipcode."', gender = '".$gender."' , firsttime = NOW(),active = 1 WHERE id = '".$DWID."'";
				$Rst_Update =  $this->db->query($Sql_Update);

				$MainData["contact_no"] = $DWNO;

				//$MainData["firstpage"] = "/tabs/member";
				$MainData["firstpage"] = "/tabs/home";
					
				$MainData["status"] = "1";
				$MainData["status_message"] = "Register Successfully.";
			}
			else{
				$MainData["status"] = "0";
				$MainData["status_message"] = "Sorry, fail to register. Please try again";
			}

		echo json_encode($MainData);
		}
	}

	public function api_login()
	{
		$contact_no = $this->ReturnValidContact($_REQUEST["contactno"]);
		// $phone = '0127313401'; 
		// $contact_no1 = $this->ReturnValidContact($phone);
		// $password1 		= '123';
		// $password 		= $password1;

		$Sql_Select = "SELECT d.* FROM data_customer d WHERE d.contact_no = '".$contact_no."' AND d.active = 1";
		$Rst_Select = $this->db->query($Sql_Select)->row();
		//pre($Rst_Select);
		//die();
		if (!empty($Rst_Select)) {
				// $DWData["firsttime_login"] = (( $DWData["firsttime"] == NULL || $DWData["firsttime"] == "" ) ? 1 : 0);

				$MainData["firstpage"] = "/tabs/home";

				$MainData["status"] = "1";
				$MainData["status_message"] = "Welcome to Star Glory";
			
		} else {
			$MainData["status"] = "0";
			$MainData["status_message"] = "Incorrect Number or OTP!";
		}


		echo json_encode($MainData);
	}

	public function api_home()
	{
		$phone = '0127313401'; 
		$contact_no = $this->ReturnValidContact($phone);
		// $DWMode = $_REQUEST["display_mode"];
		//$contact_no = $this->ReturnValidContact($_REQUEST["contactno"]);

		$DWDayLast = date('Y-m-d 23:59:59'); //start date
		$DWDayFirst = date('Y-m-d 00:00:00', strtotime("-7 day")); //end date
		
		$Sql_Select = "SELECT d.* FROM data_promotion d WHERE d.active = 1 AND d.type_home = 1 ORDER BY created DESC";
		$Rst_Select = $this->db->query($Sql_Select)->row();
		if (!empty($Rst_Select)){
			$BannerData["COVER"] = $Rst_Select->cover;
			$BannerData["TITLE"] = $Rst_Select->title;
			unset($BannerPages);
			$BannerPages = json_decode($Rst_Select->banner);
			$BannerData["ALL_PAGES"] = $BannerPages;
			$MainData["BANNER"][] = $BannerData;

			$SqlSetting_Select = "SELECT d.* FROM data_apps_setting d WHERE d.title = 'HOME_BANNER_BACKGROUND' ";
			$RstSetting_Select = $this->db->query($SqlSetting_Select)->row();
			
				$MainData["BANNER_BG"] = $Rst_Select->banner;
		}

		$Sql_Select = "SELECT n.* FROM data_customer d INNER JOIN notifications n ON (n.customer_id=d.id) WHERE d.contact_no = '".$contact_no."' AND n.push_notification = 1 AND d.contact_no <> '' AND d.active > 0 AND n.active = 1 AND (n.created BETWEEN '".$DWDayFirst."' AND '".$DWDayLast."') ORDER BY n.id DESC";
		$Rst_Select = $this->db->query($Sql_Select)->row();
	pre ($Rst_Select); 
		if (!empty($Rst_Select)) {
			unset($BannerData);
			$BannerData["ID"] = $Rst_Select->id;
			$BannerData["NOTIFICATION_CODE"] =$Rst_Select->thumbnail;
			$BannerData["NOTIFICATION_TITLE"] = $Rst_Select->title;
			$BannerData["NOTIFICATION_DESCRIPTION"] = $Rst_Select->notification_description;
			$BannerData["START_DATE"] = date("Y/m/d", strtotime($Rst_Select->start_date));
			$BannerData["END_DATE"] = date("Y/m/d", strtotime($Rst_Select->end_date));
			$BannerData["NOTIFICATION_IMAGE"] = $Rst_Select->notification_image;
			$BannerData["URL"] = $Rst_Select->url;
			$BannerData["PUSH_NOTIFICATION"] = $Rst_Select->push_notification; //0: Haven Push, 1: Pushed
			$BannerData["DATESHOW"] = date("Y/m/d", strtotime($Rst_Select->created));
			if ($BannerData["TYPE"] == 1) {
				$BannerData["ALL_INFO"] = $Rst_Select->html;
			} else {
				unset($BannerPages);
				$BannerPages = json_decode($Rst_Select->banner);
				$BannerData["ALL_PAGES"] = $BannerPages;
			}
			
			$MainData_Info[] = $BannerData;
		}

		$MainData["NOTIFICATION"] = $MainData_Info;

		$Sql_Select = "SELECT d.* FROM data_apps_setting d WHERE d.title = 'HOME_BANNER_BACKGROUND' ";
		$Rst_Select = $this->db->query($Sql_Select)->row();
		if (!empty($Rst_Select)) {
			$MainData["BANNER_BG"] = $Rst_Select->data;
		}

		// if ( $DWMode == "TEST" ) {
		// 	echo "<pre>";
		// 	print_r($MainData);
		// 	echo "</pre>";
		// }

		//$MainData["firstpage"] = "/tabs/member";
		$MainData["firstpage"] = "/tabs/home";
		
		echo json_encode($MainData);
	}

	public function api_promotion()
	{
		// $DWMode = $_REQUEST["display_mode"];
		
		$Sql_Select = "SELECT d.* FROM data_promotion d WHERE d.active = 1 AND d.type_promotion = 1 ORDER BY created DESC";
		$Rst_Select = $this->db->query($Sql_Select)->row();
		//pre ($Rst_Select); die();
		if (!empty($Rst_Select)) {
			$BannerData["COVER"] = $Rst_Select->cover;
			$BannerData["TITLE"] = $Rst_Select->title;
			unset($BannerPages);
			$BannerPages = json_decode($Rst_Select->banner);
			$BannerData["ALL_PAGES"] = $BannerPages;
			$MainData["INFO"][] = $BannerData;
		}

		$SqlSetting_Select = "SELECT d.* FROM data_apps_setting d WHERE d.title = 'HOME_BANNER_BACKGROUND' ";
		$RstSetting_Select = $this->db->query($SqlSetting_Select)->row();
		if (!empty($RstSetting_Select)){
			$MainData["BANNER_BG"] = $RstSetting_Select->data;
		}
		// if ( $DWMode == "TEST" ) {
		// 	echo "<pre>";
		// 	print_r($MainData);
		// 	echo "</pre>";
		// }
	echo json_encode($MainData);
	}

	public function api_notification() //belum finalise
	{
		// $DWMode = $_REQUEST["display_mode"];
		$contact_no = $this->ReturnValidContact($_REQUEST["contactno"]);
		// $phone = '0127313401'; 
		// $contact_no = $this->ReturnValidContact($phone);

		$DWDayLast = date('Y-m-d 23:59:59');
		$DWDayFirst = date('Y-m-d 00:00:00', strtotime("-7 day"));
		
		$Sql_Select = "SELECT n.* FROM data_customer d INNER JOIN notifications n ON (n.customer_id=d.id) WHERE d.contact_no = '".$contact_no."' AND n.push_notification = 1 AND d.active > 0 AND n.active = 1 AND (n.created BETWEEN '".$DWDayFirst."' AND '".$DWDayLast."') ORDER BY n.id DESC";
		$Rst_Select = $this->db->query($Sql_Select)->row();
		//pre ($Rst_Select); die();
		if (!empty($Rst_Select)) { 
			unset($BannerData);
			$BannerData["ID"] = $Rst_Select->id;
			$BannerData["NOTIFICATION_TITLE"] = $Rst_Select->title;
			$BannerData["NOTIFICATION_DESCRIPTION"] = $Rst_Select->notification_description;
			$BannerData["START_DATE"] = date("Y/m/d", strtotime($Rst_Select->start_date));
			$BannerData["END_DATE"] = date("Y/m/d", strtotime($Rst_Select->end_date));
			$BannerData["NOTIFICATION_IMAGE"] = $Rst_Select->notification_image;
			$BannerData["URL"] = $Rst_Select->url;
			$BannerData["PUSH_NOTIFICATION"] = $Rst_Select->push_notification; //0: Haven Push, 1: Pushed
			$BannerData["DATESHOW"] = date("Y/m/d", strtotime($Rst_Select->created));
			if ($BannerData["TYPE"] == 1) {
				$BannerData["ALL_INFO"] = $Rst_Select->html;
			} else {
				unset($BannerPages);
				$BannerPages = json_decode($Rst_Select->banner);
				$BannerData["ALL_PAGES"] = $BannerPages;
			}
			$MainData_Info[] = $BannerData;
		}

		$MainData["NOTIFICATION"] = $MainData_Info;

		$SqlSetting_Select = "SELECT d.* FROM data_apps_setting d WHERE d.title = 'HOME_BANNER_BACKGROUND' ";
		$RstSetting_Select = $this->db->query($SqlSetting_Select)->row();
		if(!empty ($RstSetting_Select)) {
			$MainData["BANNER_BG"] = $RstSetting_Select->data;
		}

		// if ( $DWMode == "TEST" ) {
		// 	echo "<pre>";
		// 	print_r($MainData);
		// 	echo "</pre>";
		// }
	echo json_encode($MainData);
	}

	public function api_voucher() //belum finalise
	{
		// $DWMode = $_REQUEST["display_mode"];
		//$contact_no = ReturnValidContact($_REQUEST["contactno"]);
		$phone = '0127313401'; 
		$contact_no = $this->ReturnValidContact($phone);

		if ( $contact_no != "" ) {

			$cust_point = 1000;
			$cust_id = 0;
			$SqlCust_Select = "SELECT d.* FROM data_customer d WHERE d.active > 0 AND d.contact_no = '".$contact_no."' LIMIT 1";
			$RstCust_Select = $this->db->query($SqlCust_Select)->row();
			if (!empty($RstCust_Select)) {
				$cust_id = $RstCust_Select->id;
				$cust_point = $RstCust_Select->point;
			}
			$MainData["CUST_INFO"]["POINT"] = $cust_point;

			/*
				Add Voucher Claim Option
			*/
			$SqlClaim_Select = "SELECT i.* FROM `data_voucher` i WHERE i.active = 0 AND i.start_date <= '".date("Y-m-d")."' AND i.end_date >= '".date("Y-m-d")."' AND i.active = 1 ORDER BY i.info_display_from ";
			$RstClaim_Select = $this->db->query($SqlClaim_Select)->row();
			if(!empty($RstClaim_Select)) {
				$VoucherData["id"] = $RstClaim_Select->id;
				$VoucherData["image"] = $RstClaim_Select->claim_image;
				$VoucherData["point"] = $RstClaim_Select->claim_point;
				$MainData["VOUCHER_CLAIM"][] = $VoucherData;
			}

			/*
			$VoucherData["id"] = "1";
			$VoucherData["image"] = "http://810speedmart.com/api/images/sample_claim_voucher.png";
			$VoucherData["point"] = "250";
			$MainData["VOUCHER_CLAIM"][] = $VoucherData;

			$VoucherData["id"] = "1";
			$VoucherData["image"] = "http://810speedmart.com/api/images/sample_claim_voucher.png";
			$VoucherData["point"] = "250";
			$MainData["VOUCHER_CLAIM"][] = $VoucherData;

			$VoucherData["id"] = "1";
			$VoucherData["image"] = "http://810speedmart.com/api/images/sample_claim_voucher.png";
			$VoucherData["point"] = "250";
			$MainData["VOUCHER_CLAIM"][] = $VoucherData;
			*/

			/*
				Add Voucher Claim Option
			*/
			$SqlVou_Select = "SELECT v.*, i.info_validity_from, i.info_validity_to, i.info_value, i.redeem_image, i.redeem_image_used, i.redeem_image_header, i.redeem_tnc FROM `data_voucher` v INNER JOIN `data_voucher_info` i ON (i.id=v.info_id AND i.active=1) WHERE i.allow_claim = 0 AND i.info_validity_from <= '".date("Y-m-d")."' AND i.info_validity_to >= '".date("Y-m-d")."' AND v.active IN (1,2) AND v.customer_id = '".$cust_id."' ORDER BY v.active, i.info_display_from ";
			$RstVou_Select = $this->db->query($SqlVou_Select)->row();
			if (!empty($RstVou_Select)) {
				$MyData["id"] = $RstVou_Select->id;
				$MyData["active"] = $RstVou_Select->active;
				if ( $VouData["active"] == 2 ) {
					$MyData["image"] = $RstVou_Select->redeem_image_used;
					$MyData["id"] = 0;
				} else {
					$MyData["image"] = $RstVou_Select->redeem_image;
				}
				$MyData["image_detail"] = $RstVou_Select->redeem_image_header;
				$MyData["image_barcode"] = "http://sys.senheng.com.my/senhengmobile/senhengapps/cms/php-barcode/barcode.php?size=45&text=".$RstVou_Select["voucher_code"]."&print=false";
				$MyData["image_barcode_v"] = "http://sys.senheng.com.my/senhengmobile/senhengapps/cms/php-barcode/barcode.php?size=45&text=".$RstVou_Select["voucher_code"]."&print=true";
				$MyData["image_detail_tnc"] = $RstVou_Select->redeem_tnc;
				$MainData["VOUCHER_MY"][] = $MyData;
			}

			/*
			$MyData["id"] = "1";
			$MyData["image"] = "http://810speedmart.com/api/images/sample_my_voucher.png";
			$MyData["image_detail"] = "http://810speedmart.com/api/images/sample_my_voucher_header.png";
			$MyData["image_barcode"] = "http://810speedmart.com/api/images/sample_my_voucher_header.png";
			$MyData["image_detail_tnc"] = "asdfasdf";
			$MainData["VOUCHER_MY"][] = $MyData;

			$MyData["id"] = "1";
			$MyData["image"] = "http://810speedmart.com/api/images/sample_my_voucher.png";
			$MyData["image_detail"] = "http://810speedmart.com/api/images/sample_my_voucher_header.png";
			$MyData["image_barcode"] = "http://810speedmart.com/api/images/sample_my_voucher_header.png";
			$MyData["image_detail_tnc"] = "asdfasdf";
			$MainData["VOUCHER_MY"][] = $MyData;
			*/

			$MainData["status"] = "1";
			$MainData["status_message"] = "";
		} else {
			$MainData["ACCOUNT_IMAGE"] = "";
			$MainData["status"] = "0";
			$MainData["status_message"] = "Need Login";
		}

		$SqlSetting_Select = "SELECT d.* FROM data_apps_setting d WHERE d.title = 'HOME_BANNER_BACKGROUND' ";
		$RstSetting_Select = $this->db->query($SqlSetting_Select)->row();
		if(!empty($RstSetting_Select)) {
			$MainData["BANNER_BG"] = $RstSetting_Select->data;
		}
		
		if ( $DWMode == "TEST" ) {
			echo "<pre>";
			print_r($MainData);
			echo "</pre>";
		}
	
	echo json_encode($MainData);
	}
}