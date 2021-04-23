<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promotion_Controller extends My_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('cms/Promotions');
	}

	public function index()
	{
		$data = array();
		$data['category_list']= $this->Promotions->list_data();

		$this->data = $data;
		$this->middle = 'cms/promotion';
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
			$list = $this->Promotions->get_datatables();

	        foreach ($list as $field) 
	        {
	            $no++;
	            $row = array();

	            $id = $field->id;
	            $id_enc = encryptor('encrypt',$id);

				$show = $field->push_promotion; //0:haven push 1:pushed
               	if ($show == 0) {
               		$show = 'Not Publish';
               	}
               	if ($show == 1) {
               		$show = 'Published';
               	}


	            $row["id"] = $id_enc;
	            $row[] = $no;
	            $row[] = strtoupper($field->title);
	           	$row[] = $field->category;
	            $row[] = date("d-m-Y", strtotime($field->start_date));
	            $row[] = date("d-m-Y", strtotime($field->expiry_date));   
	            $row[] = '	<a href="javascript:void(0)" class="btn_view" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="View" data-original-title="View" ><i class="fa fa-edit kt-font-brand"></i></a>&nbsp;&nbsp;
	            			<a href="javascript:void(0)" class="btn_delete" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete" ><i class="fa fa-trash kt-font-dangerous"></i></a>';
	 
	            $data[] = $row;
	        }
	// pre($list); die();
	        $output = array(
	            "draw" => $_POST['draw'],
	            "recordsTotal" => $this->Promotions->count_all(),
	            "recordsFiltered" => $this->Promotions->count_filtered(),
	            "data" => $data,
	        );
        //output dalam format JSON
        echo json_encode($output);
	}

	public function create()
    {
    	$data = array();
    	$data['category_list']= $this->Promotions->list_data(); 
    	//pre($data); die();
        $this->data = $data;
        $this->middle = 'cms/add_promotion';
        $this->layout();
    }

	public function insert()
	{
		$attach = shuffle_name($_FILES['banner']['name']);
		$form = [
				'title'    => $_REQUEST['title'],
	            'description'    => $_REQUEST['description'],
				'attachment' 	 => $attach,
				'promotion_category_id'  => $_REQUEST['category_set'],
				'start_date'             => date('Y-m-d', strtotime($_REQUEST['start_date'])),
			    'expiry_date'            => date('Y-m-d', strtotime($_REQUEST['expiry_date'])),
	            'created' => date('Y-m-d  H:i:s'),
	            'active'         			 => 1,
        ];
        
		//pre($form); die();
        $target_dir = "assets/upload_files/promotion/";
		$target_file = $target_dir . basename($attach);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		// $check  = getimagesize($_FILES["banner"]["tmp_name"]);
	 //    $width  = $check[0];
		// $height = $check[1];

		if(isset($_POST["submit"])) {
		    $check  = getimagesize($_FILES["banner"]["tmp_name"]);
		    if($check !== false) {		        
		    	$uploadOk = 1;
		    } else {
		        echo "File is not an image.";
		        $uploadOk = 0;
		    }
		    
		}
		// if ($width > 500 || $height > 131)
		// {
		// 		$uploadOk = 0;
		//     	$data = [
  //               'status' => 0,
  //               'status_message' => 'Sorry, please check your image size',
  //               'q' => 0,
	 //            ];
	 //             echo json_encode($data);
	 //             die();
		// }

		if ($_FILES["banner"]["size"] > 1300000) {
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
		    if (move_uploaded_file($_FILES["banner"]["tmp_name"], $target_file)) {
		    } else {   }
		}

        // echo json_encode($_REQUEST);die;
        $status = $this->Promotions->insert($form);

        if ($status) {
            $data = [
                'status' => 1,
                'status_message' => 'Successfully added new promotion details',
                'q' => $status,
            ];
        } else {
            $data = [
                'status' => 0,
                'status_message' => 'Failed to add new promotion details. Please try again.',
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
		$data = $this->Promotions->read_data($selected_id);

		echo json_encode($data);
	}

	public function update()
	{
		$selected_id_enc = $this->input->post('ids');
		$selected_id = encryptor('decrypt',$selected_id_enc);
		$attachment	= $_FILES['banner']['name'];
		$attach = shuffle_name($_FILES['banner']['name']);

		$form = [
				'title'    		 => $_REQUEST['title'],
	            'description'    => $_REQUEST['description'],
				'attachment' 	 => $attach,
				'promotion_category_id' => $_REQUEST['category_set'],
				'start_date'    		=> $_REQUEST['start_date'],
	            'expiry_date'   		=> $_REQUEST['expiry_date'],
	            'updated' 				=> date('Y-m-d H:i:s'),
	            'active'                => 1,
        ];
        
        //Check whether empty picture
        if ($attachment ==''){
		  unset($form['attachment']);
		}
		
        $target_dir = "assets/upload_files/promotion/";
		$target_file = $target_dir . basename($attach);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// $check  = getimagesize($_FILES["banner"]["tmp_name"]);
		// //print_r($check);
	 //    $width  = $check[0];
		// $height = $check[1];

		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["banner"]["tmp_name"]);
		    if($check !== false) {		        $uploadOk = 1;
		    } else {
		        echo "File is not an image.";
		        $uploadOk = 0;
		    }
		}
		// if ($width > 376 || $height > 131)
		// {
		// 		$uploadOk = 0;
		//     	$data = [
  //               'status' => 0,
  //               'status_message' => 'Sorry, your image size must be 376 x 131 pixels. Please try again.',
  //               'q' => 0,
	 //            ];
	 //             echo json_encode($data);
	 //             die();
		// }
		// // if ($width < 376 && $height < 131)
		// {
		// 		$uploadOk = 0;
		//     	$data = [
  //               'status' => 0,
  //               'status_message' => 'Sorry, your image size must be 376 x 131 pixels. Please try again.',
  //               'q' => 0,
	 //            ];
	 //             echo json_encode($data);
	 //             die();
		// }

		//10mb
		if ($_FILES["banner"]["size"] > 1300000) {
			//echo "Sorry, your image is too large.";
		    $uploadOk = 0;$data = [
                'status' => 0,
                'status_message' => 'Sorry, your image is too large. Please try again.',
                'q' => 0,
            ];
             echo json_encode($data);
             die();
        }

		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
		    $uploadOk = 0;
		    // $data = [
      //           'status' => 0,
      //           'status_message' => 'File is not an image.',
      //           'q' => 0,
      //       ];
             
      //  	echo json_encode($data);
      //   die();
		}
		if ($uploadOk == 0) {
		} else {
		    if (move_uploaded_file($_FILES["banner"]["tmp_name"], $target_file)) {
		    } else {   }
		}
		$status = $this->Promotions->update_data($selected_id, $form);
        if ($status) {
            $data = [
                'status' => 1,
                'status_message' => 'Successfully update promotion details',
                'q' => $status,
            ];
        } else {
            $data = [
                'status' => 0,
                'status_message' => 'Failed to update promotion details. Please try again.',
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

		$status = $this->Promotions->delete_data($selected_id);
        if ($status) {
            $data = [
                'status' => 1,
                'status_message' => 'Successfully delete promotion details',
                'q' => $status,
            ];
        } else {
            $data = [
                'status' => 0,
                'status_message' => 'Failed to delete promotion details. Please try again.',
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
            $config['upload_path']    = './assets/upload_files/promotion/';                        
            $config['log_threshold']  = 1;
            $config['allowed_types']  = 'jpg|png|jpeg|gif';
            $config['max_size']       = '1300000'; // 0 = no file size limit
            $config['file_name']      = $timestamp."_".$_FILES["file"]["name"];          
            $config['overwrite']      = false;
            $this->load->library('upload', $config);
            $this->upload->do_upload('file');
            $upload_data   = $this->upload->data();
            $file_name     = $upload_data['file_name'];    
            
            echo base_url()."assets/upload_files/promotion/".$file_name;
        }
    }
}
