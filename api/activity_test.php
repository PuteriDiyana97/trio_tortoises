<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/account_test.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://stargloryasia.com/".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************

		Query Function & Print JSON Data
		810 Member Edit API
		Sample URL: http://810speedmart.com/api/member_edit.php?contactno=[CONTACTNO or '' (EMPTY)]&info={"password":"YIJAKJDW","email":"test@example.com"}
		Pass Info
		- info (JSON Format)
			- password
			- email

		Return Info
		- status - Info = 0: Error, 1: Success
		- status_message = Show Status Message

	****************************************************************** */
	$DWUserContact = '60107631360';//ReturnValidContact($_REQUEST["contactno"]);
	//$page = '1';//$_REQUEST["page"];
	
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

		if(empty($col_parent_contact_no) || $col_parent_contact_no == '')
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

	///////////UNTUK TAHU POINT CUSTOMER//////////////////


	$DWCustPoint = 0;
	$SqlCust_Select = "SELECT d.* FROM data_customer d WHERE d.active > 0 AND d.contact_no = '".$DWUserContact."'";
	$RstCust_Select = mysqli_query($con,$SqlCust_Select);

	if (mysqli_num_rows($RstCust_Select) > 0) {
		$DWCustPoint = getTotal_point($DWUserContact);
	}
	
	///////////UNTUK TAHU POINT CUSTOMER//////////////////
	$page_setting = ($page -1)*10;
	$Sql_SelectActivity = "SELECT d.* FROM data_customer_points d WHERE d.active = 1 AND d.contact_no = '".$DWUserContact."' ORDER BY d.created DESC";
	// LIMIT 10 OFFSET '".$page_setting."'
	$Rst_SelectActivity = mysqli_query($con,$Sql_SelectActivity);

	if ( mysqli_num_rows($Rst_SelectActivity) > 0 ) {

		while($row = mysqli_fetch_array($Rst_SelectActivity)) {

		$date = $row["transaction_date"];
		$dataActivity['id'] = $row["id"]; 
		$dataActivity['points'] = $row["points"]; 
		$dataActivity['point_type'] = $row["point_type"]; 
		$dataActivity['description'] = $row["description"]; 
		$dataActivity['transaction_date']  = date("d/m/Y H:i", strtotime($date));
		
		if($row["description"]){


		}

		$a = 'Sales for';
		$b = 'Void for ';

	    if(strpos($row["description"], $a) !== false) {
				    
		   $dataActivity['ereceipt']  = 1;
	

		}else if(strpos($row["description"], $b) !== false){

			$dataActivity['ereceipt']  = 1;

		}else{

			$dataActivity['ereceipt']  = 0;
		}


		if($dataActivity['ereceipt'] == 1){

			$Sql_er_Select = "SELECT * FROM data_customer_points a WHERE id = '".$row["id"]."'";
	        $Rst_er_Select = mysqli_query($con,$Sql_er_Select);
	        if(mysqli_num_rows($Rst_er_Select) > 0){

		   while($row = mysqli_fetch_array($Rst_er_Select)) {

			$dataVoucher['description']  = $row["description"];

			$desc = str_replace("Sales for ","",$row["description"]);
			$desc = str_replace("Void for ","",$desc);
			$desc = str_replace(" ","",$desc);

			$desc_explode = explode(' for ', $row["description"]);

			if($desc_explode[0] == 'Sales'){

				$active_sales = '1';

			}else{
				$active_sales = '3';
			}

			
		    $SqlCust_Select = "SELECT *,(select outlet from data_sales_transaction_detail where sales_transaction_id = a.id limit 1) as outlet,(select terminal_point from data_sales_transaction_detail where sales_transaction_id = a.id limit 1) as terminal_point FROM data_sales_transaction a WHERE trxnum = '".$desc."' and active= '".$active_sales."'";
			$RstCust_Select = mysqli_query($con,$SqlCust_Select);

			if(mysqli_num_rows($RstCust_Select) > 0){

				while($row = mysqli_fetch_array($RstCust_Select)) {

					$dataActivity['trxnum']  = $row["trxnum"];
					$dataActivity['trxdate'] = $row["trxdate"]; 
					$dataActivity['outlet']  = $row["outlet"];
					$dataActivity['terminal_point']  = $row["terminal_point"];
					$dataActivity['terminal'] = $terminalID = $row["terminal"];

					$folder1 = date('my',strtotime($row["trxdate"]));
					$folder2 = date('Ymd',strtotime($row["trxdate"]));
					$date    = date('dmY',strtotime($row["trxdate"]));
						
						if($row["active"] == 1){

							$active = "SA";


						}else if($row["active"] == 3){

							$active = "VD";

						}

						

								$trxnum = $row["trxnum"];

					$outlet = 'BA001';//$date.$row["outlet"]
					
					 // echo getcwd(); //show the path
					$dir = "/home/starglo/public_html/".$folder1."/".$folder2."/";
					
					$files = scandir($dir);
					$name_file = '';
					$terminal = 'M901R';
					if($terminalID != ''){
						$terminal = $terminalID;

						$trxnum_type = $terminal.$trxnum.$active;
						foreach ($files as $file) {
							
							if (strpos($file,$trxnum_type) > 0 ) {
							         // echo 'status : +++file found';
							         // echo "<br>";

								$name_file = $file;
							}
							// else{

							// 	$name_file = '';
							//     	  // echo 'status : ------not file found';
							//     	  // echo "<br>";
							// }
						}

					}else{

						$trxnum_type = $trxnum.$active;
						foreach ($files as $file) {
							// echo 'file : '.$file;
							//          echo "<br>";
							//          echo 'trxnum_type : '.$trxnum_type;
							//          echo "<br>";

							if (strpos($file,$trxnum_type) > 0 ) {
							         // echo 'status : +++file found';
							         // echo "<br>";

								$name_file = $file;

							}
							// else{

							// 	$name_file = '';
							//     	  echo 'status : ------not file found';
							//     	  echo "<br>";
							// }
						}
					}

					//die();
					//echo $name_file;
					if(!empty($name_file) && $name_file != ''){

						// $dataActivity['ereceipt'] =$ereceipt= "http://www.starglorygroup.com/".$folder1."/".$folder2."/".$date.$outlet.$terminal.$trxnum.$active.".jpg";

						$dataActivity['ereceipt'] =$ereceipt= "http://www.starglorygroup.com/".$folder1."/".$folder2."/".$name_file;

						$dataActivity["base64_image"] =  "data:image/jpeg;base64,".base64_encode($ereceipt); 

					}else{

						
						$dataActivity['ereceipt'] ='';

						$dataActivity["base64_image"] =  ''; 

					}
					
					
				}

				}
			}
		}
	}

		$rowAllActivity[] = $dataActivity;
		$status = 1;
		$status_message = 'Success display activity details.';
		$firstpage = '/tabs/home' ;
		}
	}
	else {
		$rowAllActivity = array();		
		$status = 0;
		$status_message = 'No data found';
		$firstpage = '' ;
	}

	$MainData["myActivity"] = $rowAllActivity;
	$MainData["contactno"] = $DWUserContact;
	$MainData["firstpage"] = $firstpage;
	$MainData["status"] = $status;
	$MainData["status_message"] = $status_message;
	$MainData["POINT"] = $DWCustPoint;
	// $MainData["photo"] = $photo;

	
	echo json_encode($MainData);
	exit;
?>