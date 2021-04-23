<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Faq_Controller extends My_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('cms/Faq');
	}

	public function index()
	{
		$selected_id_enc = $this->input->post('ids');
		$id = encryptor('decrypt', $selected_id_enc);

		$data = array();
		$data['info'] = $this->Faq->read_data($id);

		$this->data = $data;
		//pre($data); die();
		$this->middle = 'cms/faq';
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
		$list = $this->Faq->get_datatables();

		foreach ($list as $field) {
			$row = array();

			$id = $field->id;
			$id_enc = encryptor('encrypt', $id);

			$row["id"] = $id_enc;
			$row[] = $field->title;
			$row[] = $field->created;
			$row[] = $field->updated;
			$row[] = '	<a href="javascript:void(0)" class="btn_view" ids="' . $id_enc . '" data-toggle="tooltip" data-placement="top" title="View" data-original-title="View" ><i class="fa fa-edit kt-font-brand"></i></a>';
			// <a href="javascript:void(0)" class="btn_delete" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete" ><i class="fa fa-trash kt-font-dangerous"></i></a>

			$data[] = $row;
		}
		//pre($field);die();

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Faq->count_all(),
			"recordsFiltered" => $this->Faq->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function details()
	{
		$selected_id_enc = $this->input->post('ids');
		$id = encryptor('decrypt', $selected_id_enc);

		$data = array();
		$data['info'] = $this->Faq->read_data($id);

		$this->data = $data;
		//pre($data); die();
		$this->middle = 'cms/view_faq';
		$this->layout();
	}

	public function update()
	{
		$form = [
			'description' => $_REQUEST['description'], //rawurlencode($_REQUEST['description'])
			'updated' => date('Y-m-d H:i:s'),
			'active'  => 1
		];

		$status = $this->Faq->update_data($form);
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

		echo json_encode($data);
	}

	// public function summernote_sync_image()
	// {
	// 	if (empty($_FILES['file'])) {
	// 		exit();
	// 	} else {
	// 		$timestamp                = date('YmdHis');
	// 		$config['upload_path']    = './assets/upload_files/faq/';
	// 		$config['log_threshold']  = 1;
	// 		$config['allowed_types']  = 'jpg|png|jpeg|gif';
	// 		$config['max_size']       = '1300000'; // 0 = no file size limit
	// 		$config['file_name']      = $timestamp . "_" . $_FILES["file"]["name"];
	// 		$config['overwrite']      = false;
	// 		$this->load->library('upload', $config);
	// 		$this->upload->do_upload('file');
	// 		$upload_data   = $this->upload->data();
	// 		$file_name     = $upload_data['file_name'];

	// 		echo base_url() . "assets/upload_files/faq/" . $file_name;
	// 	}
	// }
}