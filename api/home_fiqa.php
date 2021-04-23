<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/home.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://cloone.my".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	//******************************************************************

	$con = getdb();
	$Sql_Select = "SELECT d.* FROM screens d WHERE d.active = 1";
	$Rst_Select = mysqli_query($con,$Sql_Select);

	//$row = mysqli_fetch_array($Rst_Select);

	if(mysqli_num_rows($Rst_Select) > 0)
		while($row = mysqli_fetch_array($Rst_Select)) {

		$data['DWID'] = $row["id"];
		$data['DWActive'] = $row["active"]; 
		$data['title'] = $row["title"]; 
		$data['description'] = $row["description"]; 
		$data['attachment'] = $row["attachment"];

		$rowAll[] = $data;
		$status = 1;
		$status_message = 'Success display home details.';
		$firstpage = '/tabs/home' ;

	}else{

		$rowAll[] = ''; 
		$status = 0;
		$status_message = 'No data found';
		$firstpage = '' ;

	}
			// if ( $DWActive == 1 ) {
				
			// 	$MainData["title"] = $title;
			// 	$MainData["description"] = $description;
			// 	$MainData["attachment"] = $attachment;	

			// 	$MainData["firstpage"] = "/tabs/home";
			// 	$MainData["status"] = "1";
			// 	$MainData["status_message"] = "Success display home details.";
			// } else {
			// 	//
			// 	// Contact is Activated
			// 	$MainData["status"] = "0";
			// 	$MainData["status_message"] = "No data found";
			// }
	$MainData["HOME"] = $rowAll;
	$MainData["firstpage"] = $firstpage;
	$MainData["status"] = $status;
	$MainData["status_message"] = $status_message;
	echo json_encode($MainData);
	exit;
?>