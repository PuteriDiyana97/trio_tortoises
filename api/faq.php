<?php
include 'conf.php';
/* ******************************************************************

		Write Request Data to Server

	****************************************************************** */
$req_dump = print_r($_REQUEST, TRUE);
$fp = fopen('logs/faq.txt', 'a');
fwrite($fp, "\n\n" . date("Y-m-d H:i:s") . " - http://starglorygroup.com/admin_sg/" . $_SERVER['REQUEST_URI'] . "\n" . $req_dump);
fclose($fp);
//******************************************************************

$con = getdb();
$Sql_Select = "SELECT d.* FROM faq d WHERE d.active = 1 and d.id = 1";
$Rst_Select = mysqli_query($con, $Sql_Select);

if (mysqli_num_rows($Rst_Select) > 0) {

	$row = mysqli_fetch_assoc($Rst_Select);
	$row;

	$id    = $row["id"];
	$string = $row["description"];

	$trans = array("\r\n" => "<br>", "\"" => "", "//www." => "https://www.", "width=\"640\"" => "width=100%", "height=\"360\"" => "height=100%", "https:" => "");

	$description = strtr($string, $trans);

	//$description = str_replace("\r\n", "<br>", $row["description"]);
	//$attachment = $_URL."assets/upload_files/faq/". $row["attachment"];

	// $rowAll[] = $data;
	$status = 1;
	$status_message = 'Success display account details.';
	$firstpage["firstpage"] = "/tabs/home";
} else {
	// $rowAll[] = ''; 
	$status = 0;
	$status_message = 'No data found';
	$firstpage = '';
}

$MainData["id"] = $id;
//$MainData["title"] = $title;
$MainData["description"] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $description);
//$MainData["attachment"] = $attachment;
$MainData["firstpage"] = $firstpage;
$MainData["status"] = $status;
$MainData["status_message"] = $status_message;

echo json_encode($MainData);
exit;
?>

<!-- <img src="{{ }}" alt=""> -->