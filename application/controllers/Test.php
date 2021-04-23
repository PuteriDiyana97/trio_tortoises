<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends My_Controller 
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

	public function test()
	{
		 
		 $msg_status = 'error';
		 $msg_title = 'Fail!';
		$msg_content = 'wwe';



		sweet_alert($msg_status, $msg_title, $msg_content);
		// redirect('user');
	}
}
