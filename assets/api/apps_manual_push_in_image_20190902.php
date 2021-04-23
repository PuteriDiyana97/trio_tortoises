<?php
    include 'conf.php';


    //
    // Malay Version
    $DWPopup_Malay_Message = "Hi everyone! We have great announcement to make! We are celebrating Hari Merdeka and 810 is ready to make this celebration even better for you! For 1 day only, you can enjoy a 2KG rice pack for only RM10! What are you waiting for? Come 810Freshmart on Hari Merdeka! T&C Applies.";
    $DWPopup_Malay_NotificationCenter_Title = "Hari Merdeka Promotion";
    $DWPopup_English_NotificationCenter_Title_Header = "Hari Merdeka Promotion";
    $DWPopup_Malay_NotificationCenter_Message = "";
    $DWPopup_title_malay = "Hari Merdeka Promotion";

    //
    // English Version
    $DWPopup_English_Message = "Hi everyone! We have great announcement to make! We are celebrating Hari Merdeka and 810 is ready to make this celebration even better for you! For 1 day only, you can enjoy a 2KG rice pack for only RM10! What are you waiting for? Come 810Freshmart on Hari Merdeka! T&C Applies.";
    $DWPopup_English_NotificationCenter_Title = "Hari Merdeka Promotion";
    $DWPopup_English_NotificationCenter_Title_Header = "Hari Merdeka Promotion";
    $DWPopup_English_NotificationCenter_Message = "";
    $DWPopup_title_english = "Hari Merdeka Promotion";

    //
    // Please refer Size as http://810speedmart.com/api/images/810-thank-q-push-notifications03.jpg
    $DWPopup_NotificationCenter_Thumbnail = "http://810speedmart.com/images/merdeka.jpg";

    //
    //
    $DWPopup_NotificationCenter_Image[] = "http://810speedmart.com/images/merdeka.jpg";
    // $DWPopup_NotificationCenter_Image[] = "http://810speedmart.com/images/24_july_opening_promo_2.jpg";
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
    $Sql_Select = "SELECT i.*, c.race, c.gender FROM data_customer c INNER JOIN data_apps_info i ON (i.customer_id=c.id) WHERE c.active = 1 ORDER BY c.id ";
    // $Sql_Select = "SELECT i.*, c.race, c.gender FROM data_customer c INNER JOIN data_apps_info i ON (i.customer_id=c.id) WHERE c.active = 1 AND c.id=1932 ORDER BY c.id ";

    //$Sql_Select = "SELECT i.* FROM data_customer c INNER JOIN data_apps_info i ON (i.customer_id=c.id) WHERE c.active = 1 AND c.sbclient_id = '60199034016' GROUP BY i.customer_id ORDER BY c.id ";
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