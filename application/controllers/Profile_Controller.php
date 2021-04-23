<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_Controller extends My_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Users');
		$this->load->model('Logins');
		$this->load->model('Profiles');

		/*
		# user type id
		1: Super Admin 2: Admin 3:Operator 
		*/
	}

	public function index()
	{
		$data = array();

		$data['data'] = $this->Profiles->read_data($this->session->curr_user_id);
		$data['data_login'] = $this->Profiles->read_data_login($this->session->curr_user_id);

		$this->data = $data;
		//pre($data); die();
		$this->middle = 'profile';
    	$this->layout();	
	}

	public function save()
	{ 
		//pre($_POST);
		$selected_id_enc = $this->input->post('ids');

		$form = ['full_name'      => $_REQUEST['full_name'],
	            'mobile_no'       => $_REQUEST['contact_no'],
	            'email'           => $_REQUEST['email'],
	            'updated' => date('Y-m-d H:i:s'),
        ];
        
        $status = $this->Profiles->update_data($selected_id_enc,$form);
       // pre($form);

        if ($status) {
           
                $status = 'success';
                $status_message = 'Successfully update new details';
                $q = $status;
                $msg_title = 'Success!';
          
        } else {
                $status = 'error';
                $status_message = 'Failed to update new details. Please try again.';
                $q = $status;
                $msg_title = 'Error!';
        }

       	sweet_alert($status, $msg_title, $status_message);
		redirect('dashboard');
	}

	public function details()
	{
		$data = array();

		$data['data'] = $this->Profiles->read_data($this->session->curr_user_id);

		$this->data = $data;
		//pre($data); die();
		$this->middle = 'edit_profile';
    	$this->layout();
	}

	public function password()
	{
		$data = array();

		$data['data'] = $this->Profiles->read_data($this->session->curr_user_id);

		$this->data = $data;
		//pre($data); die();
		$this->middle = 'change_pswrd';
    	$this->layout();
		
	}

	public function change_password()
	{
		// pre($_POST); die();
		

		if($_POST['new_pswrd']==$_POST['confirm_pswrd'])
			{
				$db = $this->db;
				$db->select('user_password,user_name');
				$db->from('logins');
				$db->where('user_id',$this->session->curr_user_id);
				$db->limit(1);
				$result = $db->get()->row();

				$selected_id_enc = $this->input->post('ids');
				$enc_old_pwd = encryptor('encrypt',$_POST['current_pswrd']);

				$form = [
					    'user_password'  => $enc_old_pwd,
					    'updated' => date('Y-m-d H:i:s'),
				];
				        
				$status = $this->Profiles->update_logins($selected_id_enc,$form);

				if($result->user_password == $enc_old_pwd)
				{
					$data = array(
						"user_password"=>encryptor('encrypt',$_POST['new_pswrd']),
					);

					$this->db->where('user_id',$this->session->curr_user_id);
					$q = $this->db->update('logins',$data);
					
					$status = 'success';
	                $status_message = 'Successfully update new details';
	                $q = $status;
	                $msg_title = 'Success!';

				}
				else
				{
						$status = 'error';

		                $status_message = 'Old password is not correct. Please try again.';
		                $q = $status;
		                $msg_title = 'Error!';
		        }
				// exit();
			}
			else
			{
						$status = 'error';

		                $status_message = 'New password and Re-type password are not same!. Please try again.';
		                $q = $status;
		                $msg_title = 'Error!';

				
			}
		sweet_alert($status, $msg_title, $status_message);
		redirect('profile/password');
	}
}
