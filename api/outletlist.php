<?php
	include 'conf.php';

	$con = getdb();
	mysqli_set_charset($con, "utf8");
		
	$Sql_Select = "SELECT id,store_name FROM store_locations WHERE active = 1";
	$Rst_Select = mysqli_query($con,$Sql_Select);

	// if (mysqli_num_rows($Rst_Select) > 0) {
	//   // output data of each row
	//   while($row = mysqli_fetch_assoc($Rst_Select)) {
	//     echo "id: " . $row["id"]. ", Outlet: " . $row["store_name"]. "\n";
	//   }
	// } else {
	//   	echo "0 results";
	// }

	// mysqli_close($con);

	if ( mysqli_num_rows($Rst_Select) > 0 ) {

		while ($row = mysqli_fetch_assoc($Rst_Select)) {
			$outlet["id"] 	= $row["id"];
			$outlet["name"]   = $row["store_name"];
				
			$rowAllResult[] = $outlet;
		}

			$MainData["status"] = "1";
			$MainData["status_message"] = "Listing Successfully.";



		} else {

			$rowAllResult[] = '';
			$MainData["status"] = "0";
			$MainData["status_message"] = "Sorry, no outlet found. Please try again";
		}

		$MainData["outlet"] = $rowAllResult;
	
	echo json_encode($MainData);
	exit;
?>
