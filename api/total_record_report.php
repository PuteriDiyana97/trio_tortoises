<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/total_record_report.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://810speedmart.com/".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************

		Query Function & Print JSON Data
		810 Home API
		Sample URL: http://810speedmart.com/api/home.php?contactno=[CONTACTNO or '' (EMPTY)]&display_mode=TEST

		Return Info
		1. BANNER = Banner Image (Array)
			- COVER = Display in Home Banner
			- TITLE = Title of Banner
			- ALL_PAGES = Show all slide image when click COVER Image from Banner
		2. CATEGORY = Category Image (Array)
		3. BANNER_BG = Banner Background

	****************************************************************** */

	if($_REQUEST["api_key"] == "9cf6c5cd4bdf3465f7e4e06111cb9fb6"){



	$sqltotal = "SELECT COUNT(*) FROM `data_customer` where active = 1";
	$rst_total = mysql_query($sqltotal);
	$RowData["total"] = mysql_fetch_row($rst_total);

	$sqltoday = "SELECT COUNT(*) FROM `data_customer` where DATE(created) = CURDATE() AND active = 1";
	$rst_today = mysql_query($sqltoday);
	$RowData["today"] = mysql_fetch_row($rst_today);

	$sqlmalay = "SELECT COUNT(*) FROM `data_customer` where race = 'MALAY' AND active = 1";
	$rst_malay = mysql_query($sqlmalay);
	$RowData["malay"] = mysql_fetch_row($rst_malay);

	$sqlchinese = "SELECT COUNT(*) FROM `data_customer` where race = 'CHINESE' AND active = 1";
	$rst_chinese = mysql_query($sqlchinese);
	$RowData["chinese"] = mysql_fetch_row($rst_chinese);

	$sqlindian = "SELECT COUNT(*) FROM `data_customer` where race = 'INDIAN' AND active = 1";
	$rst_indian = mysql_query($sqlindian);
	$RowData["indian"] = mysql_fetch_row($rst_indian);

	$sqlother = "SELECT COUNT(*) FROM `data_customer` where race = 'OTHERS' AND active = 1";
	$rst_other = mysql_query($sqlother);
	$RowData["other"] = mysql_fetch_row($rst_other);

	$sqlFR = "SELECT COUNT(*) FROM `data_customer` where race = 'FOREIGNER' AND active = 1";
	$rst_FR = mysql_query($sqlFR);
	$RowData["foreigner"] = mysql_fetch_row($rst_FR);

	$sqlm = "SELECT COUNT(*) FROM `data_customer` where gender = 'MALE' AND active = 1";
	$rst_m = mysql_query($sqlm);
	$RowData["male"] = mysql_fetch_row($rst_m);

	$sqlf = "SELECT COUNT(*) FROM `data_customer` where gender = 'FEMALE' AND active = 1";
	$rst_f = mysql_query($sqlf);
	$RowData["female"] = mysql_fetch_row($rst_f);



	//=================today data======================//


		$sqlmalayt = "SELECT COUNT(*) FROM `data_customer` where race = 'MALAY' AND DATE(created) = CURDATE() AND active = 1";
		$rst_malayt = mysql_query($sqlmalayt);
		$RowData["malayt"] = mysql_fetch_row($rst_malayt);

		$sqlchineset = "SELECT COUNT(*) FROM `data_customer` where race = 'CHINESE' AND DATE(created) = CURDATE() AND active = 1";
		$rst_chineset = mysql_query($sqlchineset);
		$RowData["chineset"] = mysql_fetch_row($rst_chineset);

		$sqlindiant = "SELECT COUNT(*) FROM `data_customer` where race = 'INDIAN' AND DATE(created) = CURDATE() AND active = 1";
		$rst_indiant = mysql_query($sqlindiant);
		$RowData["indiant"] = mysql_fetch_row($rst_indiant);

		$sqlothert = "SELECT COUNT(*) FROM `data_customer` where race = 'OTHERS' AND DATE(created) = CURDATE() AND active = 1";
		$rst_othert = mysql_query($sqlothert);
		$RowData["othert"] = mysql_fetch_row($rst_othert);

		$sqlFRt = "SELECT COUNT(*) FROM `data_customer` where race = 'FOREIGNER' AND DATE(created) = CURDATE() AND active = 1";
		$rst_FRt = mysql_query($sqlFRt);
		$RowData["foreignert"] = mysql_fetch_row($rst_FRt);

		$sqlmt = "SELECT COUNT(*) FROM `data_customer` where gender = 'MALE' AND DATE(created) = CURDATE() AND active = 1";
		$rst_mt = mysql_query($sqlmt);
		$RowData["malet"] = mysql_fetch_row($rst_mt);

		$sqlft = "SELECT COUNT(*) FROM `data_customer` where gender = 'FEMALE' AND DATE(created) = CURDATE() AND active = 1";
		$rst_ft = mysql_query($sqlft);
		$RowData["femalet"] = mysql_fetch_row($rst_ft);

	//=================today end=======================//



		echo "<b>Total member=".$RowData["total"][0]."</b></br>";
		echo "Malay member=".$RowData["malay"][0]."</br>";
		echo "Chinese member=".$RowData["chinese"][0]."</br>";
		echo "Indian member=".$RowData["indian"][0]."</br>";
		echo "Other member=".$RowData["other"][0]."</br>";
		echo "Foreigner member=".$RowData["foreigner"][0]."</br>";
		echo "Male member=".$RowData["male"][0]."</br>";
		echo "Female member=".$RowData["female"][0]."</br></br></br>";

		echo"====Today Data=====</br>";
		echo "<b>Today New member=".$RowData["today"][0]."</b></br>";
		echo "Today Malay member=".$RowData["malayt"][0]."</br>";
		echo "Today Chinese member=".$RowData["chineset"][0]."</br>";
		echo "Today Indian member=".$RowData["indiant"][0]."</br>";
		echo "Today Other member=".$RowData["othert"][0]."</br>";
		echo "Today Foreigner member=".$RowData["foreignert"][0]."</br>";
		echo "Today Male member=".$RowData["malet"][0]."</br>";
		echo "Today Female member=".$RowData["femalet"][0]."</br>";
		echo"====Today Data=====";
	}else{
	echo"Invalid Access!";
	}
	
	exit;
?>