<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/account_edit_photo.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://stargloryasia.com/".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************
		Return Info
		- status - Info = 0: Error, 1: Success
		- status_message = Show Status Message

	****************************************************************** */
	$DWUserContact = ReturnValidContact($_REQUEST["contactno"]);
	$photo 	= ($_REQUEST["photo"]);
	//$picture 	= "http://cloone.my/demo/starglory-admin/assets/upload_files/profile_picture/". $picture;
	
	if(empty($photo))
	{
		$MainData["contactno"] = $DWUserContact;
		$MainData["status"] = "0";
		$MainData["status_message"] = "Unable to update your info. Please try again.";
		die();
	}
	$con = getdb(); 

	function generateImage($photo)
    {

        $folderPath = "../assets/upload_files/profile_picture/";//"http://cloone.my/demo/starglory-admin/assets/upload_files/profile_picture/";

        $image_parts = explode(";base64,", $photo);

        $image_type_aux = explode("image/", $image_parts[0]);	

        $image_type = $image_type_aux[1];

		$image_base64 = base64_decode($image_parts[1]);
		
		$file_name = uniqid() . '.png';
        $file = $folderPath . $file_name;
		$res = file_put_contents($file, $image_base64);

		return array('path_file'=>$file,'file_name'=>$file_name,);

	}

	$image_res_arr = generateImage($photo);
	// $image_res_arr['path_file']
	// $image_res_arr['file_name']
	
	$Sql_Select = "SELECT * FROM data_customer WHERE contact_no = '".$DWUserContact."' AND active = 1 LIMIT 1";
	$Rst_Select = mysqli_query($con,$Sql_Select);

	if ( mysqli_num_rows($Rst_Select) > 0 ) {

	$Rst_Select = mysqli_query($con,$Sql_Select);

		if ( mysqli_num_rows($Rst_Select) > 0 ) {

			$row = mysqli_fetch_assoc($Rst_Select);
			$row;
			$DWID = $row["id"];
			$DWActive = $row["active"];


			// Update Info 
			$Sql_Update = "UPDATE data_customer SET profile_picture = '".$image_res_arr['file_name']."', active = 1 WHERE id = '".$DWID."'";

			$Rst_Update = mysqli_query($con,$Sql_Update);

			$MainData["contactno"] = $DWUserContact;
			$MainData["profile_picture"]  = $image_res_arr['file_name'];
			// $MainData["profile_picture"]  = "http://cloone.my/demo/starglory-admin/assets/upload_files/profile_picture/". $row["profile_picture"];
				
			$MainData["status"] = "1";
			$MainData["status_message"] = "Your info has been updated, thank you.";
		} else {
			$MainData["contactno"] = $DWUserContact;
			$MainData["status"] = "0";
			$MainData["status_message"] = "Unable to update your info. Please try again.";
		}

	}else{
		$MainData["contactno"] = $DWUserContact;
		$MainData["status"] = "0";
		$MainData["status_message"] = "Please try again";
	}	
	
	echo json_encode($MainData);
	exit;
?>