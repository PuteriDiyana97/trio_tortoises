<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Voucher_Controller extends My_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('voucher/Vouchers');
	}

	public function index()
	{
		$data = array();

		$this->data = $data;
		$this->middle = 'voucher/voucher';
    	$this->layout();	
	}

	public function add_regular_voucher()
    {
    	$data = array();

        $this->data = $data;
        $this->middle = 'voucher/add_voucher';
        $this->layout();
    }

	// list for datatable
	public function list1()
	{
		$output =  array(
				            "draw" => '',
				            "recordsTotal" => 0,
				            "recordsFiltered" => 0,
				            "data" => '',
				        );
		$data = array();

	        $no = $_POST['start'];
			$data = array();
			$list = $this->Vouchers->get_datatables();

	        foreach ($list as $field) 
	        {

	            $no++;
	            $row = array();

	            $id = $field->id;
	            $id_enc = encryptor('encrypt',$id);
	            $voucher_value = $field->voucher_value; 
	            $exchange_point = $field->exchange_point; 
               
               	if ($voucher_value == '0') {
               		$voucher_value = '';
               	}else{
               		$voucher_value = $field->voucher_value;
               	}
               
               	if ($exchange_point == '0') {
               		$exchange_point = '';
               	}else{
               		$exchange_point = $field->exchange_point;
               	}

	            $row["id"] = $id_enc;
	            $row[] = $no;
	            $row[] = strtoupper($field->voucher_name);
	            $row[] = $voucher_value;  //in RM
	            $row[] = $exchange_point;
	            $row[] = date("d-m-Y", strtotime($field->start_date));
	            $row[] = date("d-m-Y", strtotime($field->end_date));
	            $row[] = '	<a href="javascript:void(0)" class="btn_view" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="View" data-original-title="View" ><i class="fa fa-edit kt-font-brand"></i></a>&nbsp;&nbsp;
	            			<a href="javascript:void(0)" class="btn_delete" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete" ><i class="fa fa-trash kt-font-dangerous"></i></a>';
	 
	            $data[] = $row;
	        }
	 //pre($field); die();
	        $output = array(
	            "draw" => $_POST['draw'],
	            "recordsTotal" => $this->Vouchers->count_all(),
	            "recordsFiltered" => $this->Vouchers->count_filtered(),
	            "data" => $data,
	        );
        //output dalam format JSON
        echo json_encode($output);
	}

	public function create()
    {
    	$data = array();

        $this->data = $data;
        $this->middle = 'voucher/add_voucher';
        $this->layout();
    }

	public function insert()
	{	
		$voucher_value = $this->input->post("voucher_value");
		$exchange_point = $this->input->post("exchange_point");
		$voucher_img_before_new_name = shuffle_name($_FILES['voucher_img_before']['name']);
		$voucher_img_after_new_name = shuffle_name($_FILES['voucher_img_after']['name']);

		$form = [
						'voucher_type'    => $_REQUEST['voucher_type'],
			            'voucher_name'    => $_REQUEST['voucher_name'],
			            'voucher_value'   => $voucher_value,
			            'description'     => $_REQUEST['description'],
			            //'voucher_code'  => $_REQUEST['voucher_code'],
			            //'quantity'      => $_REQUEST['quantity'],
			            'exchange_point'  => $exchange_point,
			            'voucher_img_before' => $voucher_img_before_new_name,
			            'voucher_img_after'  => $voucher_img_after_new_name,
			            'start_date'      => date('Y-m-d', strtotime($_REQUEST['start_date'])),
			            'end_date'        => date('Y-m-d', strtotime($_REQUEST['end_date'])),
			            'created' 		  => date('Y-m-d H:i:s'), 
			            'active'     => '1',
			]; 

        //checking voucher image before used
        $target_dir = "assets/upload_files/voucher/";
		$target_file = $target_dir . basename($voucher_img_before_new_name);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		
		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["voucher_img_before"]["tmp_name"]);
		    if($check !== false) {		        
		    	$uploadOk = 1;
		    } else {
		       //echo "File is not an image.";
		        $uploadOk = 0;
			    $data = [
	                'status' => 0,
	                'status_message' => 'File is not an image. Please try again.',
	                'q' => 0,
	            ];
	        echo json_encode($data);
	        die();
	    	}
		}

		// if ($width > 500 || $height > 223)
		// {
		// 		$uploadOk = 0;
		//     	$data = [
  //               'status' => 0,
  //               'status_message' => 'Sorry, please check your image size.',
  //               'q' => 0,
	 //            ];
	 //             echo json_encode($data);
	 //             die();
		// }

		if ($_FILES["voucher_img_before"]["size"] > 1300000) {
			//echo "Sorry, your image is too large.";
		    $uploadOk = 0;
		    $data = [
                'status' => 0,
                'status_message' => 'Sorry, your image is too large. Please try again.',
                'q' => 0,
            ];
        echo json_encode($data);
        die();
		}

		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
		    $uploadOk = 0;
		    $data = [
                'status' => 0,
                'status_message' => 'File is not an image.',
                'q' => 0,
            ];
             
       	echo json_encode($data);
        die();
		}
		if ($uploadOk == 0) {
		} else {
		    if (move_uploaded_file($_FILES["voucher_img_before"]["tmp_name"], $target_file)) {
		    } else {   }
		}

		//checking voucher image after used
		$target_file = $target_dir . basename($voucher_img_after_new_name);
		$imageFileType2 = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["voucher_img_after"]["tmp_name"]);
		    if($check !== false) {		        
		    	$uploadOk = 1;
		    } else {
		        echo "File is not an image.";
		        $uploadOk = 0;
		    }
		}
		//10 mb
		if ($_FILES["voucher_img_after"]["size"] > 1300000) {
			//echo "Sorry, your image is too large.";
		    $uploadOk = 0;
		    $data = [
                'status' => 0,
                'status_message' => 'Sorry, your image is too large. Please try again.',
                'q' => 0,
            ];
        echo json_encode($data);
        die();
		}
		if($imageFileType2 != "jpg" && $imageFileType2 != "png" && $imageFileType2 != "jpeg" && $imageFileType2 != "gif" ) {
		    $uploadOk = 0;
		}
		if ($uploadOk == 0) {
		} else {
		    if (move_uploaded_file($_FILES["voucher_img_after"]["tmp_name"], $target_file)) {
		    } else {   }
		}

        // echo json_encode($_REQUEST);die;
        $status = $this->Vouchers->insert($form);

        if ($status) {
            $data = [
                'status' => 1,
                'status_message' => 'Successfully added new voucher',
                'q' => $status,
            ];
        } else {
            $data = [
                'status' => 0,
                'status_message' => 'Failed to add new voucher. Please try again.',
                'q' => $status,
            ];
        }
        echo json_encode($data);

	}

	public function details()
	{
		$data = array();

		$selected_id_enc = $this->input->post('ids');
		$selected_id = encryptor('decrypt',$selected_id_enc);
		$data = $this->Vouchers->read_data($selected_id);
		
		echo json_encode($data);
	}

	public function update()
	{
		$selected_id_enc = $this->input->post('ids');
		$selected_id = encryptor('decrypt',$selected_id_enc);
		$voucher_img_before = $_FILES['voucher_img_before']['name'];
	    $voucher_img_after  = $_FILES['voucher_img_after']['name'];
	    $voucher_img_before_new_name = shuffle_name($_FILES['voucher_img_before']['name']);
		$voucher_img_after_new_name  = shuffle_name($_FILES['voucher_img_after']['name']);

		$form = [
	            'voucher_name'    => $_REQUEST['voucher_name'],
	            'voucher_value'   => $_REQUEST['voucher_value'],
	            'description'     => $_REQUEST['description'],
	            //'voucher_code'    => $_REQUEST['voucher_code'],
	           // 'quantity'        => $_REQUEST['quantity'],
	            'exchange_point'  => $_REQUEST['exchange_point'],
	            'voucher_img_before' => $voucher_img_before_new_name,
	            'voucher_img_after'  => $voucher_img_after,
	            'start_date'      => date('Y-m-d', strtotime($_REQUEST['start_date'])),
			    'end_date'        => date('Y-m-d', strtotime($_REQUEST['end_date'])),
	            'updated'         => date('Y-m-d H:i:s'),
        ];

         //Check whether empty picture
        if ($voucher_img_before ==''){
		  unset($form['voucher_img_before']);
		}
		if ($voucher_img_after ==''){
		  unset($form['voucher_img_after']);
		}
		
        //checking voucher image before used
if(isset($_FILES['voucher_img_before']['name']) && !empty($_FILES['voucher_img_before']['name']))
		{

	        //checking voucher image before used
	        $target_dir = "assets/upload_files/voucher/";
			$target_file = $target_dir . basename($voucher_img_before_new_name);
			$uploadOk = 1;
			$isError = 0;
			$errorMsg = array();
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			if(isset($_POST["submit"])) {
			    
			    $check = getimagesize($_FILES["voucher_img_before"]["tmp_name"]);
			    if($check !== false) 
			    {
			    	$uploadOk = 1;
			    	$isError = 0;
			    } 
			    else 
			    {
			        // echo "File is not an image.";
			        $uploadOk = 0;
			        $isError = 1;
			        $errorMsg[] = 'File is not an image.';
			    }
			}
			
			if ($_FILES["voucher_img_before"]["size"] > 1300000) { 
				//echo "Sorry, your image is too large.";
			    $uploadOk = 0;
			    $isError = 1;
			    $errorMsg[] = 'File size to big.';
			    // $data = [
	      //           'status' => 0,
	      //           'status_message' => 'Sorry, your image is too large. Please try again.',
	      //           'q' => 0
	      //       ];
	      //       echo json_encode($data);
	      //  		die();
	        }

			if(!in_array($imageFileType, array('jpg','png','jpeg','gif'))) 
			{
			    $uploadOk = 0;
			    $isError = 1;
			    $errorMsg[] = 'File type not supported.(Current file type : '.$imageFileType.')';
			    // $data = [
	      //           'status' => 0,
	      //           'status_message' => 'File is not an image.',
	      //           'q' => 0,
	      //       ];
	             
		     //   	echo json_encode($data);
		     //    die();
			}

			if ($isError > 0) 
			{
				$errorMsg_text = '';
				if(count($errorMsg) > 0)
				{
					$errorTitle = 'Field : <strong>New Voucher Visual(Before Used)</strong>';
					$errorMsg_text = implode('<br />', $errorMsg);
					$errorMsg_text = $errorTitle.'<br />'.$errorMsg_text;
				}
				
				echo json_encode(array('status'=>0,'status_message'=>$errorMsg_text));
				die();
			} 
			else 
			{
			    if (move_uploaded_file($_FILES["voucher_img_before"]["tmp_name"], $target_file)) 
			    {

			    } 
			    else 
			   	{

			   	}
			}
		}


		//checking voucher image after used
		//init variable
		$uploadOk = 1;
		$target_dir = "assets/upload_files/voucher/";

		$target_file2 = $target_dir . basename($voucher_img_after);
		$imageFileType2 = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));
		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["voucher_img_after"]["tmp_name"]);
		    if($check !== false) {		        $uploadOk = 1;
		    } else {
		        echo "File is not an image.";
		        $uploadOk = 0;
		    }
		}
		if ($_FILES["voucher_img_after"]["size"] > 1300000) {
			//echo "Sorry, your image is too large.";
		    $uploadOk = 0;
		    $data = [
                'status' => 0,
                'status_message' => 'Sorry, your image is too large. Please try again.',
                'q' => 0
            ];
            //pre($data); die();
       	echo json_encode($data);
       	die();
        }
        
		if($imageFileType2 != "jpg" && $imageFileType2 != "png" && $imageFileType2 != "jpeg" && $imageFileType2 != "gif") {
		    $uploadOk = 0;
		}
		if ($uploadOk == 0) {
		} else {
		    if (move_uploaded_file($_FILES["voucher_img_after"]["tmp_name"], $target_file2)) {
		    } else {   }
		}

        $status = $this->Vouchers->update_data($selected_id, $form);

        if ($status) {
            $data = [
                'status' => 1,
                'status_message' => 'Successfully update voucher',
                'q' => $status,
            ];
        } else {
            $data = [
                'status' => 0,
                'status_message' => 'Failed to update voucher. Please try again.',
                'q' => $status,
            ];
        }
        //pre($data); die();
       	echo json_encode($data);
	}

	public function delete()
	{
		$data = 0;

		$selected_id_enc = $this->input->post('ids');
		$selected_id = encryptor('decrypt',$selected_id_enc);

		$status = $this->Vouchers->delete_data($selected_id);
        if ($status) {
            $data = [
                'status' => 1,
                'status_message' => 'Successfully delete voucher',
                'q' => $status,
            ];
        } else {
            $data = [
                'status' => 0,
                'status_message' => 'Failed to delete voucher. Please try again.',
                'q' => $status,
            ];
        }
		
		echo json_encode($data);
	}

	public function summernote_sync_image()
    {
        if ( empty($_FILES['file']) )
        {
            exit();
        }
        else
        {
            $timestamp                = date('YmdHis');
            $config['upload_path']    = './assets/upload_files/voucher/';                        
            $config['log_threshold']  = 1;
            $config['allowed_types']  = 'jpg|png|jpeg|gif';
            $config['max_size']       = '1300000'; // 0 = no file size limit
            $config['file_name']      = $timestamp."_".$_FILES["file"]["name"];          
            $config['overwrite']      = false;
            $this->load->library('upload', $config);
            $this->upload->do_upload('file');
            $upload_data   = $this->upload->data();
            $file_name     = $upload_data['file_name'];    
            
            echo base_url()."assets/upload_files/voucher/".$file_name;
        }
    }
}
