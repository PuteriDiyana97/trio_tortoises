<?php
include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

		****************************************************************** */
		$req_dump = print_r($_REQUEST, TRUE);
		$fp = fopen('logs/ereceipt.txt'.date("Y-m-d").'.txt', 'a');
		fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://stargloryasia.com/".$_SERVER['REQUEST_URI']."\n".$req_dump);
		fclose($fp);


	/* ******************************************************************

		Query Function & Print JSON Data
		810 Member Voucher API
		Sample URL: http://810speedmart.com/api/voucher.php?contactno=[CONTACTNO or '' (EMPTY)]

		Return Info

		****************************************************************** */
	$id = $_REQUEST["id"];

	$con = getdb();
	$Sql_er_Select = "SELECT * FROM data_customer_points a WHERE id = '".$id."'";
	$Rst_er_Select = mysqli_query($con,$Sql_er_Select);
	if(mysqli_num_rows($Rst_er_Select) > 0){

		while($row = mysqli_fetch_array($Rst_er_Select)) {

			$dataVoucher['description']  = $row["description"];

			$desc = str_replace("Sales for ","",$row["description"]);
			$desc = str_replace("Void for ","",$desc);
			$desc = str_replace(" ","",$desc);

			
		    $SqlCust_Select = "SELECT *,(select outlet from data_sales_transaction_detail where sales_transaction_id = a.id limit 1) as outlet,(select terminal_point from data_sales_transaction_detail where sales_transaction_id = a.id limit 1) as terminal_point FROM data_sales_transaction a WHERE trxnum = '".$desc."'";
			$RstCust_Select = mysqli_query($con,$SqlCust_Select);

			if(mysqli_num_rows($RstCust_Select) > 0){

				while($row = mysqli_fetch_array($RstCust_Select)) {

					$dataVoucher['trxnum']  = $row["trxnum"];
					$dataVoucher['trxdate'] = $row["trxdate"]; 
					$dataVoucher['outlet']  = $row["outlet"];
					$dataVoucher['terminal_point']  = $row["terminal_point"];

					$folder1 = date('my',strtotime($row["trxdate"]));
					$folder2 = date('Ymd',strtotime($row["trxdate"]));
					$date    = date('dmY',strtotime($row["trxdate"]));
						
						if($row["active"] == 1){

							$active = "SA";


						}else if($row["active"] == 3){

							$active = "VD";

						}
					$terminal = $row["terminal_point"];
					$trxnum = $row["trxnum"];
					$dataVoucher['ereceipt'] =$ereceipt= "http://www.starglorygroup.com/".$folder1."/".$folder2."/".$date.$row["outlet"].$terminal.$trxnum.$active.".jpg";
					//$dataVoucher['ereceipt'] = "http://stargloryasia.com/0820/20200831/31082020BA001M106R14752SA.jpg";
					$dataVoucher["base64_image"] =  "data:image/jpeg;base64,".base64_encode($ereceipt); 
					
					$rowAll[] = $dataVoucher;

					$status = 1;
					$status_message = 'Success display ereceipt details.';
					$firstpage = '/tabs/home' ;


				}
			}else{

				$rowAll[]       = ''; 
				$status         = 0;
				$status_message = 'No trxnum found';


			}
		}
	}else{

		$rowAll[]       = ''; 
		$status         = 0;
		$status_message = 'No id found';

	}

	$MainData["ereceipt"]       = $rowAll;
	$MainData["status"]         = $status;
	$MainData["status_message"] = $status_message;

	echo json_encode($MainData);


	exit;


	?>



