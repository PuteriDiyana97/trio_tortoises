<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_Controller extends My_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Members');
	}

	public function index()
	{
    	$data = array();
    	
		$this->data = $data;
		$this->middle = 'member';
    	$this->layout();	
	}

	// list for datatable
	public function list()
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
			$list = $this->Members->get_datatables();

	        foreach ($list as $field) 
	        {

	            $no++;
	            $row = array();

	            $id = $field->id;
	            $id_enc = encryptor('encrypt',$id);
	            $active = $field->active; //0:haven push 1:pushed
               
               	if ($active == 1) {
               		$active = 'Active';
               	}else{
               		$active = 'Inactive';
               	}

	            $row["id"] = $id_enc;
	            $row[] = $no;
	            $row[] = $field->name;
	            $row[] = $field->email;
	            $row[] = $field->contact_no;
	            $row[] = $field->state;
	            $row[] = $field->country;
	            $row[] = $field->point;
	            $row[] = $field->point;
	            $row[] = $active;
	            $row[] = '	<a href="member/details?ids='.$id_enc.'" class="btn_view" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="View" data-original-title="View" ><i class="fa fa-edit kt-font-brand"></i></a>&nbsp;&nbsp;
	            			<a href="javascript:void(0)" class="btn_delete" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete" ><i class="fa fa-trash kt-font-dangerous"></i></a>';
	 
	            $data[] = $row;
	        }
	 //pre($field); die();
	        $output = array(
	            "draw" => $_POST['draw'],
	            "recordsTotal" => $this->Members->count_all(),
	            "recordsFiltered" => $this->Members->count_filtered(),
	            "data" => $data,
	        );
        //output dalam format JSON
        echo json_encode($output);
	}

	public function create()
    {
    	$data = array();

        $this->data = $data;
        $this->middle = 'add_member';
        $this->layout();
    }

    public function insert()
    {

    	$phone_number = $this->ReturnValidContact($_REQUEST['mobile_no']);

    	// generate then save -- https://github.com/picqer/php-barcode-generator
		$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
		$path_to_save_barcode = './barcode_img/';
		$barcode_img_name = 'backend_'.$phone_number.'_'.uniqid().'.png'; // ni value simpan dalam DB
		$barcode_value = $phone_number;
		file_put_contents($path_to_save_barcode.$barcode_img_name, $generator->getBarcode($barcode_value, $generator::TYPE_CODE_128));

    	$check_data = $this->Members->check_data($phone_number);


        $form = ['name' 	     => $_REQUEST['full_name'],
	            'email'          => $_REQUEST['email'],
	            'contact_no'     => $phone_number,
	            'ic_no'          => $_REQUEST['ic_no'],
	            'gender'         => $_REQUEST['gender'],
	            'race'         => $_REQUEST['race'],
	            'date_of_birth'  => date('Y-m-d', strtotime($_REQUEST['dob'])),
	            'address'        => $_REQUEST['address'],
	            'zipcode'        => $_REQUEST['zipcode'],
	            'city	'        => $_REQUEST['city'],
	            'state'          => isset($_REQUEST['state']) ? $_REQUEST['state'] : '',	            
	            'profile_picture'=> $_REQUEST['profile_pic'],
	            'country'        => $_REQUEST['country'],
	            'barcode'	     => $barcode_img_name;
	            'created'        => date('Y-m-d H:i:s'),
	            'active'         => 1,
        ];


        // <img src="base_url('/barcode_img/'.$barcode_img_name)" />

        $form1 = ['contact_no'   => $phone_number,
        		'points'        => $_REQUEST['point'],
        		'description'   => $_REQUEST['description'],
        		'created'       => date('Y-m-d H:i:s'),
	            'active'        => 1,
        ];


        // echo json_encode($_REQUEST);die;
        if(empty($check_data)){

	        $status = $this->Members->insert($form);
	        $status = $this->Members->insert1($form1);

	        if ($status) {
	            $data = [
	                'status' => 1,
	                'status_message' => 'Successfully added new member',
	                'q' => $status,
	            ];
	        } else {
	            $data = [
	                'status' => 0,
	                'status_message' => 'Failed to add new job member. Please try again.',
	                'q' => $status,
	            ];
	        }
    	}else{

    		$data = [
	                'status' => 0,
	                'status_message' => 'Mobile Number already exist!',
	                'q' => $check_data,
	            ];
    	}
        echo json_encode($data);
    }

	public function update()
	{
		$selected_id_enc = $this->input->post('ids');
		$selected_id = encryptor('decrypt',$selected_id_enc);

		$phone_number = $this->ReturnValidContact($_REQUEST['mobile_no']);

    	//$check_data = $this->Members->check_data_member($phone_number,$selected_id);

		$form = ['name' 	     => $_REQUEST['full_name'],
	            'email'          => $_REQUEST['email'],
	            'contact_no'     => $phone_number,
	            'ic_no'          => $_REQUEST['ic_no'],
	            'gender'         => $_REQUEST['gender'],
	            'race'           => $_REQUEST['race'],
	            'date_of_birth'  => date('Y-m-d', strtotime($_REQUEST['dob'])),
	            'address'        => $_REQUEST['address'],
	            'zipcode'        => $_REQUEST['zipcode'],
	            'city	'        => $_REQUEST['city'],
	            'state'          => $_REQUEST['state'],
	            'country'        => $_REQUEST['country'],
	            'updated'        => date('Y-m-d H:i:s'),
	       
        ];

         if(!empty($phone_number)){


	        $status = $this->Members->update_data($selected_id, $form);
	        if ($status) {
	            $data = [
	                'status' => 1,
	                'status_message' => 'Successfully update member',
	                'q' => $status,
	            ];
	        } else {
	            $data = [
	                'status' => 0,
	                'status_message' => 'Failed to update member. Please try again.',
	                'q' => $status,
	            ];
	        }

    }else{

    	 $data = [
	                'status' => 0,
	                'status_message' => 'Please Key in Phone Number !',
	                'q' => $check_data,
	            ];

    }
       	echo json_encode($data);
    
	}
	//display details in view_member
	public function details()
	{
		$data = array();
		$selected_id_enc = $this->input->get('ids');
		$selected_id = encryptor('decrypt',$selected_id_enc);
		//pre($selected_id_enc);
		$data['member_list']= $this->Members->member_detail($selected_id);
		$data['member_points']= $this->Members->member_points($selected_id);

		//pre($data); die();
        $this->data = $data;
        $this->middle = 'view_member';
        $this->layout();
	}

	public function delete()
	{
		$data = 0;

		$selected_id_enc = $this->input->post('ids');
		$selected_id = encryptor('decrypt',$selected_id_enc);

		$status = $this->Members->delete_data($selected_id);
        if ($status) {
            $data = [
                'status' => 1,
                'status_message' => 'Successfully delete member',
                'q' => $status,
            ];
        } else {
            $data = [
                'status' => 0,
                'status_message' => 'Failed to delete member. Please try again.',
                'q' => $status,
            ];
        }
		
		echo json_encode($data);
	}


	public function ReturnValidContact($contact_no) {
		$contact_no = str_replace(array(" ", "-", ".", ",", "+"), "", $contact_no);
		if ( substr($contact_no, 0, 1) != "6" && !empty($contact_no) ) {
			$contact_no = "6".$contact_no;
		}

		return $contact_no;
	}
}
