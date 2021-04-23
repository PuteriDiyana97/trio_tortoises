<html>

<head>
<style>
body {
    font-family: Arial;
}
 table {
  border-collapse: collapse;
}

table, th, td {
  padding:5px;
  border: 1px solid #efefef;
}

th {
    background:#5BC236;
    color:white;
    text-align:left;
}
</style>
</head>

<body>
<?php
    include 'conf.php';

    if ( $_REQUEST["ki"] != "JK5Ysadf.yasdU91A-" ) {
    	exit;
    }

    $DWRepeatCust_Non = $DWRepeatCustM2 = $DWRepeatCustM3 = $DWRepeatCustM4 = $DWRepeatCustM5 = $DWRepeatCustM10 = 0;

    //echo "<br />".
	$Sql_Select = "SELECT SUM(s.trxtotal) AS TotalSales, COUNT(s.trxtotal) AS TotalTransaction, s.sbclient_id, MAX(s.trxdate) AS LastTransaction, '0' AS LastTransactionAmount, c.name, c.gender, c.race FROM data_sales_transaction s INNER JOIN data_customer c ON (c.sbclient_id=s.sbclient_id) WHERE s.active = 1 GROUP BY s.sbclient_id, c.name, c.gender, c.race ORDER BY TotalSales DESC";
	$Rst_Select = mysql_query($Sql_Select);
	while ( $RowData = mysql_fetch_assoc($Rst_Select) ) {

		/*
		$DWRepeatCust_Non += ($RowData["TotalTransaction"]==1 ? 1 : 0);
		$DWRepeatCustM2 += ($RowData["TotalTransaction"]==2 ? 1 : 0);
		$DWRepeatCustM3 += ($RowData["TotalTransaction"]==3 ? 1 : 0);
		$DWRepeatCustM4 += ($RowData["TotalTransaction"]==4 ? 1 : 0);
		*/

		//
		// More and Equal 10 times
		if ( $RowData["TotalTransaction"]>=10 ) {
			$DWRepeatCustM10 += 1;
			$DWGender10_M += ($RowData["gender"]=='MALE' ? 1 : 0);
			$DWGender10_F += ($RowData["gender"]=='FEMALE' ? 1 : 0);
			$DWRace10_M += ($RowData["race"]=='MALAY' ? 1 : 0);
			$DWRace10_C += ($RowData["race"]=='CHINESE' ? 1 : 0);
			$DWRace10_I += ($RowData["race"]=='INDIAN' ? 1 : 0);
			$DWRace10_O += ($RowData["race"]!='MALAY' && $RowData["race"]!='CHINESE' && $RowData["race"]!='INDIAN' ? 1 : 0);
		}

		//
		// More and Equal 5 times and Less than 10 times
		if ( $RowData["TotalTransaction"]>=5 && $RowData["TotalTransaction"]<10 ) {
			$DWRepeatCustM5 += 1;
			$DWGender5_M += ($RowData["gender"]=='MALE' ? 1 : 0);
			$DWGender5_F += ($RowData["gender"]=='FEMALE' ? 1 : 0);
			$DWRace5_M += ($RowData["race"]=='MALAY' ? 1 : 0);
			$DWRace5_C += ($RowData["race"]=='CHINESE' ? 1 : 0);
			$DWRace5_I += ($RowData["race"]=='INDIAN' ? 1 : 0);
			$DWRace5_O += ($RowData["race"]!='MALAY' && $RowData["race"]!='CHINESE' && $RowData["race"]!='INDIAN' ? 1 : 0);
		}

		//
		// Equal 4 times
		if ( $RowData["TotalTransaction"]==4 ) {
			$DWRepeatCustM4 += 1;
			$DWGender4_M += ($RowData["gender"]=='MALE' ? 1 : 0);
			$DWGender4_F += ($RowData["gender"]=='FEMALE' ? 1 : 0);
			$DWRace4_M += ($RowData["race"]=='MALAY' ? 1 : 0);
			$DWRace4_C += ($RowData["race"]=='CHINESE' ? 1 : 0);
			$DWRace4_I += ($RowData["race"]=='INDIAN' ? 1 : 0);
			$DWRace4_O += ($RowData["race"]!='MALAY' && $RowData["race"]!='CHINESE' && $RowData["race"]!='INDIAN' ? 1 : 0);
		}

		//
		// Equal 3 times
		if ( $RowData["TotalTransaction"]==3 ) {
			$DWRepeatCustM3 += 1;
			$DWGender3_M += ($RowData["gender"]=='MALE' ? 1 : 0);
			$DWGender3_F += ($RowData["gender"]=='FEMALE' ? 1 : 0);
			$DWRace3_M += ($RowData["race"]=='MALAY' ? 1 : 0);
			$DWRace3_C += ($RowData["race"]=='CHINESE' ? 1 : 0);
			$DWRace3_I += ($RowData["race"]=='INDIAN' ? 1 : 0);
			$DWRace3_O += ($RowData["race"]!='MALAY' && $RowData["race"]!='CHINESE' && $RowData["race"]!='INDIAN' ? 1 : 0);
		}

		//
		// Equal 2 times
		if ( $RowData["TotalTransaction"]==2 ) {
			$DWRepeatCustM2 += 1;
			$DWGender2_M += ($RowData["gender"]=='MALE' ? 1 : 0);
			$DWGender2_F += ($RowData["gender"]=='FEMALE' ? 1 : 0);
			$DWRace2_M += ($RowData["race"]=='MALAY' ? 1 : 0);
			$DWRace2_C += ($RowData["race"]=='CHINESE' ? 1 : 0);
			$DWRace2_I += ($RowData["race"]=='INDIAN' ? 1 : 0);
			$DWRace2_O += ($RowData["race"]!='MALAY' && $RowData["race"]!='CHINESE' && $RowData["race"]!='INDIAN' ? 1 : 0);
		}

		//
		// Equal 1 time
		if ( $RowData["TotalTransaction"]==1 ) {
			$DWRepeatCustM1 += 1;
			$DWGender1_M += ($RowData["gender"]=='MALE' ? 1 : 0);
			$DWGender1_F += ($RowData["gender"]=='FEMALE' ? 1 : 0);
			$DWRace1_M += ($RowData["race"]=='MALAY' ? 1 : 0);
			$DWRace1_C += ($RowData["race"]=='CHINESE' ? 1 : 0);
			$DWRace1_I += ($RowData["race"]=='INDIAN' ? 1 : 0);
			$DWRace1_O += ($RowData["race"]!='MALAY' && $RowData["race"]!='CHINESE' && $RowData["race"]!='INDIAN' ? 1 : 0);
		}



		$SqlLast_Select = "SELECT * FROM data_sales_transaction WHERE sbclient_id = '".$RowData["sbclient_id"]."' AND active = 1 ORDER BY created DESC LIMIT 1";
		$SqlLast_Select = mysql_query($SqlLast_Select);
		if ( mysql_num_rows($SqlLast_Select) > 0 ) {
			$RowData["LastTransactionAmount"] = mysql_result($SqlLast_Select, 0, "trxtotal");
		}

		$DWInfo[] = $RowData;

	}
	echo "</table>";

	echo "Total Repeating Customers >= 10: <strong>".$DWRepeatCustM10."</strong> <br/ >(Male: ".$DWGender10_M.", Female: ".$DWGender10_F.")<br/ > (MALAY: ".$DWRace10_M.", CHINESE: ".$DWRace10_C.", INDIAN: ".$DWRace10_I.", OTHERS: ".$DWRace10_O.") ";
	echo "<br/ ><br/ >Total Repeating Customers >= 5 & <= 9: <strong>".$DWRepeatCustM5."</strong><br/ > (Male: ".$DWGender5_M.", Female: ".$DWGender5_F.") <br/ >(MALAY: ".$DWRace5_M.", CHINESE: ".$DWRace5_C.", INDIAN: ".$DWRace5_I.", OTHERS: ".$DWRace5_O.") ";
	echo "<br/ ><br/ >Total Repeating Customers = 4: <strong>".$DWRepeatCustM4." </strong><br/ >(Male: ".$DWGender4_M.", Female: ".$DWGender4_F.") <br/ >(MALAY: ".$DWRace4_M.", CHINESE: ".$DWRace4_C.", INDIAN: ".$DWRace4_I.", OTHERS: ".$DWRace4_O.") ";
	echo "<br/ ><br/ >Total Repeating Customers = 3: <strong>".$DWRepeatCustM3." </strong><br/ >(Male: ".$DWGender3_M.", Female: ".$DWGender3_F.") <br/ >(MALAY: ".$DWRace3_M.", CHINESE: ".$DWRace3_C.", INDIAN: ".$DWRace3_I.", OTHERS: ".$DWRace3_O.") ";
	echo "<br/ ><br/ >Total Repeating Customers = 2: <strong>".$DWRepeatCustM2." </strong><br/ >(Male: ".$DWGender2_M.", Female: ".$DWGender2_F.") <br/ >(MALAY: ".$DWRace2_M.", CHINESE: ".$DWRace2_C.", INDIAN: ".$DWRace2_I.", OTHERS: ".$DWRace2_O.") ";
	echo "<br/ ><br/ >Total Non-Repeating Customers: <strong>".$DWRepeatCustM1." </strong><br/ >(Male: ".$DWGender1_M.", Female: ".$DWGender1_F.") <br/ >(MALAY: ".$DWRace1_M.", CHINESE: ".$DWRace1_C.", INDIAN: ".$DWRace1_I.", OTHERS: ".$DWRace1_O.") ";
	echo "<br/ ><br/ >Total Members with Sales Transaction(s): <strong>".COUNT($DWInfo);

	echo "</strong><br /><br /><table border=1 >";
    	echo "<tr>";
    		echo "<th>Contact No</th>";
    		echo "<th>Member Name</th>";
			echo "<th>Total Amount</th>";
			echo "<th>No. of Trasactions</th>";
			echo "<th>Last Transaction</th>";
			echo "<th>Last Amount</th>";
		echo "</tr>";

	for ( $i=0; $i<COUNT($DWInfo); $i++ ) {

		echo "<tr>";
			echo "<td>".$DWInfo[$i]["sbclient_id"]."</td>";
			echo "<td>".$DWInfo[$i]["name"]."</td>";
			echo "<td>".$DWInfo[$i]["TotalSales"]."</td>";
			echo "<td>".$DWInfo[$i]["TotalTransaction"]."</td>";
			echo "<td>".$DWInfo[$i]["LastTransaction"]."</td>";
			echo "<td>".$DWInfo[$i]["LastTransactionAmount"]."</td>";
		echo "</tr>";

	}
	echo "</table>";
	
	
?>
</body>

</html>