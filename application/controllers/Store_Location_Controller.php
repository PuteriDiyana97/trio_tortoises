<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_Location_Controller extends My_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Store_Locations');
	}

	public function index()
	{
		$data = array();

		$this->data = $data;
		$this->middle = 'locations/store_locator';
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
			$list = $this->Store_Locations->get_datatables();

	        foreach ($list as $field) 
	        {
	            $no++;
	            $row = array();

	            $id = $field->id;
	            $id_enc = encryptor('encrypt',$id);

	            $row["id"] = $id_enc;
	            $row[] = $no;
	            $row[] = $field->store_name;
	            $row[] = $field->store_address;
	            $row[] = date("g:i a",strtotime($field->open_time)); //24hours format to 12hours
	            $row[] = date("g:i a",strtotime($field->close_time));    
	            //store-location/view
	            $row[] = '	<a href="store-location/details?ids='.$id_enc.'" class="btn_view" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="View" data-original-title="View" ><i class="fa fa-edit kt-font-brand"></i></a>&nbsp;&nbsp;
	            			<a href="javascript:void(0)" class="btn_delete" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete" ><i class="fa fa-trash kt-font-dangerous"></i></a>';
	            $data[] = $row;
	        }
	 
	        $output = array(
	            "draw" => $_POST['draw'],
	            "recordsTotal" => $this->Store_Locations->count_all(),
	            "recordsFiltered" => $this->Store_Locations->count_filtered(),
	            "data" => $data,
	        );
        //output dalam format JSON
        echo json_encode($output);
	}

	public function create()
    {
    	$data = array();

        $this->data = $data;
        $this->middle = 'locations/add_location';
        $this->layout();
    }

    public function view()
    {
    	$selected_id_enc = $this->input->post('ids');
		$id = encryptor('decrypt',$selected_id_enc);

    	$data = array();
    	$data['location_info']= $location_info=$this->Store_Locations->read_data($id);

        $this->data = $data;
        $this->middle = 'locations/view_location';
        $this->layout();
    }

	public function insert()
	{
		$form = [
				'store_name'         => $_REQUEST['store_name'],
				'contact_no'   	     => $_REQUEST['contact_no'],
	            'open_time'   		 => date("G:i",strtotime($_REQUEST['open_time'])),
	            'close_time'   		 => date("G:i",strtotime($_REQUEST['close_time'])), //12hours format to 24hours
	            'store_address'   	 => $_REQUEST['store_address'],
				'attachment' 		 => $_FILES['attachment']['name'],
	            'latitude'  		 => $_REQUEST['latitude'],
	            'longitude'   	     => $_REQUEST['longitude'],
	            'created' => date('Y-m-d H:i:s'),
        ];

        $target_dir = "assets/upload_files/location/";
		$target_file = $target_dir . basename($_FILES["attachment"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["attachment"]["tmp_name"]);
		    if($check !== false) {		        
		    	$uploadOk = 1;
		    } else {
		        echo "File is not an image.";
		        $uploadOk = 0;
		    }
		}
		//10mb
		if ($_FILES["attachment"]["size"] > 1000000) {
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
		}
		if ($uploadOk == 0) {
		} else {
		    if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)) {
		    } else {   }
		}

        // echo json_encode($_REQUEST);die;
        $status = $this->Store_Locations->insert($form);

        if ($status) {
            $data = [
                'status' => 1,
                'status_message' => 'Successfully added new location',
                'q' => $status,
            ];
        } else {
            $data = [
                'status' => 0,
                'status_message' => 'Failed to add new location. Please try again.',
                'q' => $status,
            ];
        }
        echo json_encode($data);
	}

	//display details in view
	public function details()
	{
		$data = array();
		$selected_id_enc = $this->input->get('ids');
		$selected_id = encryptor('decrypt',$selected_id_enc);
		//pre($selected_id_enc);
		$data['location_info']= $this->Store_Locations->read_data($selected_id);

	   //pre($data); die();
        $this->data = $data;
        $this->middle = 'locations/view_location';
        $this->layout();
	}

	public function update()
	{	//pre($_POST); die();
		$selected_id_enc = $this->input->post('ids');
		$selected_id = encryptor('decrypt',$selected_id_enc);
		$attachment  = $_FILES['attachment']['name'];
		
		$form = [
				'store_name'         => $_REQUEST['store_name'],
				'contact_no'   	     => $_REQUEST['contact_no'],
	            'open_time'   		 => date("G:i",strtotime($_REQUEST['open_time'])), //12hours format to 24hours
	            'close_time'   		 => date("G:i",strtotime($_REQUEST['close_time'])),
	            'store_address'   	 => $_REQUEST['store_address'],
				'attachment' 		 => $attachment,
	            'latitude'  		 => $_REQUEST['latitude'],
	            'longitude'   	     => $_REQUEST['longitude'],
	            'updated' => date('Y-m-d H:i:s'),
        ];

         //Check whether empty picture
        if ($attachment ==''){
		  unset($form['attachment']);
		}

        $target_dir = "assets/upload_files/location/";
		$target_file = $target_dir . basename($_FILES["attachment"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["attachment"]["tmp_name"]);
		    if($check !== false) {		        $uploadOk = 1;
		    } else {
		        echo "File is not an image.";
		        $uploadOk = 0;
		    }
		}
		//10mb
		if ($_FILES["attachment"]["size"] > 1000000) {
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
		}
		if ($uploadOk == 0) {
		} else {
		    if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)) {
		    } else {   }
		}

       
        $status = $this->Store_Locations->update_data($selected_id,$form);

        if ($status) {
            $data = [
                'status' => 1,
                'status_message' => 'Successfully updated location',
                'q' => $status,
            ];
        } else {
            $data = [
                'status' => 0,
                'status_message' => 'Failed to edit location. Please try again.',
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

		$status = $this->Store_Locations->delete_data($selected_id);
        if ($status) {
            $data = [
                'status' => 1,
                'status_message' => 'Failed to delete location. Please try again.',
                'q' => $status,
            ];
        } else {
            $data = [
                'status' => 0,
                'status_message' => 'Successfully delete location.',
                'q' => $status,
            ];
        }
		
		echo json_encode($data);
	}
}
