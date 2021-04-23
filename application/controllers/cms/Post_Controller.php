<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_Controller extends My_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('cms/Posts');
	}

	public function index()
	{
		$data = array();
		$this->data = $data;
		$this->middle = 'cms/post';
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
			$list = $this->Posts->get_datatables();

	        foreach ($list as $field) 
	        {
	            $row = array();

	            $id = $field->id;
	            $id_enc = encryptor('encrypt',$id);

	            $row["id"] = $id_enc;
	            $row[] = $field->title;
	            $row[] = $field->updated;
	            $row[] = '	<a href="javascript:void(0)" class="btn_view" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="View" data-original-title="View" ><i class="fa fa-edit kt-font-brand"></i></a>';
	            // <a href="javascript:void(0)" class="btn_delete" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete" ><i class="fa fa-trash kt-font-dangerous"></i></a>
	 
	            $data[] = $row;
	        }
	        //pre($field);die();
	 
	        $output = array(
	            "draw" => $_POST['draw'],
	            "recordsTotal" => $this->Posts->count_all(),
	            "recordsFiltered" => $this->Posts->count_filtered(),
	            "data" => $data,
	        );
        //output dalam format JSON
        echo json_encode($output);
	}

	public function details()
	{
		$data = array();

		$selected_id_enc = $this->input->post('ids');
		$selected_id = encryptor('decrypt',$selected_id_enc);
		$data = $this->Posts->read_data($selected_id);
		
		echo json_encode($data);
	}

	public function save()
	{ 
		$form = ['title'      => $_REQUEST['title'],
	            'description' => $_REQUEST['description'],
	            'attachment ' => $_FILES['banner']['name'],
	            'created' => date('Y-m-d H:i:s'),
	            'updated' => date('Y-m-d H:i:s'),
        ];
        $target_dir = "assets/upload_files/";
		$target_file = $target_dir . basename($_FILES["banner"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["banner"]["tmp_name"]);
		    if($check !== false) {		        $uploadOk = 1;
		    } else {
		        echo "File is not an image.";
		        $uploadOk = 0;
		    }
		}
		if ($_FILES["banner"]["size"] > 500000) {
			echo "Sorry, your image is too large.";
		    $uploadOk = 0;
		}
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
		    $uploadOk = 0;
		}
		if ($uploadOk == 0) {
		} else {
		    if (move_uploaded_file($_FILES["banner"]["tmp_name"], $target_file)) {
		    } else {   }
		}
        $status = $this->Posts->update_data($form);
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
	public function update()
	{
		$selected_id_enc = $this->input->post('ids');
		$selected_id = encryptor('decrypt',$selected_id_enc);

		$form = ['title'      => $_REQUEST['title'],
	            'description' => $_REQUEST['description'],
	            'attachment ' => $_FILES['banner']['name'],
	            'created' => date('Y-m-d H:i:s'),
	            'updated' => date('Y-m-d H:i:s'),
        ];
        $target_dir = "assets/upload_files/abouts/";
		$target_file = $target_dir . basename($_FILES["banner"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["banner"]["tmp_name"]);
		    if($check !== false) {		        $uploadOk = 1;
		    } else {
		        echo "File is not an image.";
		        $uploadOk = 0;
		    }
		}
		if ($_FILES["banner"]["size"] > 500000) {
			echo "Sorry, your image is too large.";
		    $uploadOk = 0;
		}

		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
		    $uploadOk = 0;
		}
		if ($uploadOk == 0) {
		} else {
		    if (move_uploaded_file($_FILES["banner"]["tmp_name"], $target_file)) {
		    } else {   }
		}

        $status = $this->Posts->update_data($selected_id, $form);
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
}
