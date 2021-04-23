<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Screen_Controller extends My_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('cms/Home_screen');
	}

	public function index()
	{
		$data = array();

		$this->data = $data;
		$this->middle = 'cms/home_screen';
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
			$list = $this->Home_screen->get_datatables();

	        foreach ($list as $field) 
	        {
	            $no++;
	            $row = array();

	            $id = $field->id;
	            $id_enc = encryptor('encrypt',$id);

	            $row["id"] = $id_enc;
	            $row[] = $no;
	            $row[] = strtoupper($field->title); 
	            $row[] = date("d-m-Y", strtotime($field->created));
	            $row[] = '	<a href="javascript:void(0)" class="btn_view" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="View" data-original-title="View" ><i class="fa fa-edit kt-font-brand"></i></a>&nbsp;&nbsp;
	            			<a href="javascript:void(0)" class="btn_delete" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete" ><i class="fa fa-trash kt-font-dangerous"></i></a>';
	            $data[] = $row;
	        }
	 		
	 		//pre($field); die();
	        $output = array(
	            "draw" => $_POST['draw'],
	            "recordsTotal" => $this->Home_screen->count_all(),
	            "recordsFiltered" => $this->Home_screen->count_filtered(),
	            "data" => $data,
	        );
        //output dalam format JSON
        echo json_encode($output);
	}

	public function create()
    {
    	$data = array();

        $this->data = $data;
        $this->middle = 'cms/add_screen';
        $this->layout();
    }


    public function insert()
	{
		$attach = shuffle_name($_FILES['banner']['name']);

		$form = [
				'title'         => $_REQUEST['title'],
				'attachment'    => $attach,
	            'created' => date('Y-m-d H:i:s'),
        ];

        $target_dir = "assets/upload_files/home_screen/";
		$target_file = $target_dir . basename($attach);
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
		if ($_FILES["banner"]["size"] > 1300000) {
			echo "Sorry, your image is too large.";
		    $uploadOk = 0;
		    $data = [
                'status' => 0,
                'status_message' => 'Sorry, your image is too large.',
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
        $status = $this->Home_screen->insert($form);

        if ($status) {
            $data = [
                'status' => 1,
                'status_message' => 'Successfully added new details',
                'q' => $status,
            ];
        } else {
            $data = [
                'status' => 0,
                'status_message' => 'Failed to add new details. Please try again.',
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
		$data = $this->Home_screen->read_data($selected_id);
		
		echo json_encode($data);
	}

	public function update()
	{	//pre($_POST); die();
		$selected_id_enc = $this->input->post('ids');
		$selected_id = encryptor('decrypt',$selected_id_enc);
		$attachment	= $_FILES['banner']['name'];
		$attach = shuffle_name($_FILES['banner']['name']);

		$form = [
				'title'         => $_REQUEST['title'],
				'attachment'    => $attach,
	            'updated' => date('Y-m-d H:i:s'),
        ];
  //       if ($attach > 0) {
		// 	$form = ['title'      => $_REQUEST['title'],
		//             'description' => $_REQUEST['description'],
		//             'attachment ' => $attach,
		//             'updated' => date('Y-m-d H:i:s'),
		//             'active'  => 1
  //       		];
		// } else {
		// 	$form = ['title'      => $_REQUEST['title'],
		//             'description' => $_REQUEST['description'],
		//             'updated' => date('Y-m-d H:i:s'),
		//             'active'  => 1
		//         ];
		// }

        //Check whether empty picture
        if ($attachment ==''){
		  unset($form['attachment']);
		}

        $target_dir = "assets/upload_files/home_screen/";
		$target_file = $target_dir . basename($attach);
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
		//10mb 1mb =1024kb
		if ($_FILES["banner"]["size"] > 1300000) {
			//echo "Sorry, your image is too large.";
		    $uploadOk = 0;
		    $data = [
                'status' => 0,
                'status_message' => 'Sorry, your image is too large.',
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

       
        $status = $this->Home_screen->update_data($selected_id,$form);

        if ($status) {
            $data = [
                'status' => 1,
                'status_message' => 'Successfully updated home screen',
                'q' => $status,
            ];
        } else {
            $data = [
                'status' => 0,
                'status_message' => 'Failed to edit home screen. Please try again.',
                'q' => $status,
            ];
        }
        echo json_encode($data);
	}

	public function delete()
	{
		$data = 0;

		$selected_id_enc = $this->input->post('ids');
		$selected_id = encryptor('decrypt',$selected_id_enc);

		$status = $this->Home_screen->delete_data($selected_id);
        if ($status) {
            $data = [
                'status' => 1,
                'status_message' => 'Successfully delete',
                'q' => $status,
            ];
        } else {
            $data = [
                'status' => 0,
                'status_message' => 'Failed to delete details. Please try again.',
                'q' => $status,
            ];
        }
		
		echo json_encode($data);
	}
}
