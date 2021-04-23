<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Start_Controller extends My_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('settings/Users');
		$this->load->model('Logins');
		$this->load->model('Dashboard');

		/* # user type id
		1: Super Admin 2: Admin 3:operator 
		*/
	}

	public function index()
	{
		$data = array();

		$genderQuery =  $this->db->query("
			SELECT 'Male' as gender, COUNT(gender) as total
			FROM data_customer WHERE gender = 'Male' AND gender = 'male'
			AND active = 1
			union (SELECT 'Female' as gender, COUNT(gender) as total
			FROM data_customer WHERE gender = 'Female' AND gender = 'female' 
			AND active = 1)"); 
 
      	$data['gender'] = $genderQuery->result();

      		$nationalityQuery =  $this->db->query("
			SELECT 'Malaysian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'Malaysia' AND country = 'MALAYSIA' AND country = 'malaysia'
			AND active = 1

			union (SELECT 'Afghan' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'AFGHANISTAN' AND active = 1)
			union (SELECT 'Albanian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'ALBANIA'AND active = 1)
			union (SELECT 'Algerian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'ALGERIA' AND active = 1)
			union (SELECT 'Argentinian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'ARGENTINA' AND active = 1)
			union (SELECT 'Australian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'AUSTRALIA' AND active = 1)
			union (SELECT 'Austrian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'AUSTRIA' AND active = 1)
			union (SELECT 'Bangladeshi' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'BANGLADESH' AND active = 1)
			union (SELECT 'Belgian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'BELGIUM' AND active = 1)
			union (SELECT 'Bolivian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'BOLIVIA' AND active = 1)
			union (SELECT 'Batswana' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'BOTSWANA'AND active = 1)
			union (SELECT 'Brazilian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'BRAZIL' AND active = 1)
			union (SELECT 'Bulgarian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'BULGARIA' AND active = 1)
			union (SELECT 'Cambodian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'CAMBODIA' AND active = 1)
			union (SELECT 'Cameroonian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'CAMEROON' AND active = 1)
			union (SELECT 'Canadian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'CANADA' AND active = 1)
			union (SELECT 'Chilean' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'CHILE' AND active = 1)
			union (SELECT 'Chinese' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'CHINA' AND active = 1)
			union (SELECT 'Colombian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'COLUMBIA'AND active = 1)
			union (SELECT 'Costa Rican' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'COSTA RICA' AND active = 1)
			union (SELECT 'Croatian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'CROATIA' AND active = 1)
			union (SELECT 'Cuban' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'CUBA' AND active = 1)
			union (SELECT 'Czech' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'CZECH REPUBLIC' AND active = 1)
			union (SELECT 'Danish' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'DENMEARK' AND active = 1)
			union (SELECT 'Dominican' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'DOMINICAN REPUBLIC' AND active = 1)
			union (SELECT 'Ecuadorian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'ECUADOR' AND active = 1)
			union (SELECT 'Egyptian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'EGYPT'AND active = 1)
			union (SELECT 'Salvadorian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'EL SAVADOR' AND active = 1)
			union (SELECT 'English' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'ENGLAND' AND active = 1)
			union (SELECT 'Estonian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'ESTONIA' AND active = 1)
			union (SELECT 'Ethiopian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'ETHIOPIA' AND active = 1)
			union (SELECT 'Fijian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'FIJI' AND active = 1)
			union (SELECT 'Finnish' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'FINLAND' AND active = 1)

			union (SELECT 'French' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'FRANCE' AND active = 1)
			union (SELECT 'German' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'GERMANY'AND active = 1)
			union (SELECT 'Ghanaian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'GHANA' AND active = 1)
			union (SELECT 'Greek' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'GREECE' AND active = 1)
			union (SELECT 'Guatemalan' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'GUATEMALA' AND active = 1)
			union (SELECT 'Haitian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'HAITI' AND active = 1)
			union (SELECT 'Honduran' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'HONDURAS' AND active = 1)
			union (SELECT 'Hungarian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'HUNGARY' AND active = 1)
			union (SELECT 'Icelandic' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'ICELAND' AND active = 1)
			union (SELECT 'Indian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'INDIA'AND active = 1)
			union (SELECT 'Indonesian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'INDONESIA' AND active = 1)
			union (SELECT 'Iranian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'IRAN' AND active = 1)
			union (SELECT 'Iraqi' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'IRAQ' AND active = 1)
			union (SELECT 'Irish' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'IRELAND' AND active = 1)
			union (SELECT 'Italian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'ITALY' AND active = 1)
			union (SELECT 'Jamaican' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'JAMAICA'AND active = 1)
			union (SELECT 'Japanese' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'JAPAN' AND active = 1)
			union (SELECT 'Jordanian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'JORDAN' AND active = 1)
			union (SELECT 'Kenyan' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'KENYA' AND active = 1)
			union (SELECT 'Kuwaiti' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'KUWAIT' AND active = 1)
			union (SELECT 'Lao' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'LAOS' AND active = 1)
			union (SELECT 'Latvian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'LATVIA' AND active = 1)
			union (SELECT 'Lebanese' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'LEBANON' AND active = 1)
			union (SELECT 'Libyan' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'LIBYA'AND active = 1)
			union (SELECT 'Lithuanian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'LITHUANIA' AND active = 1)
			union (SELECT 'Malagasy' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'MADAGASCAR' AND active = 1)
			union (SELECT 'Malian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'MALI' AND active = 1)
			union (SELECT 'Maltese' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'MALTA' AND active = 1)
			union (SELECT 'Mexican' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'MEXICO' AND active = 1)

			union (SELECT 'Mongolian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'MONGOLIA' AND active = 1)
			union (SELECT 'Moroccan' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'MOROCCO'AND active = 1)
			union (SELECT 'Mozambican' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'MOZAMBIQUE' AND active = 1)
			union (SELECT 'Namibian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'NAMIBIA' AND active = 1)
			union (SELECT 'Nepalese' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'NEPAL' AND active = 1)
			union (SELECT 'Dutch' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'NETHERLANDS' AND active = 1)
			union (SELECT 'New Zealand' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'NEW ZEALAND' AND active = 1)
			union (SELECT 'Nicaraguan' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'NICARAGUA' AND active = 1)
			union (SELECT 'Nigerian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'NIGERIA' AND active = 1)
			union (SELECT 'Norwegian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'NORWAY'AND active = 1)
			union (SELECT 'Pakistani' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'PAKISTAN' AND active = 1)
			union (SELECT 'Panamanian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'PANAMA' AND active = 1)
			union (SELECT 'Paraguayan' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'PARAGUAY' AND active = 1)
			union (SELECT 'Peruvian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'PERU' AND active = 1)
			union (SELECT 'Philippine' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'PHILIPPINES' AND active = 1)
			union (SELECT 'Polish' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'POLAND'AND active = 1)
			union (SELECT 'Portuguese' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'PORTUGAL' AND active = 1)
			union (SELECT 'Romanian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'ROMANIA' AND active = 1)
			union (SELECT 'Russian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'RUSSIA' AND active = 1)
			union (SELECT 'Saudi' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'SAUDI ARABIA' AND active = 1)
			union (SELECT 'Scottish' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'SCOTLAND' AND active = 1)
			union (SELECT 'Senegalese' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'SENEGAL' AND active = 1)
			union (SELECT 'Serbian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'SERBIA' AND active = 1)
			union (SELECT 'Singaporean' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'SINGAPORE'AND active = 1)
			union (SELECT 'Slovak' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'SLOVAKIA' AND active = 1)
			union (SELECT 'South African' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'SOUTH AFRICA' AND active = 1)
			union (SELECT 'Korean' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'SOUTH KOREA' AND active = 1)
			union (SELECT 'Spanish' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'SPAIN' AND active = 1)
			union (SELECT 'Sri Lankan' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'SRI LANKAN' AND active = 1)
			union (SELECT 'Sudanese' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'SUDAN' AND active = 1)

			union (SELECT 'Swedish' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'SWEDEN'AND active = 1)
			union (SELECT 'Swiss' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'SWITZERLAND' AND active = 1)
			union (SELECT 'Syrian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'SYRIA' AND active = 1)
			union (SELECT 'Taiwanese' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'TAIWAN' AND active = 1)
			union (SELECT 'Tajikistani' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'TAJIKISTAN' AND active = 1)
			union (SELECT 'Thai' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'THAILAND' AND active = 1)
			union (SELECT 'Tongan' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'TONGA'AND active = 1)
			union (SELECT 'Tunisian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'TUNISIA' AND active = 1)
			union (SELECT 'Turkish' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'TURKEY' AND active = 1)
			union (SELECT 'Ukrainian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'UKRAINE' AND active = 1)
			union (SELECT 'Emirati' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'UNITED ARAB EMIRATES' AND active = 1)
			union (SELECT 'British' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'UNITED KINGDOM' AND active = 1)
			union (SELECT 'American' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'UNITED STATES' AND active = 1)
			union (SELECT 'Uruguayan' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'URUGUAY' AND active = 1)
			union (SELECT 'Venezuelan' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'VENEZUELA'AND active = 1)
			union (SELECT 'Vietnamese' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'VIETNAM' AND active = 1)
			union (SELECT 'Welsh' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'WALES' AND active = 1)
			union (SELECT 'Zambian' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'ZAMBIA' AND active = 1)
			union (SELECT 'Zimbabwean' as nationality, COUNT(country) as total
			FROM data_customer WHERE country = 'ZIMBABWE' AND active = 1)"); 

 
      	$data['nationality'] = $nationalityQuery->result();

      	$total_spend_genderQuery =  $this->db->query("
			SELECT a.gender as gender,SUM(b.points) as point_used
			FROM data_customer_points b
			LEFT JOIN data_customer a ON a.contact_no = b.contact_no
			WHERE b.point_type = 0
			AND  a.active= 1
			GROUP BY a.gender"); 
      	
      	$data['total_spend_gender'] = $total_spend_genderQuery->result();

      	$total_spend_nationalityQuery =  $this->db->query("
			SELECT a.country as nationality,SUM(b.points) as point_used,
			CASE
			WHEN a.country = 'Malaysia' AND a.country = 'MALAYSIA' THEN 'Malaysian'
			WHEN a.country = 'Singapore' AND a.country = 'SINGAPORE'  THEN 'Singaporean'
			WHEN a.country = 'Philippines' AND a.country = 'PHILIPPINES'  THEN 'Filipino'
			END AS nationality
			FROM data_customer_points b
			LEFT JOIN data_customer a ON a.contact_no = b.contact_no
			WHERE b.point_type = 0
			AND  a.active = 1
			GROUP BY a.country"); 
 
      	$data['total_spend_nationality'] = $total_spend_nationalityQuery->result();

		$data['member_day']    = $this->Dashboard->member_day();
		$data['member_week']   = $this->Dashboard->member_week();
		$data['member_month']  = $this->Dashboard->member_month();
		$data['earn_day']      = $this->Dashboard->earn_day();
		$data['earn_week']     = $this->Dashboard->earn_week();
		$data['earn_month']    = $this->Dashboard->earn_month();
		$data['claim_day']     = $this->Dashboard->claim_day();
		$data['claim_week']    = $this->Dashboard->claim_week();
		$data['claim_month']   = $this->Dashboard->claim_month();
		$data['redeem_day']    = $this->Dashboard->redeem_day();
		$data['redeem_week']   = $this->Dashboard->redeem_week();
		$data['redeem_month']  = $this->Dashboard->redeem_month();

		$monthQuery =  $this->db->query("
			SELECT COUNT(id) as count,DAY(created) as day_date 
			FROM data_customer 
			WHERE MONTH(created)  = '" . date('m') . "'
        	AND YEAR(created) = '" . date('Y') . "'
      		GROUP BY DAY(created)"); 
 
      	$data['month_wise'] = $monthQuery->result();
  
      	$dayQuery = $this->db->query("
		    SELECT COUNT(id) as count, DAYNAME(created) as day_of_week
		    FROM data_customer
		    WHERE WEEK(created, 3) = '" . date('W')."'
        	AND YEAR(created) = '" . date('Y') . "'
      		GROUP BY DAYNAME(created)"); 
 
		//$data['day_wise'] = $dayQuery->result();
		$data['day_wise'] = $q_day_wise = $dayQuery->result();

		$weekday_text = array(
			"Monday",
			"Tuesday",
			"Wednesday",
			"Thursday",
			"Friday",
			"Saturday",
			"Sunday",
		);

		$new_day_wise = array();
		foreach($weekday_text as $r_weekday)
		{
			//default value
			$assign_count = 0;
			$assign_day = $r_weekday;

			//cari value dari result DB
			foreach($q_day_wise as $r_day_wise)
			{
				//default value
				$assign_count = 0;
				$assign_day = $r_weekday;

				//klu jumpe, assign pd variable
				if($r_day_wise->day_of_week == $r_weekday)
				{
					$assign_count = $r_day_wise->count;
					$assign_day = $r_day_wise->day_of_week;
					break;
				}
			}
			$new_day_wise[] = array(
				"count"=>$assign_count,
				"day_of_week"=>$assign_day,
			);
		}

		$new_day_wise = json_encode($new_day_wise);
		$new_day_wise = json_decode($new_day_wise);

		$data['new_day_wise'] = $new_day_wise;


		$this->data = $data;
		//pre($data['total_spend_gender']); die();
		$this->middle = 'dashboard';
    	$this->layout();
	}

	function login()
	{	
		$data = array();

		$array_session = array('curr_login_id', 'curr_user_id', 'curr_user_type_id', 'curr_user_name', 'curr_full_name', 'curr_logged_in', 'user_type');
		$this->session->unset_userdata($array_session);
		$this->load->view('login', $data);
	}
	
	function logout()
	{
		$curr_login_id = $this->session->curr_login_id; 
		$curr_user_id = $this->session->curr_user_id; 

		$data_update_logout = array(
									'login_now'	=> 0,
									'updated'	=> getDateTime(),
									);

		$data_update_logout = $this->Logins->update_data($curr_login_id, $data_update_logout);

		$array_session = array('curr_login_id', 'curr_user_id', 'curr_user_type_id', 'curr_user_name', 'curr_full_name', 'curr_logged_in','user_type');
		$this->session->unset_userdata($array_session);
		redirect('login');
	}

	function login_submit()
	{
		$login_type = 1; // 1: Web Portal, 2: Google Account
		$user_name = trim($this->input->post('user_name'));
		$user_password = trim($this->input->post('user_password'));
		$user_type = trim($this->input->post('type'));  //1:superadmin 2:admin 3:operator
		$remember = $this->input->post('remember');
		$remember = !empty($remember) ? 1 : 0; 

		$this->session->set_flashdata('login_user', $user_name);

		if ( !empty($user_name) && !empty($user_password) )
		{
			$login_result = $this->Logins->login($login_type, $user_name, $user_password, $user_type, $this->uac);
			//pre($login_result); die();
			if ( !empty($login_result) )
			{
				$data = array(
							    'curr_login_id'  		 => $login_result->id,
							    'curr_user_id'  		 => $login_result->user_id,
							    'curr_user_type_id' 	 => $login_result->user_type_id,
							    'curr_user_name'		 => $login_result->user_name,
							    'curr_full_name'		 => $login_result->full_name,
							    'user_type'				 => $login_result->user_type,
							    'curr_logged_in' 		 => TRUE
							);
				
				if ( empty($login_result->first_login) || $login_result->first_login == NULL ) 
				{
					$data_update_login = array(
												'login_now'		=> 1,
												'first_login'	=> getDateTime(),
												'last_login'	=> getDateTime(),
												'remember'		=> $remember,
												'updated' 		=> getDateTime(),
												);
					
				} 
				else 
				{
					$data_update_login = array(
												'login_now'		=> 1,
												'last_login'	=> getDateTime(),
												'remember'		=> $remember,
												'updated'		=> getDateTime(),
												);
				}
				
				$data_update_login = $this->Logins->update_data($login_result->id, $data_update_login);
				
				$this->session->set_userdata($data);
				
				if ( in_array($login_result->user_type_id, $this->uac) )
				{
					$notis_type = 'success';
					$notis_title = 'Login Successful';
					$notis_msg = 'Welcome '.$login_result->full_name;

					sweet_alert($notis_type, $notis_title, $notis_msg);
					redirect('dashboard');
				}
				else
				{
					$text = '<div class="alert alert-solid-danger alert-bold fade show" role="alert">
                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                            <div class="alert-text">Login Fail! Please try again.</div>
                            <div class="alert-close">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="la la-close"></i></span>
                                </button>
                            </div>
                        </div>';
					$this->session->set_flashdata('login_result', $text);
					redirect('login');
				}
			}
			else
			{
		        $text = '<div class="alert alert-solid-warning alert-bold fade show" role="alert">
                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                            <div class="alert-text">Invalid Username or Password!</div>
                            <div class="alert-close">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="la la-close"></i></span>
                                </button>
                            </div>
                        </div>';
				$this->session->set_flashdata('login_result', $text);
				redirect('login');
			}
		}
		else 
		{
			$text = '<div class="alert alert-solid-warning alert-bold fade show" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">Enter Username, Password</div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="la la-close"></i></span>
                            </button>
                        </div>
                    </div>';
			$this->session->set_flashdata('login_result', $text);
			redirect('login');
		}
	}

	function forgot_password()
	{
		$array_session = array('curr_login_id', 'curr_user_id', 'curr_user_type_id', 'curr_user_name', 'curr_full_name', 'curr_logged_in');
		$this->session->unset_userdata($array_session);

		$this->load->view('forgot_password');
	}
}
