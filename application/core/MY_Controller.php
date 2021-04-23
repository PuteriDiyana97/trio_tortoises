<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller 
{ 
    //set project details
    var $project_year = '2020';
    var $project_name = 'Administrator System';
    var $project_owner = 'Star Glory Asia (M) Sdn. Bhd.';

    //set the class variable.
    var $template  = array();
    var $data      = array();

    /*
    # user type id
    1: Super Admin 
    2: Admin 
    3: Operator
    */

    var $user_type = array(1 => 'Superadmin', 'Admin', 'Operator');
    var $uac = array('1', '2', '3');

    public function __construct()
    {
        parent::__construct();

        $this->load->model('settings/Users');

        $this->project_year = '2020';
        $this->project_name = 'Administrator System';
        $this->project_owner = 'Star Glory Asia (M) Sdn. Bhd.';
        $this->uac = array('1', '2', '3');
        $this->user_type = array(1 => 'Superadmin', 'Admin', 'Operator');

        define("PATH_UPLOAD_FILES", "assets/upload_files/");
        define("PATH_CMS", "cms/");
        define("PATH_SETTINGS", "settings/");
        define("COMPULSORY", "<span class=\"kt-font-dangerous\">*</span>");
    }

    //Load layout    
    public function layout() 
    {
        if ( empty($this->session->curr_login_id) || $this->session->curr_login_id == '' )
        {
            $text = '<div class="alert alert-solid-info alert-bold fade show" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">Please Login!</div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="la la-close"></i></span>
                            </button>
                        </div>
                    </div>';
            $this->session->set_flashdata('login_result', $text);
            redirect('login');
            die();
        }
        $left_menu_array = array();
        $data['access_module'] = $access_module = $this->Users->module();
        $left_menu_array = array_merge($this->data, $data);
        $middle_array = array_merge($this->data, $data);

        // making template and send data to view.
        $this->template['index_header']   = $this->load->view('layout/index_header', $this->data, true);
        $this->template['index_top_menu']   = $this->load->view('layout/index_top_menu', $this->data, true);
        $this->template['index_left_menu']   = $this->load->view('layout/index_left_menu', $left_menu_array, true);
        $this->template['index_footer']   = $this->load->view('layout/index_footer', $this->data, true);
        $this->template['middle'] = $this->load->view($this->middle, $middle_array, true);
        $this->load->view('layout/index', $this->template);
    }
}

?>