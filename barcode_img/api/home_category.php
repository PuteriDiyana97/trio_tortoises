<?php
    include 'conf.php';
    /* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
    $req_dump = print_r($_REQUEST, TRUE);
	$fp = fopen('logs/home_category.txt', 'a');
	fwrite($fp, "\n\n".date("Y-m-d H:i:s")." - http://810speedmart.com/".$_SERVER['REQUEST_URI']."\n".$req_dump);
	fclose($fp);
	
	
	/* ******************************************************************

		Query Function & Print JSON Data
		810 Home Category API
		Sample URL: http://810speedmart.com/api/home_category.php?id=[ID Send from home.php]

		Return Info
		1. CATEGORY_LIST = Banner Image (Array)
			- THUMB = Thumbnail
			- TITLE = Title display in Modal Header
			- TITLE1 = Title
			- TITLE2 = Title (display if any)
			- ALL_PAGES = Show all slide image when click THUMB Image
		2. TITLE = Show in Header

	****************************************************************** */
	$DWMode = $_REQUEST["display_mode"];
	$DWCatID = $_REQUEST["id"];
	
	

	$BannerData["THUMB"] = "assets/810-speedmart-catalogue.png";
	$BannerData["TITLE"] = "Title 1";
	$BannerData["TITLE1"] = "Thu,2 May - Wed,15 May";
	$BannerData["TITLE2"] = "Promotion";
	unset($BannerPages);
	$BannerPages[] = "assets/810-speedmart-catalogue.png";
	$BannerPages[] = "assets/810-speedmart-catalogue-1.png";
	$BannerPages[] = "assets/810-speedmart-catalogue-2.png";
	$BannerPages[] = "assets/810-speedmart-catalogue-3.png";
	$BannerData["ALL_PAGES"] = $BannerPages;
	$MainData_Info[] = $BannerData;

	$BannerData["THUMB"] = "assets/810-speedmart-catalogue-1.png";
	$BannerData["TITLE"] = "Title 2";
	$BannerData["TITLE1"] = "Thu,3 May - Wed,16 May";
	$BannerData["TITLE2"] = "";
	unset($BannerPages);
	$BannerPages[] = "assets/810-speedmart-catalogue.png";
	$BannerPages[] = "assets/810-speedmart-catalogue-1.png";
	$BannerPages[] = "assets/810-speedmart-catalogue-2.png";
	$BannerPages[] = "assets/810-speedmart-catalogue-3.png";
	$BannerData["ALL_PAGES"] = $BannerPages;
	$MainData_Info[] = $BannerData;

	$BannerData["THUMB"] = "assets/810-speedmart-catalogue-2.png";
	$BannerData["TITLE"] = "Title 3";
	$BannerData["TITLE1"] = "Thu,4 May - Wed,18 May";
	$BannerData["TITLE2"] = "";
	unset($BannerPages);
	$BannerPages[] = "assets/810-speedmart-catalogue.png";
	$BannerPages[] = "assets/810-speedmart-catalogue-1.png";
	$BannerPages[] = "assets/810-speedmart-catalogue-2.png";
	$BannerPages[] = "assets/810-speedmart-catalogue-3.png";
	$BannerData["ALL_PAGES"] = $BannerPages;
	$MainData_Info[] = $BannerData;

	$BannerData["THUMB"] = "assets/810-speedmart-catalogue-3.png";
	$BannerData["TITLE"] = "Title 4";
	$BannerData["TITLE1"] = "Thu,10 May - Wed,31 May";
	$BannerData["TITLE2"] = "";
	unset($BannerPages);
	$BannerPages[] = "assets/810-speedmart-catalogue.png";
	$BannerPages[] = "assets/810-speedmart-catalogue-1.png";
	$BannerPages[] = "assets/810-speedmart-catalogue-2.png";
	$BannerPages[] = "assets/810-speedmart-catalogue-3.png";
	$BannerData["ALL_PAGES"] = $BannerPages;
	$MainData_Info[] = $BannerData;

	$MainData["CATEGORY_LIST"] = $MainData_Info;
	$MainData["TITLE"] = "Speedmart Title";


	if ( $DWMode == "TEST" ) {
		echo "<pre>";
		print_r($MainData);
		echo "</pre>";
	}
	
	echo json_encode($MainData);
	exit;
?>