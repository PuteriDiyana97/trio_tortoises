<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

function pre($data)
{
	echo '<pre>';
	print_r($data);
	echo '</pre>';
}

function selected_value($val1,$val2)
{
	return $val1==$val2 ? 'selected=""' : '';
}

function getDateTime()
{
	// return date('Y-m-d H:i:s');
	$now = new DateTime();
	// $now->setTimezone(new DateTimezone('Asia/Kuala_Lumpur'));
	return $now->format('Y-m-d H:i:s');
}

function getTodayDate()
{
	// return date('Y-m-d');
	$now = new DateTime();
	// $now->setTimezone(new DateTimezone('Asia/Kuala_Lumpur'));
	return $now->format('Y-m-d');
}

function getDaysInYearMonth (int $year, int $month, string $format){
	$date = DateTime::createFromFormat("Y-n", "$year-$month");

	$datesArray = array();
	for($i=1; $i<=$date->format("t"); $i++){
		$datesArray[] = DateTime::createFromFormat("Y-n-d", "$year-$month-$i")->format($format);
	}

	return $datesArray;
}

function db_date($date)
{
	return date('Y-m-d',strtotime($date));
}

function db_time($time)
{
	return date('H:i:s',strtotime($time));
}

function view_date($date)
{
	return date('d-m-Y',strtotime($date));
}

function view_time($date)
{
	return date('h:i A',strtotime($date));
}

function view_time2($date)
{
	return date('G:i',strtotime($date));
}

function show_datetime($date){
	return view_date($date).' / '.view_time($date);
}

function yesterday_date($today_date)
{
	return date('Y-m-d',strtotime($today_date.' -1 day'));
}

function db_time_1_sec($date)
{
	return date('H:i:s',strtotime($date." -1 seconds"));
}

function db_time_add_1_sec($date)
{
	return date('H:i:s',strtotime($date." +1 seconds"));
}

function date_range_weekly($today_date)
{
	$duedt = explode("-", $today_date);
	$date  = mktime(0, 0, 0, $duedt[1], $duedt[2], $duedt[0]);

	$week  = (int)date('W', $date);
	$month = date('F',$date);
	$year = date('Y',$date);


	$days = '5';
	$date_current = date('Y-m-d');
	$date = date_create();
	date_isodate_set($date, $year, $week);
	$start = date_format($date, 'd-m-Y');

	$date_now = $start;
	$day = date('w',strtotime($date_now));
	$a = strtotime('-'.($day-1).' days',strtotime($date_now));
	$b = strtotime('+'.(6-$day).' days',strtotime($date_now));

	$output = array();
	while($a <= $b)
	{
	// $output[] = array(
	  // "date" => date("d/m/Y",$a),
	  // "day" => date("l",$a)
	// );
		$output[] = date("Y-m-d",$a);
		$a += 86400;
	}
	return $output;
}

function display_datetime($show_type='DATE2', $datetime) {
	
	$output_datetime = '';
	
	if ( strtoupper($show_type) == 'DATETIME' ) {
		
		if ( $datetime == '' || $datetime == '0000-00-00 00:00:00' ) {
			$output_datetime = '';
		} else {
			$output_datetime = date('d/m/Y H:i:s', strtotime($datetime));
		}
		
	} else if ( strtoupper($show_type) == 'DATETIME2' ) {
		
		if ( $datetime == '' || $datetime == '0000-00-00 00:00:00' ) {
			$output_datetime = '';
		} else {
			$output_datetime = date('d-M-Y H:i A', strtotime($datetime));
		}
		
	} else if ( strtoupper($show_type) == 'DATETIME3' ) {
		
		if ( $datetime == '' || $datetime == '0000-00-00 00:00:00' ) {
			$output_datetime = '';
		} else {
			$output_datetime = date('d/m/Y', strtotime($datetime));
		}
		
	} else if ( strtoupper($show_type) == 'DATETIME4' ) {
		
		if ( $datetime == '' || $datetime == '0000-00-00 00:00:00' ) {
			$output_datetime = '';
		} else {
			$output_datetime = date('jS \of F Y', strtotime($datetime));
		}
		
	} else if ( strtoupper($show_type) == 'DATE' ) {
		
		if ( $datetime == '' || $datetime == '0000-00-00' ) {
			$output_datetime = '';
		} else {
			$output_datetime = date('d/m/Y', strtotime($datetime));
		}
		
	} else if ( strtoupper($show_type) == 'DATE2' ) {
		
		if ( $datetime == '' || $datetime == '0000-00-00' ) {
			$output_datetime = '';
		} else {
			$output_datetime = date('d-M-Y', strtotime($datetime));
		}
		
	} else if ( strtoupper($show_type) == 'TIME' ) {
		
		if ( $datetime == '' || $datetime == '00:00:00' ) {
			$output_datetime = '';
		} else {
			$output_datetime = date('H:i A', strtotime($datetime));
		}
		
	} else if ( strtoupper($show_type) == 'TIME2' ) {
		
		if ( $datetime == '' || $datetime == '00:00:00' ) {
			$output_datetime = '';
		} else {
			$output_datetime = date('g:iA', strtotime($datetime));
		}
		
	} else if ( strtoupper($show_type) == 'TIME3' ) {
		
		if ( $datetime == '' || $datetime == '00:00:00' ) {
			$output_datetime = '';
		} else {
			$output_datetime = date('g:i A', strtotime($datetime));
		}
		
	} else if ( strtoupper($show_type) == 'DB_DATE' ) {
		
		if ( $datetime == '' || $datetime == '0000-00-00' ) {
			$output_datetime = '';
		} else {
			$output_datetime = date('Y-m-d', strtotime($datetime));
		}
		
	} else if ( strtoupper($show_type) == 'DB_DATETIME' ) {
		
		if ( $datetime == '' || $datetime == '0000-00-00 00:00:00' ) {
			$output_datetime = '';
		} else {
			$output_datetime = date('Y-m-d H:i:s', strtotime($datetime));
		}
		
	} else {
		
		if ( $datetime == '' || $datetime == '0000-00-00 00:00:00' ) {
			$output_datetime = '';
		} else {
			$output_datetime = date('Y-m-d H:i:s', strtotime($datetime));
		}
		
	}
	
	return $output_datetime;
}

function display_number_format($show_type='INTEGER', $number) {
	
	if ( strtoupper($show_type) == 'INTEGER' ) {
		$output_number = number_format($number);
		
	} else if ( strtoupper($show_type) == 'DECIMAL' ) {
		$output_number = number_format($number, 2);
	
	} else {
		$output_number = number_format($number);
	}
	
	return $output_number;
}

function shuffle_name($name = '')
{
	if(!empty($name))
	{
		// $name = str_replace(array(" ", "-", ",", "+"), "_", $name);
		$name = str_replace(' ', '_', $name);
	}

	$alpa = 'abcdefghijklmnopqrstuvwxyz1234567890';
	$str = str_shuffle($alpa);
	$strrun = substr($str,0,5);
	$pName = $strrun.date('H').$name;
	
	return $pName;
}

function shuffle_name1($name = '')
{
	$alpa = 'abcdefghijklmnopqrstuvwxyz1234567890';
	$str = str_shuffle($alpa);
	$strrun = substr($str,0,5);
	$pName = $strrun.date('H').$name;
	
	return $pName;
}

function shuffle_name2($name = '')
{
	$alpa = 'abcdefghijklmnopqrstuvwxyz1234567890';
	$str = str_shuffle($alpa);
	$strrun = substr($str,0,7);
	$pName = $strrun.date('H').$name;
	
	return $pName;
}

/*
* echo session notis
*/
function flash( $name = '', $message = '', $class = 'alert alert-success' )
{
	//We can only do something if the name isn't empty
	if( !empty( $name ) )
	{
		//No message, create it
		if( !empty( $message ) && empty( $_SESSION[$name] ) )
		{
			if( !empty( $_SESSION[$name] ) )
			{
				unset( $_SESSION[$name] );
			}
			if( !empty( $_SESSION[$name.'_class'] ) )
			{
				unset( $_SESSION[$name.'_class'] );
			}

			$_SESSION[$name] = $message;
			$_SESSION[$name.'_class'] = $class;
		}
		//Message exists, display it
		elseif( !empty( $_SESSION[$name] ) && empty( $message ) )
		{
			$class = !empty( $_SESSION[$name.'_class'] ) ? $_SESSION[$name.'_class'] : 'success';
			echo '
			
			<div class="'.$class.' alert-dismissable" id="msg-flash">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				'.$_SESSION[$name].'
			</div>
			';
			unset($_SESSION[$name]);
			unset($_SESSION[$name.'_class']);
		}
	}
}

/*
* echo js notis from fo or sweet alert function
*/
function flash_output( $name = '', $message = '' )
{
	//We can only do something if the name isn't empty
	if( !empty( $name ) )
	{
		//No message, create it
		if( !empty( $message ) && empty( $_SESSION[$name] ) )
		{
			if( !empty( $_SESSION[$name] ) )
			{
				unset( $_SESSION[$name] );
			}
			if( !empty( $_SESSION[$name.'_class'] ) )
			{
				unset( $_SESSION[$name.'_class'] );
			}

			$_SESSION[$name] = $message;
			//$_SESSION[$name.'_class'] = $class;
		}
		//Message exists, display it
		elseif( !empty( $_SESSION[$name] ) && empty( $message ) )
		{
			//$class = !empty( $_SESSION[$name.'_class'] ) ? $_SESSION[$name.'_class'] : 'success';
			echo $_SESSION[$name];
			unset($_SESSION[$name]);
			//unset($_SESSION[$name.'_class']);
		}
	}
}

/*
* create js notis in session -> output need to call flash_output
*/
function fo($big_name,$msg,$msg_title = '',$msg_type='success')
{
	$title = ($msg_title == '' ? "" : ",'".$msg_title."'" );
	$js_notis = "
		<script>
		$(function(){
			swal({
                title: '".$msg."',
                text: '',
                type: '".$msg_type."'
            });
		});
		</script>
	";
	flash_output($big_name,$js_notis);
}

/*
* echo js notis
*/
function fo_short($msg,$msg_type = "success",$msg_title = '')
{
	$title = ($msg_title == '' ? "" : ",'".$msg_title."'" );
	$js_notis = "
		<script>
		$(function(){
			$.jGrowl('".$msg."', { theme: 'bg-".$msg_type."', header: '".$title."', position: 'center' });
		});
		</script>
	";

	echo $js_notis;
}

function check_success($type=2,$msg_name,$msg,$location='',$types='success')
{
	// $types = ($typee == 'success' ? array("1"=>"success","2"=>"alert alert-success") : array("1"=>"red-thunderbird","2"=>"alert alert-danger") );
	fo($msg_name,$msg,'',$types);
	if($type == 2)
	{
		//$this->flash($msg_name.'2',$msg,'',$types["2"]);
	}
	if(!empty($location))
	{
		redirect($location);
	}
	
}

function sweet_alert($type='success',$header_msg,$small_msg='')
{
	$js_html = '
	<script>
	$(function(){
		Swal.fire({
            title: "'.$header_msg.'",
            html: "'.$small_msg.'",
            type: "'.$type.'"
        });
    });
	</script>
	';
	$_SESSION['notification'] = $js_html;
	// $this->session->set_flashdata('notis', $js_html);
}

function enc_dll($pwds)
{
	$encrypted_password = '';
	try    
	  {
			$dll = new COM("PasswordUtil.PasswordUtils2"); 
			$encrypted_password = $dll->Encrypt_Password($pwds);
	  } 
	  catch(Exception $e)
	  {
		echo 'error: ' . $e->getMessage(), "\n";
	  }

	 return $encrypted_password;
}

function date_range_array($strDateFrom,$strDateTo)
{

    $aryRange=array();

    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2), substr($strDateFrom,8,2),substr($strDateFrom,0,4));
    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2), substr($strDateTo,8,2),substr($strDateTo,0,4));

    if ($iDateTo>=$iDateFrom)
    {
        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
        while ($iDateFrom<$iDateTo)
        {
            $iDateFrom+=86400; // add 24 hours
            array_push($aryRange,date('Y-m-d',$iDateFrom));
        }
    }
    return $aryRange;
}


function encryptor($action, $string)
{
	$output = false;

	$encrypt_method = "AES-256-CBC";
	//pls set your unique hashing key
	$secret_key = '$t@rGl0ry';
	$secret_iv = '$t@rGl0ry@123!';

	// hash
	$key = hash('sha256', $secret_key);

	// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	$iv = substr(hash('sha256', $secret_iv), 0, 16);

	//do the encyption given text/string/number
	if( $action == 'encrypt' )
	{
		$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
		$output = base64_encode($output);
	}
	else if( $action == 'decrypt' )
	{
		//decrypt the given text/string/number
		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	}

	return $output;
}

function id_encoder($plainText)
{
    return bin2hex(strtr(base64_encode($plainText), '+/=', '-_~'));
}

function id_decoder($b64Text)
{
    return base64_decode(strtr(hex2bin($b64Text), '-_~', '+/='));
}

function view_menu($res)
{
	echo $res == false ? 'hilang' : '';
}

function return_empty($val)
{	
	return empty($val) ? '' : $val ;
}

function imgVidType($val)
{
	$type = 'img';
	$val_arr = explode('.',$val);
	$val_end = end($val_arr);

	if($val_end == 'mp4')
	{
		$type = 'vid';
	}

	return $type;
}

function path_img($img,$path)
{
	if (file_exists($path.$img)) 
	{
	    return '/'.$path.$img;
	}
	else
	{
		return '/files/sample_img.jpg';
	}
}

function imgOrVid($val)
{
	if(strpos($val,".jpg") > 0)
	{
		return $val;
	}
	else
	{
		return '/files/default_video.jpg';
	}
}

function remove_space_and_tab($string)
{
	$string = str_replace('`',"'",$string);
	$string = preg_replace('/\s+/S', " ", $string);

	return $string;
}

function read_svg()
{
	$main_path = "assets/SVG/";
	// model looping
	$count = 0;
	$output = array();
	//all file without ext glob(*)
	foreach (glob($main_path."*") as $filename)
	{
		//echo "<br />".$count.' - '.basename($filename);

		$file_name = basename($filename);
		$file_name_arr = explode('.svg', $file_name);
		$new_file_name = $file_name_arr[0];
		$output[] = $new_file_name;
		// echo "<br />".$count.' - '.$new_file_name;
		// $count++;
	}

	return $output;
}

function format_namecode($name, $code='')
{
	return $name . ( !empty($code) ? ' ('.$code.')' : '' );
}

function encryptor_multiple(&$val, $fn, $action)
{
	$val = encryptor($action, $val);
}

function fo_title_n_text($big_name, $msg_title, $msg = '', $msg_type = 'success')
{
    $js_notis = "
            <script>
            $(function(){
                Swal.fire({
                    title: '" . $msg_title . "',
                    text: ' ".$msg." ',
                    type: '" . $msg_type . "'
                });
            });
            </script>
        ";
    flash_output($big_name, $js_notis);
}
?>