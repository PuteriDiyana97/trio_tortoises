<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Controller extends My_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('settings/Users');
		$this->load->model('Logins');
		
		// user type id 1: Super Admin 2:Admin 3:operator 
	}

	public function index()
	{
		$data = array();
		$this->data = $data;
		$this->middle = 'settings/user';
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

		if ( in_array($this->session->curr_user_type_id, array(1,2)) )
		{
			$usertype_list = $this->user_type;

	        $no = $_POST['start'];
			$data = array();
			$list = $this->Users->get_datatables();

	        foreach ($list as $field) 
	        {
	            $no++;
	            $row = array();

	            $id = $field->id;
	            $id_enc = encryptor('encrypt',$id);

	            $user_type_id = $field->user_type;
	        	$user_type = ( in_array($user_type_id, $this->uac) ) ? $usertype_list[$user_type_id] : '';
	        	//pre($this->uac); die();
	            $last_login = display_datetime('DATETIME2', $field->last_login);

	            $row["id"] = $id_enc;
	            $row[] = $no;
	            $row[] = $user_type;
	            $row[] = $field->full_name;
	            $row[] = $field->email;
	            $row[] = $field->mobile_no;
	            $row[] = $last_login;
	            $row[] = '	<a href="user/view?ids='.$id_enc.'" class="btn_view" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="View" data-original-title="View" ><i class="fa fa-edit kt-font-brand"></i></a>&nbsp;&nbsp;
	            			<a href="javascript:void(0)" class="btn_delete" ids="'.$id_enc.'" data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete" ><i class="fa fa-trash kt-font-dangerous"></i></a>';
	 
	            $data[] = $row;
	        }
	 
	        $output = array(
	            "draw" => $_POST['draw'],
	            "recordsTotal" => $this->Users->count_all(),
	            "recordsFiltered" => $this->Users->count_filtered(),
	            "data" => $data,
	        );
	    }

        //output dalam format JSON
        echo json_encode($output);
	}

	public function save()
	{
		// pre($_POST); die();
		$rst = 0;
		$data = array();
		
		$msg = 'Invalid access';	

		if ( in_array($this->session->curr_user_type_id, array(1,2)) )
		{
			$selected_id_enc = $this->input->post('ids');
			$selected_id = encryptor('decrypt',$selected_id_enc);
			//pre($selected_id);
			//pre($_POST); die();
			$user_type_id = $this->input->post('type');
			$user_role = $this->input->post('role');
			$login_type_id = 1; // login web portal
			$user_name = $this->input->post('user_name');
			$user_password = $this->input->post('user_password');
			$user_password_confirmation = $this->input->post('user_password_confirmation');

			$user_password_enc = encryptor('encrypt',$user_password); 

			$full_name = $this->input->post('full_name');
			$email = $this->input->post('email');
			$mobile_no = $this->input->post('mobile_no');

			// check user_name exist or not from db logins
			$find_opt = array(
								'user_name' => $user_name,
							);

			$check_data = $this->Logins->check_data($selected_id, $find_opt);
			$exist_data = ( is_object($check_data) && !empty($check_data) ) ? $check_data->id : '';

			$error = 0;

	        if ( empty($exist_data) || $exist_data == 0 )
	        {
	        	$error = 0;
	        }
	        else
	        {
	        	$error++;
	        }

	        if ( $error == 0 )
			{
				if ( $selected_id == 0 )
				{
					//#Create Data
					// create user
					$data_create = array(
											'user_type'			    => $user_type_id,
											'full_name'				=> $full_name,
											'email'					=> $email,
											'mobile_no'				=> $mobile_no,
											'created'				=> getDateTime(),
											'updated'				=> getDateTime(),
											'active'				=> 1,
										);
					
					$user_id = $this->Users->create_data($data_create);

					if ( $user_id > 0 )
					{
						$user_id_enc = encryptor('encrypt',$user_id);
						// create login
						$data_create = array(
												'user_id'		=> $user_id,
												'login_type_id'	=> $login_type_id,
												'user_name'		=> $user_name,
												'user_password'	=> $user_password_enc,
												'created'		=> getDateTime(),
												'updated'		=> getDateTime(),
												'active'		=> 1,
										  	);
					
						$login_id = $this->Logins->create_data($data_create);

						for ($i=0; $i <count($user_role) ; $i++) { 
							$data_create = array(
												'user_id'		=> $user_id,
												'role_id'	    => $user_role[$i],
												'created'		=> getDateTime(),
												'active'		=> 1,
										  	);
							$role_id = $this->Logins->create_role($data_create);
						}

						if ( $login_id > 0 )
						{
							$rst = 1;
							$data = array('ids' => $user_id_enc);
							$msg = '';
						}
						else
						{
							// login not create then inactive user
							$data_update = array(
												'updated'	=> getDateTime(),
												'active'	=> 0,
												);
							$rst_update_user = $this->Users->update_data($user_id, $data_update);

							$rst = 0;
							$data = array('ids' => $user_id_enc);
							$msg = 'Data login not saved';
						}
					}
					else
					{
						$rst = 0;
						$data = array();
						$msg = 'Data user not saved';	
					}
				}
				else
				{
					//#Update Data
					$new_pswrd = $_REQUEST['user_password'];

					if (!empty($new_pswrd)) {

								$data_update = array(
													'user_type'				=> $user_type_id,
													'full_name'				=> $full_name,
													'email'					=> $email,
													'created'				=> getDateTime(),
													'updated'				=> getDateTime(),
													'active'		=> 1,
												);
								$rst_update_user = $this->Users->update_data($selected_id, $data_update);

			                if ( $rst_update_user > 0 ) 
			                {
			                	$user_id_enc = encryptor('encrypt',$rst_update_user);
								// update login
								$data_update = array(
														'user_password'	=> $user_password_enc,
														'updated'		=> getDateTime(),
														'active'		=> 1,
												  	);
							
								$update_id = $this->Logins->update_data($selected_id,$data_update);

								for ($i=0; $i < count($user_role) ; $i++) { 

									$data_remove = array(
														
														'updated'		=> getDateTime(),
														'active'		=> 0,
												  	);

									$remove_role = $this->Users->remove_role($selected_id,$user_role,$data_remove);
								    $check_role = $this->Users->check_role($selected_id,$user_role[$i]);

								    if(!empty( $check_role)){

								    	$data_update = array(
														
														'updated'		=> getDateTime(),
														'active'		=> 1,
												  	);
										$role_id = $this->Users->update_role($selected_id,$user_role[$i],$data_update);


								    }else{

								    	$data_update = array(
														'user_id'		=> $selected_id,
														'role_id'	    => $user_role[$i],
														'created'		=> getDateTime(),
														'active'		=> 1,
												  	);
										$role_id = $this->Logins->create_role($data_update);

								    }
									
								}

								if ( $update_id > 0 )
								{
									$rst = 1;
									$data = array('ids' => $user_id_enc);
									$msg = '';
								}
								else
								{
									// login not create then inactive user
									$data_update = array(
														'updated'	=> getDateTime(),
														'active'	=> 0,
														);
									$rst_update_user = $this->Users->update_data($user_id, $data_update);

									$rst = 0;
									$data = array('ids' => $user_id_enc);
									$msg = 'Data update not saved';
								}
			                }
							else
							{
								$rst = 0;
								$data = array();
								$msg = 'Data user not updated';	
							}
				}else{

					$data_update = array(
											'user_type'				=> $user_type_id,
											'full_name'				=> $full_name,
											'email'					=> $email,
											// 'mobile_no'				=> $mobile_no,
											'updated'				=> getDateTime(),
										);

	                $rst_update_user = $this->Users->update_data($selected_id, $data_update);

	                if ( $rst_update_user > 0 ) 
	                {
	                	// check login data already exist for selected user 
	                	$find_opt = array(
											'user_id'		=> $selected_id,
											'login_type_id' => $login_type_id,

										);

						$check_data = $this->Logins->check_data('', $find_opt);
						$login_id = ( is_object($check_data) && !empty($check_data) ) ? $check_data->id : '';


				        if ( empty($login_id) || $login_id == 0 )
				        {
				        	// data not exist then create login
							$data_create = array(
													'user_id'		=> $selected_id,
													'login_type_id'	=> $login_type_id,
													'user_name'		=> $user_name,
													'user_password'	=> $user_password_enc,
													'created'		=> getDateTime(),
													'updated'		=> getDateTime(),
													'active'		=> 1,
											  	);
						
							$login_id = $this->Logins->create_data($data_create);
				        }
				        else
				        {
				        	// data exist then update login
							$data_update = array(
													'updated'	=> getDateTime(),
											  	);

							if ( !empty($user_password) )
							{
								$data_update['user_password'] = $user_password_enc;
							}
						
							$rst_update_login = $this->Logins->update_data($login_id, $data_update);			        	
				        }


				        for ($i=0; $i < count($user_role) ; $i++) { 

									$data_remove = array(
														
														'updated'		=> getDateTime(),
														'active'		=> 0,
												  	);

									$remove_role = $this->Users->remove_role($selected_id,$user_role,$data_remove);
								    $check_role = $this->Users->check_role($selected_id,$user_role[$i]);
								 //pre($user_role[$i]); die();
								    if(!empty( $check_role)){

								    	$data_update = array(
														
														'updated'		=> getDateTime(),
														'active'		=> 1,
												  	);
										$role_id = $this->Users->update_role($selected_id,$user_role[$i],$data_update);
										//echo "update";

								    }else{

								    	$data_update = array(
														'user_id'		=> $selected_id,
														'role_id'	    => $user_role[$i],
														'created'		=> getDateTime(),
														'active'		=> 1,
												  	);
										$role_id = $this->Logins->create_role($data_update);
										//echo "insert";
								    }
									
								}
									//die();

						if ( $login_id > 0 )
						{
							$rst = 1;
							$data = array('ids' => $selected_id_enc);
							$msg = '';
						}
						else
						{
							$rst = 0;
							$data = array('ids' => $selected_id_enc);
							$msg = 'Data login not updated';
						}
	                }
					else
					{
						$rst = 0;
						$data = array();
						$msg = 'Data user not updated';	
					}
				}
				
					}
					
			}
			else
			{
				$rst = 0;
				$data = array();
				$msg = 'Username already exist. Please use another username';	
			}
		}

		if ( $rst == 1 )
		{
			$msg_status = 'success';
			$msg_title = 'Success!';
			$msg_content = $msg;

			 $data = [
                'status' => 1,
                'status_message' => 'Successful!',
                'q' => $rst,
            ];
		}
		else
		{
			$msg_status = 'error';
			$msg_title = 'Fail!';
			$msg_content = $msg;

			$data = [
                'status' => 0,
                'status_message' => 'Username already exist. Please use another username',
                'q' => $rst,
            ];
		}

		// sweet_alert($msg_status, $msg_title, $msg_content);
		// redirect('user');

		// $output = array(
		// 				'rst' 	=> $rst,
		// 				'data' 	=> $data,
		// 				'msg' => $msg
		// 				);
        echo json_encode($data);
        die();
	}

	public function create()
	{
		$data = array();
		$this->data = $data;
		$this->middle = 'settings/add_user';
    	$this->layout();
	}

	public function details()
	{
		$data = array();

		if ( in_array($this->session->curr_user_type_id, array(1,2)) )
		{
			$selected_id_enc = $this->input->post('ids');
			$selected_id = encryptor('decrypt',$selected_id_enc);
		
			$data = $this->Users->read_data_join($selected_id);
		}
		
		echo json_encode($data);
	}

	public function view()
	{	
		$data = array();
		$selected_id_enc = $this->input->get('ids');
		$selected_id = encryptor('decrypt',$selected_id_enc);
		//pre($selected_id_enc);
		$data['user_info'] = $this->Users->read_data($selected_id);
		
		$this->data = $data;
		//pre($data); die();
        $this->middle = 'settings/view_user';
        $this->layout();
	}

	public function checkbox()
	{	
		$data = array();
		$selected_id_enc = $this->input->get('ids');
		$selected_id = encryptor('decrypt',$selected_id_enc);
		//pre($selected_id_enc);
		$data['data']= $this->Users->read_checkbox($selected_id);

		$this->data = $data;
        $this->middle = 'settings/view_user';
        $this->layout();
	}

	public function delete()
	{
		$data = 0;

		if ( in_array($this->session->curr_user_type_id, array(1,2)) )
		{
			$selected_id = $this->input->post('ids');
			$selected_id_arr = array();

			if ( !empty($selected_id) )
			{
				$selected_id_arr = explode(',', $selected_id);
				array_walk($selected_id_arr, 'encryptor_multiple', 'decrypt'); // call function encryptor_multiple from helper
			}

			if ( is_array($selected_id_arr) && count($selected_id_arr) > 0 )
			{
				$rst_user = $this->Users->delete_data($selected_id_arr);
				$rst_login = $this->Logins->delete_data_by_column_value('user_id', $selected_id_arr);

				if ( $rst_user > 0 && $rst_login > 0 )
				{
					$data = 1;
				}
				else
				{
					$data = 0;
				}
			}
		}
		
		echo json_encode(array('rst'=>$data));
	}
}
