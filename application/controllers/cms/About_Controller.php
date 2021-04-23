<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About_Controller extends My_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('cms/Abouts');
	}

	public function index()
	{
		$selected_id_enc = $this->input->post('ids');
		$id = encryptor('decrypt',$selected_id_enc);

    	$data = array();
    	$data['info']= $this->Abouts->read_data($id);

		$this->data = $data;
		//pre($data); die();
		$this->middle = 'cms/about-us';
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
			$list = $this->Abouts->get_datatables();

	        foreach ($list as $field) 
	        {
	            $row = array();

	            $id = $field->id;
	            $id_enc = encryptor('encrypt',$id);

	            $row["id"] = $id_enc;
	            $row[] = $field->title;
	            $row[] = $field->created;
	            $row[] = $field->updated;
	            $row[] = '	<a href="javascript:void(0)" class="btn_view" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="View" data-original-title="View" ><i class="fa fa-edit kt-font-brand"></i></a>';
	            // <a href="javascript:void(0)" class="btn_delete" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete" ><i class="fa fa-trash kt-font-dangerous"></i></a>
	 
	            $data[] = $row;
	        }
	        //pre($field);die();
	 
	        $output = array(
	            "draw" => $_POST['draw'],
	            "recordsTotal" => $this->Abouts->count_all(),
	            "recordsFiltered" => $this->Abouts->count_filtered(),
	            "data" => $data,
	        );
        //output dalam format JSON
        echo json_encode($output);
	}

	public function details()
	{
		$selected_id_enc = $this->input->post('ids');
		$id = encryptor('decrypt',$selected_id_enc);

    	$data = array();
    	$data['info']= $this->Abouts->read_data($id);

		$this->data = $data;
		//pre($data); die();
		$this->middle = 'cms/view_about-us';
    	$this->layout();	
	}

	public function update()
	{ 
		$attachment  = $_FILES['banner']['name'];
		$attach = shuffle_name($_FILES['banner']['name']);

		if ($attach > 0) {
			$form = ['title'      => $_REQUEST['title'],
		            'description' => $_REQUEST['description'], //rawurlencode($_REQUEST['description'])
		            'attachment ' => $attach,
		            'updated' => date('Y-m-d H:i:s'),
		            'active'  => 1
        		];
		} else {
			$form = ['title'      => $_REQUEST['title'],
		            'description' => $_REQUEST['description'],
		            'updated' => date('Y-m-d H:i:s'),
		            'active'  => 1
		        ];
		}

		//pre($form); die();

        $target_dir = "assets/upload_files/abouts/";
		$target_file = $target_dir . basename($attach);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// $check  = getimagesize($_FILES["banner"]["tmp_name"]);
		//print_r($check);
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
		if ($_FILES["banner"]["size"] > 1300000) {
			//echo "Sorry, your image is too large.";
		   $uploadOk = 0;
		    $data = [
                'status' => 0,
                'status_message' => 'Sorry, your image is too large. Please try again.',
                'q' => 0
            ];
            echo json_encode($data);
       		die();
		}
		// if ($width > 375 || $height > 160)
		// {
		// 		$uploadOk = 0;
		//     	$data = [
  //               'status' => 0,
  //               'status_message' => 'Sorry, your image size must be 375 x 160 pixels. Please try again.',
  //               'q' => 0,
	 //            ];
	 //             echo json_encode($data);
	 //             die();
		// }

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

        $status = $this->Abouts->update_data($form);

        if ($status) {
            $data = [
                'status' => 1,
                'status_message' => 'Successfully update new details',
                'q' => $status,
            ];
        } else {
            $data = [
                'status' => 0,
                'status_message' => 'Failed to update new details. Please try again.',
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
            $config['upload_path']    = './assets/upload_files/abouts/';                        
            $config['log_threshold']  = 1;
            $config['allowed_types']  = 'jpg|png|jpeg|gif';
            $config['max_size']       = '1300000'; // 0 = no file size limit
            $config['file_name']      = $timestamp."_".$_FILES["file"]["name"];          
            $config['overwrite']      = false;
            $this->load->library('upload', $config);
            $this->upload->do_upload('file');
            $upload_data   = $this->upload->data();
            $file_name     = $upload_data['file_name'];    
            
            echo base_url()."assets/upload_files/abouts/".$file_name;
        }
    }
}
