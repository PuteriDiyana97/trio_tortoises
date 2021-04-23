<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/promotion_category.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://stargloryasia.com/".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	// *******************************************************************

	$con = getdb();
	$Sql_Select = "SELECT f.* FROM promotion_categories f WHERE f.active = 1 ORDER BY f.priority_no";
	$Rst_Select = mysqli_query($con,$Sql_Select);
	
	if(mysqli_num_rows($Rst_Select) > 0)
		while($row = mysqli_fetch_array($Rst_Select)) {

		$data['category_id'] = $row["id"]; 
		$data['category'] = $row["category"]; 

		$rowAll[] = $data;
		$status = 1;
		$status_message = 'Success display promotion category details.';
		$firstpage = '/tabs/home' ;

	}else{

		$rowAll[] = ''; 
		$status   = 0;
		$status_message = 'No data found';
		$firstpage = '' ;

	}

	$MainData["PROMOTION_CATEGORIES"] = $rowAll;
	$MainData["firstpage"] = $firstpage;
	$MainData["status"] = $status;
	$MainData["status_message"] = $status_message;
			
	echo json_encode($MainData);
	exit;
?>