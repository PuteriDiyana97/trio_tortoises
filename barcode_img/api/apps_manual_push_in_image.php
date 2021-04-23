<?php
    include 'conf.php';


    //
    // Malay Version
    $DWPopup_Malay_Message = "Tawaran harga yang menakjubkan! Hanya di moonlightcake!";
    $DWPopup_Malay_NotificationCenter_Title = "Promosi Mingguan";
    $DWPopup_English_NotificationCenter_Title_Header = "Promosi Mingguan";
    $DWPopup_Malay_NotificationCenter_Message = "";
    $DWPopup_title_malay = "Promosi Mingguan";

    //
    // English Version
    $DWPopup_English_Message = "Come check out our moonlightcake weekly promotion! Unbelievable deal!";
    $DWPopup_English_NotificationCenter_Title = "Weekly Promotion";
    $DWPopup_English_NotificationCenter_Title_Header = "Weekly Promotion";
    $DWPopup_English_NotificationCenter_Message = "";
    $DWPopup_title_english = "Weekly Promotion";

    //
    // Please refer Size as http://810speedmart.com/api/images/810-thank-q-push-notifications03.jpg
    $DWPopup_NotificationCenter_Thumbnail = "https://app.moonlightcake.com/media/news/45/Untitled_2.jpg";

    //
    //
    $DWPopup_NotificationCenter_Image[] = "https://app.moonlightcake.com/media/news/45/Untitled_2.jpg";



    // $DWPopup_NotificationCenter_Image[] = "https://810speedmart.com/images/awal_2.jpg";
    // $DWPopup_NotificationCenter_Image[] = "http://810speedmart.com/images/24_july_opening_promo_3.jpg";
    // $DWPopup_NotificationCenter_Image[] = "http://810speedmart.com/images/24_july_opening_promo_4.jpg";
    // $DWPopup_NotificationCenter_Image[] = "http://810speedmart.com/images/810-e-leaflet_promosi-pembukaan03-page2.png";

    //
    //
    //
    //
    // mark as comment it after done insert notification
    echo "Please uncomment the script here !";
    exit;

    echo "<br />Select: ".
    // $Sql_Select = "SELECT i.*, c.race, c.gender FROM data_customer c INNER JOIN data_apps_info i ON (i.customer_id=c.id) WHERE c.active = 1 and i.registerid !='' ORDER BY c.id ";
    $Sql_Select = "SELECT i.*, c.race, c.gender FROM data_customer c INNER JOIN data_apps_info i ON (i.customer_id=c.id) WHERE c.active = 1 and i.registerid !='' AND c.id=13 ORDER BY c.id ";
    $Rst_Select = mysql_query($Sql_Select);
    while ( $RowData = mysql_fetch_assoc($Rst_Select) ) {

    	if ( $RowData["race"] == "MALAY" || $RowData["gender"] == "MALAY" ) {

    		$DWMessage_Pop = $DWPopup_Malay_Message;
    		$DWTitle = $DWPopup_Malay_NotificationCenter_Title;
    		$DWMessage = $DWPopup_Malay_NotificationCenter_Message;
            $DWTitle_Pop= $DWPopup_title_malay;

    	} else {

    		$DWMessage_Pop = $DWPopup_English_Message;
            $DWTitle = $DWPopup_English_NotificationCenter_Title;
            $DWMessage = $DWPopup_English_NotificationCenter_Message;
            $DWTitle_Pop= $DWPopup_title_english;

    	}
    	

    	echo "<br />Insert: ".
    	$Sql_Insert = "INSERT INTO data_notification (customer_id, thumbnail, popup_title, popup_message, title, title1, banner, html, type, updated, created, active) VALUES ('".$RowData["customer_id"]."', '".$DWPopup_NotificationCenter_Thumbnail."', '".$DWTitle_Pop."', '".$DWMessage_Pop."', '".$DWPopup_English_NotificationCenter_Title_Header."', '".$DWTitle."', '".json_encode($DWPopup_NotificationCenter_Image)."', '".$DWMessage."', 0, NOW(), NOW(), 1)";
    	$Rst_Insert = mysql_query($Sql_Insert);

    }

    


?>