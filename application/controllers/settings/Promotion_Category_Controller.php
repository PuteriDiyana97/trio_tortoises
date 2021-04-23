<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promotion_Category_Controller extends My_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('settings/Promotion_categories');
	}

	public function index()
	{
		$data = array();

		$this->data = $data;
		$this->middle = 'settings/promotion_category';
    	$this->layout();	
	}
//$data['data'] = $this->Promotion_categories->read_data($selected_id);  pre($selected_id); die();
		
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
			$list = $this->Promotion_categories->get_datatables();

	        foreach ($list as $field) 
	        {
	            $row = array();

	            $id = $field->id;
	            $id_enc = encryptor('encrypt',$id);

	            $row["id"] = $id_enc;
	            $row[] = $field->priority_no;
	            $row[] = $field->category;
	            $row[] = '	<a href="javascript:void(0)" class="btn_view" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="View" data-original-title="View" ><i class="fa fa-edit kt-font-brand"></i></a>&nbsp;&nbsp;
	            			<a href="javascript:void(0)" class="btn_delete" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete" ><i class="fa fa-trash kt-font-dangerous"></i></a>';
	 
	            $data[] = $row;
	        }
	 //pre($field); die();
	        $output = array(
	            "draw" => $_POST['draw'],
	            "recordsTotal" => $this->Promotion_categories->count_all(),
	            "recordsFiltered" => $this->Promotion_categories->count_filtered(),
	            "data" => $data,
	        );
        //output dalam format JSON
        echo json_encode($output);
	}

	public function create()
    {
    	$data = array();

        $this->data = $data;
        $this->middle = 'settings/add_promotion_category';
        $this->layout();
    }

	public function insert()
	{
		$form = [
				'priority_no'=> $_REQUEST['priority_no'],
				'category'   => $_REQUEST['category'],
	            'created' => date('Y-m-d H:i:s'),
	            'updated' => date('Y-m-d H:i:s'),
        ];

        // echo json_encode($_REQUEST);die;
        $status = $this->Promotion_categories->insert($form);

        if ($status) {
            $data = [
                'status' => 1,
                'status_message' => 'Successfully added new category',
                'q' => $status,
            ];
        } else {
            $data = [
                'status' => 0,
                'status_message' => 'Failed to add new category. Please try again.',
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
		$data = $this->Promotion_categories->read_data($selected_id);
		
		echo json_encode($data);
	}

	public function update()
	{
		$selected_id_enc = $this->input->post('ids');
		$selected_id = encryptor('decrypt',$selected_id_enc);

		$form = [
				'priority_no'=> $_REQUEST['priority_no'],
				'category'   => $_REQUEST['category'],
	            'created'         => date('Y-m-d H:i:s'),
	            'updated'         => date('Y-m-d H:i:s'),
        ];

        $status = $this->Promotion_categories->update_data($selected_id, $form);
        if ($status) {
            $data = [
                'status' => 1,
                'status_message' => 'Successfully update category',
                'q' => $status,
            ];
        } else {
            $data = [
                'status' => 0,
                'status_message' => 'Failed to update category. Please try again.',
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

		$status = $this->Promotion_categories->delete_data($selected_id);
        if ($status) {
            $data = [
                'status' => 1,
                'status_message' => 'Successfully delete category',
                'q' => $status,
            ];
        } else {
            $data = [
                'status' => 0,
                'status_message' => 'Failed to delete category. Please try again.',
                'q' => $status,
            ];
        }
		
		echo json_encode($data);
	}
}
