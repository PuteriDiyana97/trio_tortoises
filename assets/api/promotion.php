<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/promotion.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://cloone.my".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	// *******************************************************************

	$con = getdb();
	$Sql_Select = "SELECT d.*, dc.category FROM promotions d LEFT JOIN promotion_categories dc ON (dc.id = d.promotion_category_id) WHERE d.active = 1 AND DATE(d.start_date) <= '".date("Y-m-d")."' AND DATE(d.expiry_date) >= '".date("Y-m-d")."' ORDER BY d.expiry_date ASC";
	$Rst_Select = mysqli_query($con,$Sql_Select);
	
	if(mysqli_num_rows($Rst_Select) > 0)
		while($row = mysqli_fetch_array($Rst_Select)) {

		$data['promotion_id'] = $row["id"]; 
		$data['promotion_category_id'] = $row["promotion_category_id"]; 
		$data['title'] 		  = $row["title"]; 
		$data['category'] 		  = $row["category"]; 
		$data['description']  = $row["description"]; 
		$data['attachment'] = "http://cloone.my/demo/starglory-admin/assets/upload_files/promotion/". $row["attachment"];
		$data['start_date']   = $row["start_date"];
		$data['expiry_date']  = $row["expiry_date"]; 
		$data['push_promotion'] = $row["push_promotion"]; //0:not publish 1:published

		$rowAll[] = $data;
		$status = 1;
		$status_message = 'Success display promotion details.';
		$firstpage = '/tabs/home' ;

	}else{

		$rowAll[] = ''; 
		$status   = 0;
		$status_message = 'No data found';
		$firstpage = '' ;

	}

	$MainData["PROMOTION"] = $rowAll;
	$MainData["firstpage"] = $firstpage;
	$MainData["status"] = $status;
	$MainData["status_message"] = $status_message;
			
	echo json_encode($MainData);
	exit;
?>