<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/about.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://cloone.my".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	//******************************************************************

	$con = getdb();
	$Sql_Select = "SELECT d.* FROM abouts d WHERE d.active = 1";
	$Rst_Select = mysqli_query($con,$Sql_Select);

	if ( mysqli_num_rows($Rst_Select) > 0 ) {

		$row = mysqli_fetch_assoc($Rst_Select);
		$row;

		$id    = $row["id"];
		$title  = $row["title"]; 
		$description = $row["description"]; 
		$attachment = "http://cloone.my/demo/starglory-admin/assets/upload_files/abouts/". $row["attachment"];

		// $rowAll[] = $data;
		$status = 1;
		$status_message = 'Success display account details.';
		$firstpage["firstpage"] = "/tabs/home";
		}
		else {
			// $rowAll[] = ''; 
			$status = 0;
			$status_message = 'No data found';
			$firstpage = '' ;
		}
	
	$MainData = array();
	
	$MainData["id"] = $id;
	$MainData["title"] = $title;
	$MainData["description"] = $description;
	$MainData["attachment"] = $attachment;
	// $MainData["ABOUTS"] = $rowAll;
	$MainData["firstpage"] = $firstpage;
	$MainData["status"] = $status;
	$MainData["status_message"] = $status_message;

		// echo $description;

	// $test = array();

	// $test['t1'] = 't1';
	
	echo json_encode($MainData);
	exit;
?>

<!-- <img src="{{ }}" alt=""> -->