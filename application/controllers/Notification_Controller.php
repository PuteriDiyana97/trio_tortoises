<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_Controller extends My_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Notifications');
	}

	public function index()
	{
		$data = array();
		$selected_id_enc = $this->input->get('ids');
		$selected_id = encryptor('decrypt',$selected_id_enc);
		//pre($selected_id_enc);
		$data['member_list']= $this->Notifications->list_data($selected_id);

		$this->data = $data;
		$this->middle = 'notification';
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
			$list = $this->Notifications->get_datatables();
			//pre($list); die();
	        foreach ($list as $field) 
	        {
	            $no++;
	            $row = array();

	            $id = $field->id;
	            $id_enc = encryptor('encrypt',$id);
	            $show = $field->push_notification; //0:haven push 1:pushed
               
               	if ($show == 1) {
               		$show = 'Published';
               	}else{
               		$show = 'Not Publish';
               	}

	            $img_notification = $field->notification_image; //banner in view

	            if(!empty($img_notification)){
				  $img_notification = '<img class="img_advs" src="http://cloone.my/demo/starglory-admin/assets/upload_files/notification/'.$field->notification_image.'">';
				}else{
				   $img_notification = '';
				}
//date("d-m-Y", strtotime($field->start_date));
	            $row["id"] = $id_enc;
	            $row[] = $no;
	            $row[] = strtoupper($field->notification_title);          
	            $row[] = date("d-m-Y", strtotime($field->start_date));
	            $row[] = date("d-m-Y", strtotime($field->end_date));
	            $row[] = '	<a href="javascript:void(0)" class="btn_view" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="View" data-original-title="View" ><i class="fa fa-edit kt-font-brand"></i></a>&nbsp;&nbsp;
	            			<a href="javascript:void(0)" class="btn_delete" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete" ><i class="fa fa-trash kt-font-dangerous"></i></a>';
	 
	            $data[] = $row;
	        }
	 // pre($field); die();
	        $output = array(
	            "draw" => $_POST['draw'],
	            "recordsTotal" => $this->Notifications->count_all(),
	            "recordsFiltered" => $this->Notifications->count_filtered(),
	            "data" => $data,
	        );
        //output dalam format JSON
        echo json_encode($output);
	}

	public function create()
    {
    	$data = array();
    	$data['member_list']= $this->Notifications->list_data();

        $this->data = $data;
        //pre($data); die();
        $this->middle = 'add_notification';
        $this->layout();
    }

	public function insert()
	{
		//pre($_POST); die();
		$form = [
					'notification_title'         => $_REQUEST['notification_title'],
					'short_description'   	     => $_REQUEST['short_description'],
		            'long_description'   		 => $_REQUEST['long_description'],
					'notification_image' 		 => $_FILES['banner']['name'],
		            'start_date'                 => date('Y-m-d', strtotime($_REQUEST['start_date'])),
			        'end_date'                   => date('Y-m-d', strtotime($_REQUEST['end_date'])),
		            'created' 					 => date('Y-m-d H:i:s'),        
		        	'active'         			 => 1,
		        ];

		$notification_id = $status = $this->Notifications->insert($form);

		if ($_POST['member'][0] != 'All' ) {
		
				for ($i=0; $i<count($_POST['member']) ; $i++) 
		        { 
		            $member_code = $_POST['member'][$i];
				    $form1 = [
				    		'notification_id'			 => $notification_id,
							'notification_title'         => $_REQUEST['notification_title'],
							'short_description'   	     => $_REQUEST['short_description'],
				            'long_description'   		 => $_REQUEST['long_description'],
							'notification_image' 		 => $_FILES['banner']['name'],
				            'start_date'                 => date('Y-m-d', strtotime($_REQUEST['start_date'])),
			        		'end_date'                   => date('Y-m-d', strtotime($_REQUEST['end_date'])),
				            'contact_no'   				 => $member_code,
				            'created'                    => date('Y-m-d H:i:s'),        
				        	'active'                     => 1,
				        ];

			        $target_dir = "assets/upload_files/notification/";
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
					}
					if ($uploadOk == 0) {
					} else {
					    if (move_uploaded_file($_FILES["banner"]["tmp_name"], $target_file)) {
					    } else {   }
					}

			        // echo json_encode($_REQUEST);die;
			        
			        $status = $this->Notifications->insert1($form1);

			        if ($status) {
			            $data = [
			                'status' => 1,
			                'status_message' => 'Successfully added new notification',
			                'q' => $status,
			            ];
			        } else {
			            $data = [
			                'status' => 0,
			                'status_message' => 'Failed to add new notification. Please try again.',
			                'q' => $status,
			            ];
			        }
			        
			    }
			} else{

				$data_customer = $this->Notifications->insert_all();

				foreach($data_customer as $select_all){
		    			$contact_no[] = $select_all->contact_no;
		    		}

	    		$result = $contact_no;
	    		$selected_all=array_filter($result);

				for ($i=0; $i<count($selected_all) ; $i++) 
		        { 
		            $member_code = $selected_all[$i];
				    $form1 = [
				    		'notification_id'			 => $notification_id,
							'notification_title'         => $_REQUEST['notification_title'],
							'short_description'   	     => $_REQUEST['short_description'],
				            'long_description'   		 => $_REQUEST['long_description'],
							'notification_image' 		 => $_FILES['banner']['name'],
				            'start_date'                 => date('Y-m-d', strtotime($_REQUEST['start_date'])),
			        		'end_date'                   => date('Y-m-d', strtotime($_REQUEST['end_date'])),
				            'contact_no'   				 => $member_code,
				            'created' => date('Y-m-d H:i:s'),        
				        	'active'         => 1,
				        ];

			        $target_dir = "assets/upload_files/notification/";
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
					}
					if ($uploadOk == 0) {
					} else {
					    if (move_uploaded_file($_FILES["banner"]["tmp_name"], $target_file)) {
					    } else {   }
					}

			        // echo json_encode($_REQUEST);die;
			        
			        $status = $this->Notifications->insert1($form1);

			        if ($status) {
			            $data = [
			                'status' => 1,
			                'status_message' => 'Successfully added new notification',
			                'q' => $status,
			            ];
			        } else {
			            $data = [
			                'status' => 0,
			                'status_message' => 'Failed to add new notification. Please try again.',
			                'q' => $status,
			            ];
			        }
			        
			    }
			}
	    echo json_encode($data);
	}

	public function details()
	{
		$data = array();

		$selected_id_enc = $this->input->post('ids');
		$selected_id = encryptor('decrypt',$selected_id_enc);
		
		$data = $this->Notifications->read_data($selected_id);
		
		echo json_encode($data);
	}

	public function update()
	{
			$selected_id_enc = $this->input->post('ids');
			$selected_id = encryptor('decrypt',$selected_id_enc);
			$notification_image	= $_FILES['banner']['name'];

			$form = [
		            'notification_title'         => $_REQUEST['notification_title'],
		            'short_description'   	     => $_REQUEST['short_description'],
		            'long_description'   		 => $_REQUEST['long_description'],
		            'notification_image' 		 => $_FILES['banner']['name'],
		            'start_date'                 => date('Y-m-d', strtotime($_REQUEST['start_date'])),
			        'end_date'                   => date('Y-m-d', strtotime($_REQUEST['end_date'])),
		            'updated' => date('Y-m-d H:i:s'),
		            'active'         => 1,
	        ];

	         //Check whether empty picture
	        if ($notification_image ==''){
			  unset($form['notification_image']);
			}

			//pre($form1); die();
	        $target_dir = "assets/upload_files/notification/";
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
			//in kb
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
			}
			if ($uploadOk == 0) {
			} else {
			    if (move_uploaded_file($_FILES["banner"]["tmp_name"], $target_file)) {
			    } else {   }
			}

	        $notification_id = $status = $this->Notifications->update_data($selected_id, $form);
	        //pre($notification_id);

	        $form1 = [
	        		// 'notification_id'			 => $notification_id,
		            'notification_title'         => $_REQUEST['notification_title'],
		            'short_description'   	     => $_REQUEST['short_description'],
		            'long_description'   		 => $_REQUEST['long_description'],
		            'notification_image' 		 => $notification_image,
		            'start_date'                 => date('Y-m-d', strtotime($_REQUEST['start_date'])),
			        'end_date'                   => date('Y-m-d', strtotime($_REQUEST['end_date'])),
		            'updated' => date('Y-m-d H:i:s'),
		            'active'         => 1,
	        ];
	        //pre($form1);
	        //Check whether empty picture
	        if ($notification_image ==''){
			  unset($form1['notification_image']);
			}

	        $status = $this->Notifications->update_data1($selected_id, $form1);
	        
	        if ($status) {
	            $data = [
	                'status' => 1,
	                'status_message' => 'Successfully update notification',
	                'q' => $status,
	            ];
	        } else {
	            $data = [
	                'status' => 0,
	                'status_message' => 'Failed to update notification. Please try again.',
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

		$noti_det = $this->Notifications->notification_detail($selected_id);

		//pre($noti_det); die();
		$status = $this->Notifications->delete_data($selected_id);
		$status = $this->Notifications->delete_noti_receiver($noti_det->id);

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
            $config['upload_path']    = './assets/upload_files/notification/';                        
            $config['log_threshold']  = 1;
            $config['allowed_types']  = 'jpg|png|jpeg|gif';
            $config['max_size']       = '1300000'; // 0 = no file size limit
            $config['file_name']      = $timestamp."_".$_FILES["file"]["name"];          
            $config['overwrite']      = false;
            $this->load->library('upload', $config);
            $this->upload->do_upload('file');
            $upload_data   = $this->upload->data();
            $file_name     = $upload_data['file_name'];    
            
            echo base_url()."assets/upload_files/notification/".$file_name;
        }
    }
}
