<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_Controller extends My_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('cms/News_Model');
	}

	public function index()
	{
		$data = array();

		$this->data = $data;
		$this->middle = 'cms/news';
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
			$list = $this->News_Model->get_datatables();

	        foreach ($list as $field) 
	        {
	            $no++;
	            $row = array();

	            $id = $field->id;
	            $id_enc = encryptor('encrypt',$id);
	            $show = $field->push_news; //0:haven pudh 1:pushed
               
               	if ($show == 1) {
               		$show = 'Published';
               	}else{
               		$show = 'Not Publish';
               	}

	            $row["id"] = $id_enc;
	            $row[] = $no;
	            $row[] = strtoupper($field->title);         
	            $row[] = date("d-m-Y", strtotime($field->start_date));
	            $row[] = date("d-m-Y", strtotime($field->expiry_date)); 
	            $row[] = '	<a href="javascript:void(0)" class="btn_view" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="View" data-original-title="View" ><i class="fa fa-edit kt-font-brand"></i></a>&nbsp;&nbsp;
	            			<a href="javascript:void(0)" class="btn_delete" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete" ><i class="fa fa-trash kt-font-dangerous"></i></a>';
	 
	            $data[] = $row;
	        }
	 // pre($field); die();
	        $output = array(
	            "draw" => $_POST['draw'],
	            "recordsTotal" => $this->News_Model->count_all(),
	            "recordsFiltered" => $this->News_Model->count_filtered(),
	            "data" => $data,
	        );
        //output dalam format JSON
        echo json_encode($output);
	}

	public function create()
    {
    	$data = array();

        $this->data = $data;
        $this->middle = 'cms/add_news';
        $this->layout();
    }

	public function insert()
	{
		$attach = shuffle_name($_FILES['banner']['name']);

		$form = [
				'title'         => $_REQUEST['news_title'],
	            'description'   => $_REQUEST['news_description'],
				'attachment' 	=> $attach,
	            'start_date'    => date('Y-m-d', strtotime($_REQUEST['start_date'])),
	            'expiry_date'	=> date('Y-m-d', strtotime($_REQUEST['end_date'])),
	            'created' => date('Y-m-d H:i:s'),
        ];
       // pre($form); die();
        $target_dir = "assets/upload_files/news/";
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
		// if ($width = 375 || $height = 264)
		// {
		// 		$uploadOk = 0;
		//     	$data = [
  //               'status' => 0,
  //               'status_message' => 'Sorry, your image size must be 375 x 264 pixels. Please try again.',
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
                'status_message' => 'Failed to add new deatils. Please try again.',
                'q' => 0,
            ];
            echo json_encode($data);
            die();
        }

		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
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
        $status = $this->News_Model->insert($form);

        if ($status) {
            $data = [
                'status' => 1,
                'status_message' => 'Successfully added news details',
                'q' => $status,
            ];
        } else {
            $data = [
                'status' => 0,
                'status_message' => 'Failed to add new deatils. Please try again.',
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
		$data = $this->News_Model->read_data($selected_id);
		//pre($data); die();
		echo json_encode($data);
	}

	public function update()
	{
		$selected_id_enc = $this->input->post('ids');
		$selected_id = encryptor('decrypt',$selected_id_enc);

		$attachment	= $_FILES['banner']['name'];
		$attach = shuffle_name($_FILES['banner']['name']);

		$form = ['title'        => $_REQUEST['title'],
	            'description'   => $_REQUEST['description'],
				'attachment' 	=> $attach,
	            'start_date'    => $_REQUEST['start_date'],
	            'expiry_date'   => $_REQUEST['end_date'],
	            'updated' => date('Y-m-d H:i:s'),
        ];

        //Check whether empty picture
        if ($attachment ==''){
		  unset($form['attachment']);
		}

        $target_dir = "assets/upload_files/news/";
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
		// if ($width = 375 || $height = 264)
		// {
		// 		$uploadOk = 0;
		//     	$data = [
  //               'status' => 0,
  //               'status_message' => 'Sorry, your image size must be 375 x 264 pixels. Please try again.',
  //               'q' => 0,
	 //            ];
	 //             echo json_encode($data);
	 //             die();
		// }

		//10mb
		if ($_FILES["banner"]["size"] > 1300000) {
			//echo "Sorry, your image is too large.";
		    $uploadOk = 0;
		    $data = [
                'status' => 0,
                'status_message' => 'Sorry, your image is too large.',
                'q' => 0,
            ];
            //pre($data); die();
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

        $status = $this->News_Model->update_data($selected_id, $form);
        if ($status) {
            $data = [
                'status' => 1,
                'status_message' => 'Successfully update details',
                'q' => $status,
            ];
        } else {
            $data = [
                'status' => 0,
                'status_message' => 'Failed to update details. Please try again.',
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

		$status = $this->News_Model->delete_data($selected_id);
        if ($status) {
            $data = [
                'status' => 1,
                'status_message' => 'Successfully delete notification',
                'q' => $status,
            ];
        } else {
            $data = [
                'status' => 0,
                'status_message' => 'Failed to delete notification. Please try again.',
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
            $config['upload_path']    = './assets/upload_files/news/';                        
            $config['log_threshold']  = 1;
            $config['allowed_types']  = 'jpg|png|jpeg|gif';
            $config['max_size']       = '1300000'; // 0 = no file size limit
            $config['file_name']      = $timestamp."_".$_FILES["file"]["name"];          
            $config['overwrite']      = false;
            $this->load->library('upload', $config);
            $this->upload->do_upload('file');
            $upload_data   = $this->upload->data();
            $file_name     = $upload_data['file_name'];    
            
            echo base_url()."assets/upload_files/news/".$file_name;
        }
    }
}
