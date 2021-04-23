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
	$Sql_Select = "SELECT d.* FROM screens d WHERE d.active = 1 ORDER BY d.created DESC";
	$Rst_Select = mysqli_query($con,$Sql_Select);

	if(mysqli_num_rows($Rst_Select) > 0)
		while($row = mysqli_fetch_array($Rst_Select)) {

		$data['id'] = $row["id"];
		$data['active'] = $row["active"]; 
		$data['title'] = $row["title"]; 
		$data['description'] = $row["description"]; 
		$data['attachment'] = "http://cloone.my/demo/starglory-admin/assets/upload_files/home_screen/". $row["attachment"];

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
		
	$MainData["HOME"] = $rowAll;
	$MainData["firstpage"] = $firstpage;
	$MainData["status"] = $status;
	$MainData["status_message"] = $status_message;
	
	echo json_encode($MainData);
	exit;
?>

<img src="{{ }}" alt="">