<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/news.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://stargloryasia.com/".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	//******************************************************************

	$con = getdb();
	mysqli_set_charset($con, "utf8");
	$Sql_Select = "SELECT d.* FROM news d WHERE d.active = 1 AND DATE(d.start_date) <= '".date("Y-m-d")."' AND DATE(d.expiry_date) >= '".date("Y-m-d")."' ORDER BY d.expiry_date ASC";
	$Rst_Select = mysqli_query($con,$Sql_Select);

	if(mysqli_num_rows($Rst_Select) > 0)
		while($row = mysqli_fetch_array($Rst_Select)) {

			$data['id'] 		= $row["id"];
			$data['title'] 		= $row["title"]; 
		
			//--diyana--
			$string = $row["description"];
			$trans = array("\r\n" => "<br>","\"" => "", "//www." => "https://www.","width=\"640\"" => "width=100%", "height=\"360\"" => "height=100%", "https:" => "");
			$description = strtr($string,$trans);
			$data['description'] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $description);
			//--diyana--
			
			//$data['description'] = str_replace("\r\n", "<br>", $row["description"]);
			$data['attachment'] = $_URL."assets/upload_files/news/". $row["attachment"];
			$data['start_date']  = $row["start_date"];
			$data['expiry_date'] = $row["expiry_date"]; 
			$data['push_news'] = $row["push_news"];
			$data['news_read'] = $row["news_read"]; ;

		$rowAll[] = $data;
		$status = 1;
		$status_message = 'Success display news.';
		$firstpage = '/tabs/home' ;

	}else{

		$rowAll[] = ''; 
		$status = 0;
		$status_message = 'No data found';
		$firstpage = '' ;

	}

	$MainData["NEWS"] = $rowAll;
	$MainData["firstpage"] = $firstpage;
	$MainData["status"] = $status;
	$MainData["status_message"] = $status_message;

	echo json_encode($MainData);
	exit;
?>