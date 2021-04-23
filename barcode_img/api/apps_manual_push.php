<?php
    include 'conf.php';


    //
    // Malay Version
    $DWPopup_Malay_Message = "Kehadapan Ahli 810 VIP, 
Kami mengucapkan ribuan terima kasih kerana menggunakan khidmat kami. 
Semoga anda berpuas hati dengan konsep Mudah, Segar, Murah yang telah ditawarkan. 
Kami akan memberikan pengalaman membeli-belah yang lebih baik kepada anda. 
Daripada pihak kakitangan dan pengurusan 810 Speedmart.";
    $DWPopup_Malay_NotificationCenter_Title = "Terima Kasih";
    $DWPopup_English_NotificationCenter_Title_Header = "Terima Kasih";
    $DWPopup_Malay_NotificationCenter_Message = "<div style=\'padding: 3px 10px;\'><br /><b>Kehadapan Ahli 810 VIP</b>,<br /><br /><br />
Kami mengucapkan ribuan terima kasih kerana menggunakan khidmat kami.<br /><br />
Semoga anda berpuas hati dengan konsep Mudah, Segar, Murah yang telah ditawarkan.<br /><br />
Kami akan memberikan pengalaman membeli-belah yang lebih baik kepada anda.<br /><br /><br /><br />
Daripada pihak kakitangan dan pengurusan 810 Speedmart.<div>";

    //
    // English Version
    $DWPopup_English_Message = "Dear 810 VIP Members, 
Thank you for shopping with us. 
Hope you enjoy all our good deal with Mudah, Segar , Murah concept. 
We will provide you more good buy. 
From staff and management of 810 speedmart";
    $DWPopup_English_NotificationCenter_Title = "Thank you";
    $DWPopup_English_NotificationCenter_Title_Header = "THANK YOU";
    $DWPopup_English_NotificationCenter_Message = "<div style=\'padding: 3px 10px;\'><br /><b>Dear 810 VIP members</b>,<br /><br /><br />
Thank you for shopping with us. <br /><br />
Hope you enjoy all our good deal with Mudah, Segar , Murah concept.<br /><br />
We will provide you more good buy.<br /><br /><br /><br />
From staff and management of 810 Speedmart.<div>";

    //
    // Please refer Size as http://810speedmart.com/api/images/810-thank-q-push-notifications03.jpg
    $DWPopup_NotificationCenter_Thumbnail = "http://810speedmart.com/api/images/810-thank-q-push-notifications03.jpg";


    //
    //
    //
    //
    // mark as comment it after done insert notification
    echo "Please uncomment the script here !";
    exit;

    echo "<br />Select: ".
    $Sql_Select = "SELECT i.*, c.race, c.gender FROM data_customer c INNER JOIN data_apps_info i ON (i.customer_id=c.id) WHERE c.active = 1 ORDER BY c.id ";
    //$Sql_Select = "SELECT i.* FROM data_customer c INNER JOIN data_apps_info i ON (i.customer_id=c.id) WHERE c.active = 1 AND c.sbclient_id = '60163660905' GROUP BY i.customer_id ORDER BY c.id ";
    $Rst_Select = mysql_query($Sql_Select);
    while ( $RowData = mysql_fetch_assoc($Rst_Select) ) {

    	if ( $RowData["race"] == "MALAY" || $RowData["gender"] == "MALAY" ) {

    		$DWMessage_Pop = $DWPopup_Malay_Message;
    		$DWTitle = $DWPopup_Malay_NotificationCenter_Title;
    		$DWMessage = $DWPopup_Malay_NotificationCenter_Message;

    	} else {

    		$DWMessage_Pop = $DWPopup_English_Message;
            $DWTitle = $DWPopup_English_NotificationCenter_Title;
            $DWMessage = $DWPopup_English_NotificationCenter_Message;

    	}
    	

    	echo "<br />Insert: ".
    	$Sql_Insert = "INSERT INTO data_notification (customer_id, thumbnail, popup_title, popup_message, title, title1, banner, html, type, updated, created, active) VALUES ('".$RowData["customer_id"]."', '".$DWPopup_NotificationCenter_Thumbnail."', '', '".$DWMessage_Pop."', '".$DWPopup_English_NotificationCenter_Title_Header."', '".$DWTitle."', '', '".$DWMessage."', 1, NOW(), NOW(), 1)";
    	$Rst_Insert = mysql_query($Sql_Insert);

    }

    


?>